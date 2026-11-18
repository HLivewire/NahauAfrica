<?php

namespace App\Http\Controllers\Nahau;

use App\Http\Controllers\Controller;
use App\Models\Maanuser;
use App\Models\NahauAuthor;
use App\Models\NahauFavorite;
use App\Models\NahauFollow;
use App\Models\NahauReadingList;
use App\Models\NahauSubmission;
use App\Nahau\ReaderNotes;
use App\Nahau\Stories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

/** The signed-in reader's own area (/account): dashboard, favourites, read later, history, follows, my stories, notifications, profile. */
class AccountController extends Controller
{
    private function me(): Maanuser
    {
        return auth('maanuser')->user();
    }

    private function reads()
    {
        return Schema::hasTable('nahau_reads') ? DB::table('nahau_reads')->where('maanuser_id', $this->me()->id) : DB::table('news')->whereRaw('1=0');
    }

    private function storiesByIds($ids)
    {
        $ids = collect($ids)->values();

        return $ids->isEmpty() ? collect() : Stories::query()->whereIn('news.id', $ids)->get()->sortBy(fn ($s) => $ids->search($s->id))->values();
    }

    public function dashboard(Request $r)
    {
        $u = $this->me();
        $range = in_array((int) $r->query('range'), [7, 30, 90], true) ? (int) $r->query('range') : 30;
        $from = now()->subDays($range - 1)->startOfDay();
        $byDay = $this->reads()->whereBetween('day', [$from->toDateString(), now()->toDateString()])
            ->select('day', DB::raw('count(*) as c'), DB::raw('count(distinct news_id) as s'))->groupBy('day')->get()->keyBy('day');
        $labels = $a = $b = [];
        for ($t = $from->copy(); $t <= now(); $t->addDay()) {
            $row = $byDay[$t->toDateString()] ?? null;
            $labels[] = $t->format('d M'); $a[] = (int) ($row->c ?? 0); $b[] = (int) ($row->s ?? 0);
        }
        $monthReads = (int) $this->reads()->whereYear('day', now()->year)->whereMonth('day', now()->month)->distinct()->count('news_id');
        $goal = max(1, (int) ($u->reading_goal ?: 6));
        $week = collect(range(6, 0))->map(fn ($i) => (int) $this->reads()->where('day', now()->subDays($i)->toDateString())->count())->all();
        $subs = NahauSubmission::where('email', $u->email)->get();
        $notes = ReaderNotes::for($u, 12);
        $recent = $this->reads()->join('news', 'news.id', '=', 'nahau_reads.news_id')->select('news.id', 'news.title', DB::raw('max(nahau_reads.created_at) as at'))
            ->groupBy('news.id', 'news.title')->orderByDesc('at')->limit(5)->get();
        $meta = DB::table('nahau_story_meta as m')->leftJoin('nahau_authors as a', 'a.id', '=', 'm.author_id')->whereIn('m.news_id', $recent->pluck('id'))->select('m.news_id', 'm.language', 'a.name as author')->get()->keyBy('news_id');

        return view('nahau-account.dashboard', [
            'u' => $u, 'range' => $range, 'labels' => $labels, 'a' => $a, 'b' => $b, 'week' => $week,
            'readTotal' => (int) $this->reads()->distinct()->count('news_id'), 'goal' => $goal, 'monthReads' => $monthReads,
            'goalPct' => min(100, (int) round($monthReads / $goal * 100)),
            'favs' => NahauFavorite::where('maanuser_id', $u->id)->count(), 'later' => NahauReadingList::where('maanuser_id', $u->id)->count(),
            'follows' => NahauFollow::where('maanuser_id', $u->id)->count(),
            'subsTotal' => $subs->count(), 'subsOk' => $subs->whereIn('status', ['accepted'])->count(), 'subsOpen' => $subs->whereIn('status', ['new', 'under_review', 'revisions'])->count(),
            'notes' => $notes, 'unread' => ReaderNotes::unread($notes), 'recent' => $recent, 'meta' => $meta,
            'newStories' => Stories::query()->where('news.date', '>=', now()->subDays(7)->toDateString())->count(),
        ]);
    }

    public function favourites()
    {
        $ids = NahauFavorite::where('maanuser_id', $this->me()->id)->latest()->pluck('news_id');

        return view('nahau-account.stories', ['title' => 'Favourites', 'sub' => 'Hadithi ulizopenda.', 'stories' => $this->storiesByIds($ids), 'empty' => 'Bado hujapenda hadithi yoyote. Bonyeza moyo kwenye hadithi ili kuiweka hapa.', 'action' => 'fav']);
    }

    public function later()
    {
        $ids = NahauReadingList::where('maanuser_id', $this->me()->id)->latest()->pluck('news_id');

        return view('nahau-account.stories', ['title' => 'Soma baadaye', 'sub' => 'Orodha yako ya kusoma, tofauti na favourites.', 'stories' => $this->storiesByIds($ids), 'empty' => 'Orodha yako ni tupu. Bonyeza "Soma baadaye" kwenye kitabu ili kuiongeza.', 'action' => 'later']);
    }

    public function history()
    {
        $ids = $this->reads()->select('news_id', DB::raw('max(created_at) as at'))->groupBy('news_id')->orderByDesc('at')->limit(60)->pluck('news_id');

        return view('nahau-account.stories', ['title' => 'Nilichosoma', 'sub' => 'Historia ya hadithi ulizofungua, mpya kwanza.', 'stories' => $this->storiesByIds($ids), 'empty' => 'Historia yako itaonekana ukianza kusoma ukiwa umeingia.', 'action' => null]);
    }

    public function follows()
    {
        $u = $this->me();
        $ids = NahauFollow::where('maanuser_id', $u->id)->pluck('author_id')->all();
        $authors = NahauAuthor::orderBy('name')->get()->each(fn ($a) => $a->following = in_array($a->id, $ids, true));

        return view('nahau-account.follows', ['authors' => $authors->sortByDesc('following')->values()]);
    }

    public function followToggle(int $author)
    {
        abort_unless(NahauAuthor::whereKey($author)->exists(), 404);
        $row = NahauFollow::where('maanuser_id', $this->me()->id)->where('author_id', $author)->first();
        $row ? $row->delete() : NahauFollow::create(['maanuser_id' => $this->me()->id, 'author_id' => $author]);

        return back();
    }

    public function laterToggle(Request $r, int $news)
    {
        $u = auth('maanuser')->user();
        if (! $u) {
            return response()->json(['login' => true, 'message' => __('Please log in to save stories.')], 401);
        }
        abort_unless(Stories::query()->where('news.id', $news)->exists(), 404);
        $row = NahauReadingList::where('maanuser_id', $u->id)->where('news_id', $news)->first();
        $row ? $row->delete() : NahauReadingList::create(['maanuser_id' => $u->id, 'news_id' => $news]);
        if ($r->expectsJson()) {
            return response()->json(['later' => ! $row]);
        }

        return back();
    }

    public function favToggle(int $news)
    {
        $row = NahauFavorite::where('maanuser_id', $this->me()->id)->where('news_id', $news)->first();
        $row ? $row->delete() : null;

        return back();
    }

    public function mine()
    {
        $subs = NahauSubmission::where('email', $this->me()->email)->orderByDesc('id')->get();

        return view('nahau-account.mine', ['subs' => $subs]);
    }

    public function notifications()
    {
        $notes = ReaderNotes::for($this->me(), 60);

        return view('nahau-account.notifications', ['notes' => $notes, 'unread' => ReaderNotes::unread($notes)]);
    }

    public function notificationsRead()
    {
        $this->me()->forceFill(['notif_seen_at' => now()])->save();

        return back();
    }

    public function profile()
    {
        return view('nahau-account.profile', ['u' => $this->me()]);
    }

    public function profileSave(Request $r)
    {
        $d = $r->validate(['first_name' => 'required|string|max:80', 'last_name' => 'nullable|string|max:80', 'phone' => 'nullable|string|max:30', 'lang' => 'required|in:sw,en', 'reading_goal' => 'required|integer|min:1|max:60']);
        $this->me()->forceFill($d)->save();

        return back()->with('ok', 'Wasifu umehifadhiwa.');
    }

    public function password(Request $r)
    {
        $d = $r->validate(['current' => 'required', 'password' => 'required|string|min:8|confirmed']);
        $u = $this->me();
        if (! Hash::check($d['current'], $u->password)) {
            return back()->withErrors(['current' => 'Nenosiri la sasa si sahihi.']);
        }
        $u->forceFill(['password' => Hash::make($d['password'])])->save();

        return back()->with('ok', 'Nenosiri limebadilishwa.');
    }
}
