<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Newscategory;
use App\Models\Newscomment;
use App\Models\Socialshare;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewsController extends Controller
{
    public function maanNewsComment(Request $request, $id)
    {
        // Honeypot check against automated comment spam
        if ($request->filled('nx_website') || $request->filled('website')) {
            return redirect()->back();
        }

        $news = News::where('id', $id)->where('status', 1)->firstOrFail();

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'comment' => 'required|string|max:2000',
        ]);

        $newscomments = new Newscomment();
        $newscomments->news_id = $news->id;
        $newscomments->name = strip_tags($validated['name']);
        $newscomments->email = $validated['email'];
        $newscomments->comment = strip_tags($validated['comment']);
        $newscomments->save();

        return redirect()->back();
    }

    public function maanNews($newscategory = null)
    {
        // The route name of a category route is the category slug.
        $newscategorysingle = Newscategory::where('slug', request()->route()->getName())
            ->where('type', 'news')
            ->firstOrFail();
        $allnews = News::join('newssubcategories','news.subcategory_id','=','newssubcategories.id')
            ->join('newscategories','newssubcategories.category_id','=','newscategories.id')
            ->join('users','news.reporter_id','=','users.id')
            ->select('news.id','news.title','news.summary','news.description','news.image','news.date','newssubcategories.name as news_subcategory','newscategories.name as news_category','newscategories.slug as news_categoryslug',DB::raw("CONCAT(users.first_name,' ',users.last_name) AS reporter_name"))
            ->where('newscategories.id',$newscategorysingle->id)
            ->where('news.status',1)
            ->orderByDesc('news.id')
            ->paginate(10);

        $popularallnews = News::join('newssubcategories','news.subcategory_id','=','newssubcategories.id')
            ->join('newscategories','newssubcategories.category_id','=','newscategories.id')
            ->select('news.id','news.title','news.image','news.date','newscategories.slug as news_categoryslug')
            ->where('newscategories.id',$newscategorysingle->id)
            ->where('news.status',1)
            ->orderByDesc('news.viewers')
            ->limit(4)
            ->get();
        $recentallnews = News::join('newssubcategories','news.subcategory_id','=','newssubcategories.id')
            ->join('newscategories','newssubcategories.category_id','=','newscategories.id')
            ->select('news.id','news.title','news.image','news.date','newscategories.slug as news_categoryslug')
            ->where('newscategories.id',$newscategorysingle->id)
            ->where('news.status',1)
            ->orderByDesc('news.id')
            ->limit(5)
            ->get();
        return view('frontend.pages.news',compact('allnews','popularallnews','recentallnews','newscategorysingle'));
    }

    public function maanNewsDetails($id,$slug=null)
    {
        // Only published articles can be opened (unknown / draft ids -> 404).
        abort_unless(News::where('id',$id)->where('status',1)->exists(), 404);
        News::where('id',$id)->increment('viewers');
        // get comments
        $newscomments = Newscomment::where('news_id',$id)->paginate(10);

        $getnews = News::join('newssubcategories','news.subcategory_id','=','newssubcategories.id')
            ->join('newscategories','newssubcategories.category_id','=','newscategories.id')
            ->join('users','news.reporter_id','=','users.id')
            ->select('news.id','news.title','news.summary','news.description','news.meta_keyword','news.meta_description','news.image','news.date','newssubcategories.name as news_subcategory','newscategories.name as news_category','newscategories.slug as news_categoryslug',DB::raw("CONCAT(users.first_name,' ',users.last_name) AS reporter_name"))
            ->where('news.id',$id)
            ->where('news.status',1)
            ->first();
        //related news
        $relatedgetsnews = News::join('newssubcategories','news.subcategory_id','=','newssubcategories.id')
            ->join('newscategories','newssubcategories.category_id','=','newscategories.id')
            ->join('users','news.reporter_id','=','users.id')
            ->select('news.id','news.title','news.summary','news.image','news.date','newscategories.slug as news_categoryslug',DB::raw("CONCAT(users.first_name,' ',users.last_name) AS reporter_name"))
            ->where('news.id','!=',$id)
            ->where('news.status',1)
            ->where('newscategories.name',$getnews->news_category)
            ->orderByDesc('news.id')
            ->limit(3)
            ->get();
        $socials = Socialshare::all();

        return view('frontend.pages.news_details',compact('getnews','relatedgetsnews','newscomments','socials'));
    }
}
