<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Maanuser;
use App\Models\News;
use App\Models\Newscategory;
use App\Models\Photogallery;
use App\Models\Videogallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use App\Models\Advertisement;

class HomeController extends Controller
{
    /**
     * Display a listing of the Web view information .
     *
     */
    public function maanIndex()
    {
        $latestnews = News::join('newssubcategories','news.subcategory_id','=','newssubcategories.id')
            ->join('newscategories','newssubcategories.category_id','=','newscategories.id')
            ->join('users','news.reporter_id','=','users.id')
            ->select('news.id','news.title','news.image','news.date','news.created_at','newssubcategories.name as news_subcategory','newscategories.name as news_category','newscategories.slug as news_categoryslug',DB::raw("CONCAT(users.first_name,' ',users.last_name) AS reporter_name"))
            ->where('news.status',1)
            ->latest()
            ->take(5)
            ->get();

        $newscategories = Newscategory::with('news')->whereNotIn('type',['home','contact'] )->orderByDesc('post_counter')->get();


        $popularsnews = News::join('newssubcategories','news.subcategory_id','=','newssubcategories.id')
            ->join('newscategories','newssubcategories.category_id','=','newscategories.id')
            ->join('users','news.reporter_id','=','users.id')
            ->select('news.id','news.title','news.description','news.image','news.date','newscategories.name as news_category','newscategories.slug as news_categoryslug',DB::raw("CONCAT(users.first_name,' ',users.last_name) AS reporter_name"))
            ->where('news.status',1)
            ->orderByDesc('news.viewers')
            ->limit(4)
            ->get();
        $popularsnewsall = News::join('newssubcategories','news.subcategory_id','=','newssubcategories.id')
            ->join('newscategories','newssubcategories.category_id','=','newscategories.id')
            ->join('users','news.reporter_id','=','users.id')
            ->select('news.id','news.title','news.image','news.date','newscategories.name as news_category','newscategories.slug as news_categoryslug',DB::raw("CONCAT(users.first_name,' ',users.last_name) AS reporter_name"))
            ->where('news.status',1)
            ->orderByDesc('news.viewers')
            ->limit(3)
            ->get();
        $popularsnewsworld = News::join('newssubcategories','news.subcategory_id','=','newssubcategories.id')
            ->join('newscategories','newssubcategories.category_id','=','newscategories.id')
            ->join('users','news.reporter_id','=','users.id')
            ->select('news.id','news.title','news.image','news.date','newscategories.name as news_category','newscategories.slug as news_categoryslug',DB::raw("CONCAT(users.first_name,' ',users.last_name) AS reporter_name"))
            ->where('newscategories.name','World')
            ->where('news.status',1)
            ->orderByDesc('news.viewers')
            ->limit(3)
            ->get();
        $popularsnewslifestyle = News::join('newssubcategories','news.subcategory_id','=','newssubcategories.id')
            ->join('newscategories','newssubcategories.category_id','=','newscategories.id')
            ->join('users','news.reporter_id','=','users.id')
            ->select('news.id','news.title','news.image','news.date','newscategories.name as news_category','newscategories.slug as news_categoryslug',DB::raw("CONCAT(users.first_name,' ',users.last_name) AS reporter_name"))
            ->where('newscategories.name','Lifestyle')
            ->where('news.status',1)
            ->orderByDesc('news.viewers')
            ->limit(3)
            ->get();
        $popularsnewsentertainment = News::join('newssubcategories','news.subcategory_id','=','newssubcategories.id')
            ->join('newscategories','newssubcategories.category_id','=','newscategories.id')
            ->join('users','news.reporter_id','=','users.id')
            ->select('news.id','news.title','news.image','news.date','newscategories.name as news_category','newscategories.slug as news_categoryslug',DB::raw("CONCAT(users.first_name,' ',users.last_name) AS reporter_name"))
            ->where('newscategories.name','Entertainment')
            ->where('news.status',1)
            ->orderByDesc('news.viewers')
            ->limit(3)
            ->get();
        $popularsnewssports = News::join('newssubcategories','news.subcategory_id','=','newssubcategories.id')
            ->join('newscategories','newssubcategories.category_id','=','newscategories.id')
            ->join('users','news.reporter_id','=','users.id')
            ->select('news.id','news.title','news.image','news.date','newscategories.name as news_category','newscategories.slug as news_categoryslug',DB::raw("CONCAT(users.first_name,' ',users.last_name) AS reporter_name"))
            ->where('newscategories.name','Sports')
            ->where('news.status',1)
            ->orderByDesc('news.viewers')
            ->limit(3)
            ->get();
        $popularsnewstechnology = News::join('newssubcategories','news.subcategory_id','=','newssubcategories.id')
            ->join('newscategories','newssubcategories.category_id','=','newscategories.id')
            ->join('users','news.reporter_id','=','users.id')
            ->select('news.id','news.title','news.image','news.date','newscategories.name as news_category','newscategories.slug as news_categoryslug',DB::raw("CONCAT(users.first_name,' ',users.last_name) AS reporter_name"))
            ->where('newscategories.name','Technology')
            ->where('news.status',1)
            ->orderByDesc('news.viewers')
            ->limit(3)
            ->get();
        $latestnewsnational = News::join('newssubcategories','news.subcategory_id','=','newssubcategories.id')
            ->join('newscategories','newssubcategories.category_id','=','newscategories.id')
            ->join('users','news.reporter_id','=','users.id')
            ->select('news.id','news.title','news.image','news.date','news.created_at','newscategories.name as news_category','newscategories.slug as news_categoryslug',DB::raw("CONCAT(users.first_name,' ',users.last_name) AS reporter_name"))
            ->where('newscategories.name','National')
            ->where('news.status',1)
            ->latest()
            ->take(4)
            ->get();
        $latestnewsworld = News::join('newssubcategories','news.subcategory_id','=','newssubcategories.id')
            ->join('newscategories','newssubcategories.category_id','=','newscategories.id')
            ->join('users','news.reporter_id','=','users.id')
            ->select('news.id','news.title','news.image','news.date','news.created_at','newscategories.name as news_category','newscategories.slug as news_categoryslug',DB::raw("CONCAT(users.first_name,' ',users.last_name) AS reporter_name"))
            ->where('newscategories.name','World')
            ->where('news.status',1)
            ->latest()
            ->take(3)
            ->get();
        $latestnewspolitics = News::join('newssubcategories','news.subcategory_id','=','newssubcategories.id')
            ->join('newscategories','newssubcategories.category_id','=','newscategories.id')
            ->join('users','news.reporter_id','=','users.id')
            ->select('news.id','news.title','news.image','news.date','news.created_at','newscategories.name as news_category','newscategories.slug as news_categoryslug',DB::raw("CONCAT(users.first_name,' ',users.last_name) AS reporter_name"))
            ->where('newscategories.name','Politics')
            ->where('news.status',1)
            ->latest()
            ->take(6)
            ->get();
        $latestnewslifestyle = News::join('newssubcategories','news.subcategory_id','=','newssubcategories.id')
            ->join('newscategories','newssubcategories.category_id','=','newscategories.id')
            ->join('users','news.reporter_id','=','users.id')
            ->select('news.id','news.title','news.image','news.date','news.created_at','newscategories.name as news_category','newscategories.slug as news_categoryslug',DB::raw("CONCAT(users.first_name,' ',users.last_name) AS reporter_name"))
            ->where('newscategories.name','Lifestyle')
            ->where('news.status',1)
            ->latest()
            ->take(5)
            ->get();

        $latestnewsentertainment = News::join('newssubcategories','news.subcategory_id','=','newssubcategories.id')
            ->join('newscategories','newssubcategories.category_id','=','newscategories.id')
            ->join('users','news.reporter_id','=','users.id')
            ->select('news.id','news.title','news.image','news.date','news.created_at','newscategories.name as news_category','newscategories.slug as news_categoryslug',DB::raw("CONCAT(users.first_name,' ',users.last_name) AS reporter_name"))
            ->where('newscategories.name','Entertainment')
            ->where('news.status',1)
            ->latest()
            ->take(4)
            ->get();
        $latestnewssports = News::join('newssubcategories','news.subcategory_id','=','newssubcategories.id')
            ->join('newscategories','newssubcategories.category_id','=','newscategories.id')
            ->join('users','news.reporter_id','=','users.id')
            ->select('news.id','news.title','news.description','news.image','news.date','news.created_at','newscategories.name as news_category','newscategories.slug as news_categoryslug',DB::raw("CONCAT(users.first_name,' ',users.last_name) AS reporter_name"))
            ->where('newscategories.name','Sports')
            ->where('news.status',1)
            ->latest()
            ->take(5)
            ->get();
        $latestnewstechnology = News::join('newssubcategories','news.subcategory_id','=','newssubcategories.id')
            ->join('newscategories','newssubcategories.category_id','=','newscategories.id')
            ->join('users','news.reporter_id','=','users.id')
            ->select('news.id','news.title','news.image','news.date','news.created_at','newscategories.name as news_category','newscategories.slug as news_categoryslug',DB::raw("CONCAT(users.first_name,' ',users.last_name) AS reporter_name"))
            ->where('newscategories.name','Technology')
            ->where('news.status',1)
            ->latest()
            ->take(6)
            ->get();
        $latestnewsbusiness = News::join('newssubcategories','news.subcategory_id','=','newssubcategories.id')
            ->join('newscategories','newssubcategories.category_id','=','newscategories.id')
            ->join('users','news.reporter_id','=','users.id')
            ->select('news.id','news.title','news.image','news.date','news.created_at','newscategories.name as news_category','newscategories.slug as news_categoryslug',DB::raw("CONCAT(users.first_name,' ',users.last_name) AS reporter_name"))
            ->where('newscategories.name','Business')
            ->where('news.status',1)
            ->latest()
            ->take(5)
            ->get();
        $latestphotogalleries = Photogallery::join('users','photogalleries.user_id','=','users.id')
            ->select('photogalleries.id','photogalleries.title','photogalleries.image','photogalleries.created_at',DB::raw("CONCAT(users.first_name,' ',users.last_name) AS user_name"))
            ->where('status',1)
            ->latest()
            ->take(10)
            ->get();
        $latestVideoGalleries = Videogallery::join('users','videogalleries.user_id','=','users.id')
            ->select('videogalleries.*',DB::raw("CONCAT(users.first_name,' ',users.last_name) AS user_name"))
            ->where('status',1)
            ->latest()
            ->take(9)
            ->get();
        $latestReviewNews = News::with('category')->whereHas('comments',function ($q){
            $q->latest();
        })
            ->take(10)
            ->get();
        $features      = News::where('status',1)->orderBy('viewers','DESC')->take(6)->get();

        $this->sitemap();
        $themeActivation =  themeActivation();
        //return request()->getRequestUri();
        $homeView = Route::currentRouteName()=='home-one'?'frontend.pages.home':(Route::currentRouteName()=='home-two'?'frontend.pages.home_2':($themeActivation->page_slug=='home_1'?'frontend.pages.home_nahau':'frontend.pages.'.$themeActivation->page_slug));
        $nahau = $homeView === 'frontend.pages.home_nahau' ? $this->nahauHomeData() : null;
        return view($homeView,compact('latestnews','newscategories','popularsnews','popularsnewsall','popularsnewsworld','popularsnewslifestyle','popularsnewsentertainment','popularsnewssports','popularsnewstechnology','latestnewsnational','latestnewsworld','latestnewspolitics','latestnewslifestyle','latestphotogalleries','latestnewsentertainment','latestnewssports','latestnewstechnology','latestnewsbusiness','latestVideoGalleries','latestReviewNews','features','nahau'));
    }
    public function maanIndex2()
    {

        $news          = News::where('status',1)->latest()->take(5)->get();
        $trending      = News::where('status',1)->orderBy('viewers','DESC')->take(4)->get();
        $adds          = Advertisement::latest()->take(1)->get();
        $sports        = News::where('subcategory_id',1)->latest()->take(4)->get();
        $reviews       = News::where('status',1)->orderBy('viewers','DESC')->take(10)->get();
        $economies     = News::where('status',1)->where('subcategory_id',3)->latest()->take(4)->get();
        $editors       = News::where('status',1)->orderBy('viewers','ASC')->take(5)->get();
        $features      = News::where('status',1)->orderBy('viewers','DESC')->take(5)->get();
        $slides        = News::where('status',1)->orderBy('viewers','DESC')->take(10)->get();
        $videos        = Videogallery::latest()->take(4)->get();
        $categories    = Newscategory::whereNotIn('type',['home','contact'] )->latest()->get();
        $d =array();
                foreach ($categories as $category){
                    $data['cat_id'] = $category->id;
                    $data['name'] = $category->name;
                    $data['slug'] = $category->slug;
                    $data['type'] = $category->type;
                    $data['image'] = $category->image;
                    $data['news']  = News::join('newssubcategories','news.subcategory_id','=','newssubcategories.id')
                        ->join('newscategories','newssubcategories.category_id','=','newscategories.id')
                        ->select('news.id','news.title','news.image','news.date','news.created_at','newscategories.name as news_category','newscategories.slug as news_categoryslug')
                        ->where('newssubcategories.category_id',$category->id)
                        ->where('news.status',1)
                        ->latest()
                        ->get()->take(4);
                    $d[] =$data;
                }
                $wholecategories = $d;
                //return $wholecategories;
        $newscategory  = DB::table('newscategories')
            ->join('newssubcategories','newscategories.id','=','newssubcategories.category_id')
            ->join('news','newssubcategories.category_id','=','news.subcategory_id')
            ->get()->take(4);


        return view('frontend.pages.home_2',
            compact('news','trending','adds','sports','reviews','economies',
                'editors','features','slides','videos','categories','newscategory','wholecategories'));
    }


    public function sitemap()
    {
        // Refresh the sitemap at most once an hour (used to be rewritten on every home page hit).
        try {
            if (\Illuminate\Support\Facades\Cache::add('maannews.sitemap.fresh', true, 3600)) {
                media_disk()->put('sitemap.xml', \App\Services\SitemapBuilder::xml(), 'public');
            }
        } catch (\Throwable $e) {
            report($e);
        }
    }

    /**
     * Data for the NahauAfrica home page (frontend.pages.home_nahau).
     */
    protected function nahauHomeData(): array
    {
        $base = fn () => News::join('newssubcategories','news.subcategory_id','=','newssubcategories.id')
            ->join('newscategories','newssubcategories.category_id','=','newscategories.id')
            ->join('users','news.reporter_id','=','users.id')
            ->select('news.id','news.title','news.summary','news.image','news.date','news.viewers','newscategories.name as news_category','newscategories.slug as news_categoryslug',DB::raw("CONCAT(users.first_name,' ',users.last_name) AS reporter_name"))
            ->where('news.status',1);

        $hero   = $base()->latest('news.created_at')->first();
        $latest = $base()->when($hero, fn ($q) => $q->where('news.id','!=',$hero->id))->latest('news.created_at')->take(5)->get();
        $most   = $base()->orderByDesc('news.viewers')->take(5)->get();

        $doors = Newscategory::where('type','news')->where('menu_publish',1)->orderBy('id')->get();
        $counts = DB::table('news')
            ->join('newssubcategories','news.subcategory_id','=','newssubcategories.id')
            ->where('news.status',1)
            ->groupBy('newssubcategories.category_id')
            ->pluck(DB::raw('count(*)'),'newssubcategories.category_id');
        $doors->each(fn ($c) => $c->published_count = (int) ($counts[$c->id] ?? 0));

        $heroes = $base()->where('newscategories.slug','african-heroes')->latest('news.created_at')->take(3)->get();

        return compact('hero','latest','most','doors','heroes');
    }

    public function subscribeAjax(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $count = Maanuser::where('email',$request->email)->count();
        if ($count>0) {
           $this->setError('Existing');
            return $count;
        }
        Maanuser::updateOrCreate(['email'=>$request->email]);
        return $request;
    }

}
