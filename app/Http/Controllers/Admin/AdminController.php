<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Maanuser;
use App\Models\News;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Display a listing of the Dashboard.
     *
     */

    public function maanDashboard()
    {
        if (Auth::user()->user_type>1){
            $admin = User::where('user_type','>=','3')->where('is_active','1')->count();
            $publish_news = News::where('status',1)->count();
            $unpublish_news = News::where('status',0)->count();
            $subscribe = Maanuser::count();

            $now = now();
            $pct = function (int $cur, int $prev): ?float {
                if ($prev === 0) { return $cur > 0 ? 100.0 : null; }
                return round((($cur - $prev) / $prev) * 100, 1);
            };

            // Last 12 months of new stories (area chart)
            $months = [];
            for ($i = 11; $i >= 0; $i--) {
                $m = $now->copy()->startOfMonth()->subMonths($i);
                $months[$m->format('Y-m')] = ['label' => $m->format('M'), 'count' => 0];
            }
            News::where('created_at', '>=', $now->copy()->startOfMonth()->subMonths(11))->get(['created_at'])
                ->each(function ($n) use (&$months) {
                    $k = $n->created_at->format('Y-m');
                    if (isset($months[$k])) { $months[$k]['count']++; }
                });
            $series = array_values($months);

            $thisM = $now->copy()->startOfMonth();
            $lastM = $now->copy()->startOfMonth()->subMonth();
            $storyGrowth = $pct(News::where('created_at', '>=', $thisM)->count(), News::whereBetween('created_at', [$lastM, $thisM])->count());
            $subGrowth = $pct(Maanuser::where('created_at', '>=', $thisM)->count(), Maanuser::whereBetween('created_at', [$lastM, $thisM])->count());

            // Stories per category (bar chart)
            $byCategory = \Illuminate\Support\Facades\DB::table('news')
                ->join('newssubcategories as sc', 'sc.id', '=', 'news.subcategory_id')
                ->join('newscategories as c', 'c.id', '=', 'sc.category_id')
                ->select('c.name', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
                ->groupBy('c.id', 'c.name')->orderByDesc('total')->limit(7)->get();

            // Last 8 weeks: new stories vs new subscribers (line chart)
            $weeks = [];
            for ($i = 7; $i >= 0; $i--) {
                $w = $now->copy()->startOfWeek()->subWeeks($i);
                $weeks[$w->format('o-W')] = ['label' => $w->format('d M'), 'stories' => 0, 'subs' => 0];
            }
            $from = $now->copy()->startOfWeek()->subWeeks(7);
            News::where('created_at', '>=', $from)->get(['created_at'])->each(function ($n) use (&$weeks) {
                $k = $n->created_at->format('o-W'); if (isset($weeks[$k])) { $weeks[$k]['stories']++; }
            });
            Maanuser::where('created_at', '>=', $from)->get(['created_at'])->each(function ($n) use (&$weeks) {
                $k = $n->created_at->format('o-W'); if (isset($weeks[$k])) { $weeks[$k]['subs']++; }
            });
            $weekly = array_values($weeks);

            $total = max(1, News::count());
            $topRead = News::orderByDesc('viewers')->limit(5)->get(['id','title','viewers','status','created_at']);
            $totalReads = (int) News::sum('viewers');
            $quality = [
                ['label' => __('Published'), 'value' => (int) round(News::where('status',1)->count() / $total * 100), 'variant' => 'success'],
                ['label' => __('Have a cover image'), 'value' => (int) round(News::whereNotNull('image')->where('image','!=','')->count() / $total * 100), 'variant' => 'primary'],
                ['label' => __('Have a search description'), 'value' => (int) round(News::whereNotNull('meta_description')->where('meta_description','!=','')->count() / $total * 100), 'variant' => 'info'],
                ['label' => __('Have a summary'), 'value' => (int) round(News::whereNotNull('summary')->where('summary','!=','')->count() / $total * 100), 'variant' => 'warning'],
            ];
            $recent = News::orderByDesc('id')->limit(5)->get(['id','title','status','created_at']);

            // Live activity: newest stories, subscribers and messages together
            $feed = collect();
            News::orderByDesc('id')->limit(4)->get(['title','created_at'])->each(fn ($n) => $feed->push(['type' => 'story', 'text' => __('Story added: ').\Illuminate\Support\Str::limit($n->title, 60), 'at' => $n->created_at]));
            Maanuser::orderByDesc('id')->limit(3)->get(['first_name','last_name','created_at'])->each(fn ($u) => $feed->push(['type' => 'user', 'text' => __('New subscriber: ').trim($u->first_name.' '.$u->last_name), 'at' => $u->created_at]));
            \App\Models\Contact::orderByDesc('id')->limit(2)->get(['name','created_at'])->each(fn ($c) => $feed->push(['type' => 'mail', 'text' => __('Message received from ').$c->name, 'at' => $c->created_at]));
            $feed = $feed->filter(fn ($f) => $f['at'])->sortByDesc('at')->take(6)->values();

            $metrics = [
                'avgReads' => $publish_news ? (int) round($totalReads / max(1, $publish_news)) : 0,
                'messages' => \App\Models\Contact::count(),
                'categories' => \Illuminate\Support\Facades\DB::table('newscategories')->count(),
                'authors' => \Illuminate\Support\Facades\DB::table('nahau_authors')->count(),
            ];
            $noCover = News::where(function ($q) { $q->whereNull('image')->orWhere('image', ''); })->count();

            return view('admin.pages.dashboard', compact('admin','publish_news','unpublish_news','subscribe','series','byCategory','weekly','topRead','totalReads','quality','recent','feed','metrics','noCover','storyGrowth','subGrowth'));

        }else{
            return view('admin.pages.dashboard2') ;
        }

    }
}
