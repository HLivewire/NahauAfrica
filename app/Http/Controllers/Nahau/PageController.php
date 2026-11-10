<?php

namespace App\Http\Controllers\Nahau;

use App\Http\Controllers\Controller;
use App\Models\NahauAuthor;
use App\Models\NahauHero;
use App\Models\NahauPage;
use App\Models\NahauSeries;
use App\Models\NahauTeam;
use App\Nahau\Stories;

class PageController extends Controller
{
    public function home()
    {
        $featured = Stories::query()->where('m.featured', 1)->first();
        $latest = Stories::query()->limit(6)->get();

        $series = NahauSeries::where('featured', 1)->first();
        $chapters = collect();
        if ($series) {
            $chapters = Stories::query()->where('m.series_id', $series->id)->reorder('m.chapter_no')->get();
        }

        $voices = NahauAuthor::where('show_on_home', 1)->orderBy('home_order')->limit(3)->get()->map(function ($a) {
            $a->story_count = Stories::query()->where('m.author_id', $a->id)->count();
            return $a;
        });

        $heroes = NahauHero::where('show_in_spotlight', 1)->orderBy('spotlight_order')->limit(5)->get();
        $heroStories = $heroes->isEmpty() ? collect() : Stories::query()->whereIn('news.id', $heroes->pluck('news_id'))->get()->keyBy('id');
        $heroes = $heroes->filter(fn ($h) => $heroStories->has($h->news_id))->values();

        return view('nahau.home', compact('featured', 'latest', 'series', 'chapters', 'voices', 'heroes', 'heroStories'));
    }

    public function write()
    {
        return view('nahau.write');
    }

    public function about()
    {
        return view('nahau.about', ['team' => NahauTeam::orderBy('sort')->get(), 'standards' => NahauPage::where('slug', 'editorial-standards')->first()]);
    }

    public function contact()
    {
        return view('nahau.contact');
    }

    public function policy(string $page)
    {
        $p = NahauPage::where('slug', $page)->firstOrFail();

        return view('nahau.policy', compact('p'));
    }
}
