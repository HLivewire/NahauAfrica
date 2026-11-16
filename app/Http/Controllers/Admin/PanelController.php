<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Role;
use App\Models\User;
use App\Nahau\Panel;
use App\Nahau\Stories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

/** NahauAfrica admin shell: dashboard, users and roles, my profile, my password. */
class PanelController extends Controller
{
    private function view(Request $r, string $name, array $data = [], string $title = 'Admin')
    {
        // Modal requests get only the partial; direct visits get the partial inside the shell.
        return $r->ajax()
            ? view('nahau-admin.'.$name, $data)
            : view('nahau-admin.page', ['partial' => 'nahau-admin.'.$name, 'data' => $data, 'title' => $title]);
    }

    public function dashboard(Request $r)
    {
        if (! Panel::letter()) {
            return app(AdminController::class)->maanDashboard();   // other legacy roles keep the old screen
        }

        $published = Stories::query()->count();
        $languages = DB::table('nahau_story_meta as m')->join('news', 'news.id', '=', 'm.news_id')->where('news.status', 1)
            ->select('m.language', DB::raw('count(*) as c'))->groupBy('m.language')->pluck('c', 'language')->all();
        $months = [];
        for ($i = 5; $i >= 0; $i--) {
            $d = now()->subMonths($i);
            $months[] = [$d->translatedFormat('M'), News::where('status', 1)->whereYear('date', $d->year)->whereMonth('date', $d->month)->count()];
        }
        $top = News::where('status', 1)->where('viewers', '>', 0)->orderByDesc('viewers')->take(6)->get(['title', 'viewers'])->map(fn ($n) => [Str::limit($n->title, 34), (int) $n->viewers])->all();

        $d = [
            'published' => $published,
            'drafts' => News::where('status', 0)->count(),
            'views' => (int) News::where('status', 1)->sum('viewers'),
            'subs' => \App\Models\NahauSubscriber::whereNotNull('confirmed_at')->whereNull('unsubscribed_at')->count(),
            'opps' => \App\Models\NahauOpportunity::open()->count(),
            'oppsUnverified' => \App\Models\NahauOpportunity::whereNull('verified_by')->count(),
            'newSubs' => \App\Models\NahauSubmission::where('status', 'new')->count(),
            'newMsgs' => \App\Models\NahauMessage::where('status', 'new')->count(),
            'newOpp' => \App\Models\NahauOpportunitySubmission::where('status', 'new')->count(),
            'authors' => \App\Models\NahauAuthor::count(),
            'languages' => [['Kiswahili', (int) ($languages['sw'] ?? 0)], ['English', (int) ($languages['en'] ?? 0)]],
            'months' => $months, 'top' => $top,
            'pending' => \App\Models\NahauSubmission::where('status', 'new')->latest()->take(5)->get(),
        ];

        return view('nahau-admin.dashboard', $d + ['canInbox' => Panel::canRes('submissions')]);
    }

    public function classic()
    {
        return app(AdminController::class)->maanDashboard();
    }

    /* ---------------- users and roles (Administrator only) ---------------- */

    private function staffRoleSlugs(): array
    {
        return collect(Panel::ROLES)->except('C')->flatMap(fn ($r) => [$r[1][0]])->merge(['contributor'])->values()->all();
    }

    public function users(Request $r)
    {
        $users = User::with('roles')->whereHas('roles', fn ($q) => $q->whereIn('slug', collect(Panel::ROLES)->flatMap(fn ($x) => $x[1])->all()))
            ->orderBy('first_name')->get();

        return view('nahau-admin.users', ['users' => $users, 'admins' => $this->adminCount()]);
    }

    private function adminCount(): int
    {
        return User::whereHas('roles', fn ($q) => $q->whereIn('slug', ['super-admin', 'admin']))->where('is_active', 1)->count();
    }

    private function roleOptions(): array
    {
        return ['admin' => 'Administrator', 'editor' => 'Editor-in-Chief', 'section-editor' => 'Section editor', 'translator' => 'Translator', 'contributor' => 'Contributor'];
    }

    public function userCreate(Request $r)
    {
        return $this->view($r, 'user-form', ['row' => null, 'roles' => $this->roleOptions()], 'Alika mtumiaji');
    }

    public function userStore(Request $r)
    {
        $data = $r->validate([
            'first_name' => 'required|max:100', 'last_name' => 'nullable|max:100',
            'email' => 'required|email|max:255|unique:users,email',
            'role' => ['required', Rule::in(array_keys($this->roleOptions()))],
        ]);
        $temp = Str::password(12, symbols: false);
        $u = new User;
        $u->forceFill([
            'first_name' => $data['first_name'], 'last_name' => $data['last_name'] ?? '', 'email' => $data['email'],
            'user_name' => Str::slug($data['first_name']).'-'.Str::lower(Str::random(4)),
            'password' => Hash::make($temp), 'must_change_password' => true, 'is_active' => 1,
            'user_type' => Panel::USER_TYPE[$data['role']] ?? '0',
        ])->save();
        $this->setRole($u, $data['role']);

        return response()->json(['message' => 'Mtumiaji ameongezwa', 'text' => "Nenosiri la muda: {$temp} — atalazimika kulibadilisha akiingia. Mipango ya barua pepe bado haijawashwa, mpe mwenyewe.", 'stay' => false]);
    }

    public function userEdit(Request $r, User $user)
    {
        return $this->view($r, 'user-form', ['row' => $user, 'roles' => $this->roleOptions()], 'Badilisha role');
    }

    private function setRole(User $u, string $slug): void
    {
        $role = Role::where('slug', $slug)->firstOrFail();
        $u->roles()->sync([$role->id]);
        $u->forceFill(['user_type' => Panel::USER_TYPE[$slug] ?? '0'])->save();
    }

    public function userUpdate(Request $r, User $user)
    {
        $data = $r->validate(['role' => ['required', Rule::in(array_keys($this->roleOptions()))], 'is_active' => 'nullable|boolean']);
        $wasAdmin = Panel::isAdmin($user);
        $stillAdmin = $data['role'] === 'admin';
        $active = $r->boolean('is_active', true);
        if ($wasAdmin && (! $stillAdmin || ! $active) && $this->adminCount() <= 1) {
            return response()->json(['message' => 'Administrator wa mwisho hawezi kushushwa wala kuzimwa.'], 422);
        }
        if ($user->id === auth()->id() && ! $stillAdmin) {
            return response()->json(['message' => 'Huwezi kujishusha mwenyewe. Mwombe Administrator mwingine.'], 422);
        }
        $this->setRole($user, $data['role']);
        $user->forceFill(['is_active' => $active ? 1 : 0])->save();

        return response()->json(['message' => 'Role imebadilishwa']);
    }

    public function userDestroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return response()->json(['message' => 'Huwezi kujifuta mwenyewe.'], 422);
        }
        if (Panel::isAdmin($user) && $this->adminCount() <= 1) {
            return response()->json(['message' => 'Administrator wa mwisho hawezi kufutwa.'], 422);
        }
        if (News::where('user_id', $user->id)->orWhere('reporter_id', $user->id)->exists()) {
            $user->roles()->detach();
            $user->forceFill(['is_active' => 0])->save();

            return response()->json(['message' => 'Amezimwa (ana hadithi, kwa hiyo hajafutwa kabisa)']);
        }
        $user->roles()->detach();
        $user->delete();

        return response()->json(['message' => 'Mtumiaji ameondolewa']);
    }

    /* ---------------- my profile and password ---------------- */

    public function profile(Request $r)
    {
        return $this->view($r, 'profile', ['u' => auth()->user()], 'Wasifu wangu');
    }

    public function profileSave(Request $r)
    {
        $u = auth()->user();
        $data = $r->validate(['first_name' => 'required|max:100', 'last_name' => 'nullable|max:100', 'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($u->id)], 'phone' => 'nullable|max:50']);
        $data['last_name'] = $data['last_name'] ?? '';
        $u->forceFill($data)->save();

        return response()->json(['message' => 'Wasifu umehifadhiwa']);
    }

    public function password(Request $r)
    {
        return $this->view($r, 'password', ['forced' => (bool) auth()->user()->must_change_password], 'Badilisha nenosiri');
    }

    public function passwordSave(Request $r)
    {
        $u = auth()->user();
        $r->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', 'min:10', 'regex:/\d/', 'different:current_password'],
        ], [
            'password.min' => 'Nenosiri jipya liwe na angalau herufi 10.', 'password.regex' => 'Weka angalau namba moja.',
            'password.confirmed' => 'Manenosiri mapya hayafanani.', 'password.different' => 'Nenosiri jipya lazima litofautiane na la sasa.',
        ]);
        if (! Hash::check($r->current_password, $u->password)) {
            return response()->json(['message' => 'Nenosiri la sasa si sahihi.', 'errors' => ['current_password' => ['Nenosiri la sasa si sahihi.']]], 422);
        }
        $u->forceFill(['password' => Hash::make($r->password), 'must_change_password' => false])->save();
        $r->session()->forget('force_pw');

        return response()->json(['message' => 'Nenosiri limebadilishwa', 'text' => 'Tumia nenosiri jipya utakapoingia tena.']);
    }
}
