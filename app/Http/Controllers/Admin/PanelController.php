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

        $d += $this->analytics($r);

        return view('nahau-admin.dashboard', $d + ['canInbox' => Panel::canRes('submissions'), 'full' => in_array(Panel::letter(), ['A', 'E'], true)]);
    }

    /** Date-range analytics: reads per day, countries, most-read, returning readers, monthly stories. */
    private function analytics(Request $r): array
    {
        $range = in_array((int) $r->query('range'), [7, 30, 90, 365], true) ? (int) $r->query('range') : 30;
        $to = now()->endOfDay();
        $from = now()->subDays($range - 1)->startOfDay();
        $prevFrom = $from->copy()->subDays($range);
        $has = \Illuminate\Support\Facades\Schema::hasTable('nahau_reads');
        $reads = fn () => DB::table('nahau_reads');

        // reads + unique readers per bucket (day, or month for the 1-year view)
        $labels = $a = $b = [];
        if ($range <= 90) {
            $byDay = $has ? $reads()->whereBetween('day', [$from->toDateString(), $to->toDateString()])
                ->select('day', DB::raw('count(*) as c'), DB::raw('count(distinct visitor) as u'))->groupBy('day')->get()->keyBy('day') : collect();
            for ($t = $from->copy(); $t <= $to; $t->addDay()) {
                $row = $byDay[$t->toDateString()] ?? null;
                $labels[] = $t->format('d M'); $a[] = (int) ($row->c ?? 0); $b[] = (int) ($row->u ?? 0);
            }
        } else {
            for ($i = 11; $i >= 0; $i--) {
                $m = now()->subMonths($i);
                $q = $has ? $reads()->whereYear('day', $m->year)->whereMonth('day', $m->month) : null;
                $labels[] = $m->translatedFormat('M'); $a[] = $q ? (int) $q->count() : 0; $b[] = $q ? (int) $q->distinct()->count('visitor') : 0;
            }
        }
        $uniq = fn ($f, $t) => $has ? (int) $reads()->whereBetween('day', [$f->toDateString(), $t->toDateString()])->distinct()->count('visitor') : 0;
        $uNow = $uniq($from, $to); $uPrev = $uniq($prevFrom, $from->copy()->subDay());
        $pubNow = News::where('status', 1)->whereBetween('date', [$from->toDateString(), $to->toDateString()])->count();
        $pubPrev = News::where('status', 1)->whereBetween('date', [$prevFrom->toDateString(), $from->copy()->subDay()->toDateString()])->count();

        $perDay = fn ($model, $col, $status = null) => collect(range(6, 0))->map(fn ($i) => $model::whereDate($col, now()->subDays($i))->when($status !== null, fn ($q) => $q->where('status', $status))->count())->all();

        $countries = $has ? $reads()->whereBetween('day', [$from->toDateString(), $to->toDateString()])->whereNotNull('country')
            ->select('country', DB::raw('count(distinct visitor) as c'))->groupBy('country')->orderByDesc('c')->get() : collect();
        $names = ['TZ' => 'Tanzania', 'KE' => 'Kenya', 'UG' => 'Uganda', 'NG' => 'Nigeria', 'RW' => 'Rwanda', 'ZA' => 'South Africa', 'GH' => 'Ghana', 'ET' => 'Ethiopia', 'US' => 'United States', 'GB' => 'United Kingdom'];
        $cList = $countries->take(4)->map(fn ($c) => [$names[$c->country] ?? $c->country, (int) $c->c])->all();
        if ($countries->count() > 4) {
            $cList[] = ['Nyingine', (int) $countries->slice(4)->sum('c')];
        }

        $mostRead = $has ? $reads()->join('news', 'news.id', '=', 'nahau_reads.news_id')->whereBetween('day', [$from->toDateString(), $to->toDateString()])
            ->select('news.title', 'nahau_reads.language', DB::raw('count(*) as c'))->groupBy('news.id', 'news.title', 'nahau_reads.language')->orderByDesc('c')->take(5)->get()
            ->map(fn ($x) => [Str::limit($x->title, 48), strtoupper($x->language === 'en' ? 'en' : 'sw'), (int) $x->c])->all() : [];

        $mLabels = $mSw = $mEn = [];
        for ($i = 9; $i >= 0; $i--) {
            $m = now()->subMonths($i);
            $q = fn ($lang) => DB::table('news')->join('nahau_story_meta as m', 'm.news_id', '=', 'news.id')->where('news.status', 1)
                ->whereYear('news.date', $m->year)->whereMonth('news.date', $m->month)->where('m.language', $lang)->count();
            $mLabels[] = $m->translatedFormat('M'); $mSw[] = $q('sw'); $mEn[] = $q('en');
        }

        // share of each month's readers who had already visited before (returning)
        $rLabels = $rRet = $rNew = [];
        for ($i = 5; $i >= 0; $i--) {
            $m = now()->subMonths($i);
            $tot = $has ? (int) $reads()->whereYear('day', $m->year)->whereMonth('day', $m->month)->distinct()->count('visitor') : 0;
            $ret = $has ? (int) $reads()->whereYear('day', $m->year)->whereMonth('day', $m->month)->where('returning', 1)->distinct()->count('visitor') : 0;
            $rLabels[] = $m->translatedFormat('M'); $rRet[] = $tot ? round($ret / $tot * 100) : 0; $rNew[] = $tot ? 100 - round($ret / $tot * 100) : 0;
        }

        $subsNow = \App\Models\NahauSubscriber::whereNotNull('confirmed_at')->whereBetween('confirmed_at', [$from, $to])->count();
        $subsPrev = \App\Models\NahauSubscriber::whereNotNull('confirmed_at')->whereBetween('confirmed_at', [$prevFrom, $from->copy()->subSecond()])->count();
        $pct = fn ($n, $p) => $p > 0 ? round(($n - $p) / $p * 100, 1) : null;
        $closed = \App\Models\NahauOpportunity::count() - \App\Models\NahauOpportunity::open()->count();

        $stories = DB::table('news')->leftJoin('nahau_story_meta as m', 'm.news_id', '=', 'news.id')->leftJoin('nahau_authors as a', 'a.id', '=', 'm.author_id')
            ->select('news.id', 'news.title', 'news.status', 'news.date', 'm.language', 'm.label', 'a.name as author')
            ->orderByDesc('news.date')->orderByDesc('news.id')->paginate(5, ['*'], 'sp')->withQueryString();

        return [
            'range' => $range, 'rFrom' => $from, 'rTo' => $to, 'hasReads' => $has,
            'readsTotal' => array_sum($a), 'rLabels2' => $labels, 'rReads' => $a, 'rUniq' => $b,
            'uNow' => $uNow, 'uDelta' => $pct($uNow, $uPrev), 'pubNow' => $pubNow, 'pubDelta' => $pubNow - $pubPrev,
            'subsNow' => $subsNow, 'subsDelta' => $pct($subsNow, $subsPrev), 'pubSpark' => $perDay(News::class, 'date', 1),
            'subSpark' => $perDay(\App\Models\NahauSubscriber::class, 'confirmed_at'),
            'cList' => $cList, 'cTotal' => (int) $countries->sum('c'), 'mostRead' => $mostRead,
            'mLabels' => $mLabels, 'mSw' => $mSw, 'mEn' => $mEn, 'ret' => [$rLabels, $rRet, $rNew],
            'oppOpen' => (int) \App\Models\NahauOpportunity::open()->count(), 'oppClosed' => (int) $closed, 'stories' => $stories,
        ];
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
        $old = $u->roles()->count() ? Panel::roleName($u->unsetRelation('roles')) : '—';
        $u->roles()->sync([$role->id]);
        $new = $this->roleOptions()[$slug] ?? $role->name;
        if ($old !== $new) {
            \App\Nahau\Audit::log('role_change', $u, 'Role ya '.\App\Nahau\Audit::label($u).': '.$old.' → '.$new, ['role' => [$old, $new]]);
        }
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
