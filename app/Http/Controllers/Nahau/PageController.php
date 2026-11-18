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

        $voices = NahauAuthor::where('show_on_home', 1)->orderBy('home_order')->limit(12)->get()->map(function ($a) {
            $a->story_count = Stories::query()->where('m.author_id', $a->id)->count();
            return $a;
        });

        // Home carousel: up to 2 heroes + 2 books, each for a set number of days (App\Models\NahauSlide).
        $slides = \App\Models\NahauSlide::live()->orderBy('slot')->get()->map(function ($sl) {
            if ($sl->kind === 'hero') {
                $h = $sl->hero;
                $st = $h ? Stories::query()->where('news.id', $h->news_id)->first() : null;
                if (! $h || ! $st) {
                    return null;
                }
                $img = ($sl->image ? nimage($sl->image) : null) ?: ($h->portrait ? nimage($h->portrait) : null) ?: nimage($st);
                $kicker = __('African Heroes');
                $title = $sl->headline ?: $h->name;
                $sum = $sl->summary ?: ($h->spotlight_summary ?: ($st->summary ?? ''));
            } else {
                $st = Stories::query()->where('news.id', $sl->news_id)->first();
                if (! $st) {
                    return null;
                }
                $img = ($sl->image ? nimage($sl->image) : null) ?: nimage($st);
                $kicker = $sl->kicker ?: __('Book');
                $title = $sl->headline ?: $st->title;
                $sum = $sl->summary ?: ($st->dek ?: ($st->summary ?? ''));
            }

            return ['slot' => $sl->slot, 'kind' => $sl->kind, 'kicker' => $kicker, 'title' => $title, 'img' => $img,
                'sum' => \Illuminate\Support\Str::limit(strip_tags((string) $sum), 320), 'url' => Stories::url($st),
                'cta' => $sl->kind === 'book' ? __('Read the book') : __('Read more')];
        })->filter()->values();

        return view('nahau.home', compact('featured', 'latest', 'series', 'chapters', 'voices', 'slides'));
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
