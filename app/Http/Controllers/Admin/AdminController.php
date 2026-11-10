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

            // Last 12 months of new stories (for the area chart)
            $months = [];
            for ($i = 11; $i >= 0; $i--) {
                $m = now()->startOfMonth()->subMonths($i);
                $months[$m->format('Y-m')] = ['label' => $m->format('M'), 'count' => 0];
            }
            News::where('created_at', '>=', now()->startOfMonth()->subMonths(11))
                ->get(['created_at'])
                ->each(function ($n) use (&$months) {
                    $k = $n->created_at->format('Y-m');
                    if (isset($months[$k])) { $months[$k]['count']++; }
                });
            $series = array_values($months);
            $noCover = News::where(function ($q) { $q->whereNull('image')->orWhere('image', ''); })->count();
            $topRead = News::orderByDesc('viewers')->limit(6)->get(['id','title','viewers','status','created_at']);
            $totalReads = (int) News::sum('viewers');
            $latest = News::orderByDesc('id')->limit(5)->get(['id','title','status','created_at']);

            return view('admin.pages.dashboard', compact('admin','publish_news','unpublish_news','subscribe','series','noCover','topRead','totalReads','latest'));

        }else{
            return view('admin.pages.dashboard2') ;
        }

    }
}
