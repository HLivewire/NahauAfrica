<?php

namespace App\Http\Controllers\Nahau;

use App\Http\Controllers\Controller;
use App\Models\NahauAuthor;
use App\Models\NahauHero;
use App\Models\NahauOpportunity;
use App\Nahau\Stories;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $term = trim((string) $request->query('q', $request->query('search', '')));
        $section = array_key_exists($request->query('section'), config('nahau.sections')) ? $request->query('section') : null;
        $lang = in_array($request->query('lang'), ['en', 'sw'], true) ? $request->query('lang') : null;

        $stories = $heroes = $opps = $authors = collect();
        if (mb_strlen($term) >= 2) {
            $like = '%'.str_replace(['%', '_'], ['\%', '\_'], $term).'%';
            $stories = Stories::query()->reorder()
                ->when($section, fn ($q) => $q->where('newscategories.slug', $section))
                ->when($lang, fn ($q) => $q->where('m.language', $lang))
                ->where(function ($w) use ($like) {
                    $w->where('news.title', 'like', $like)->orWhere('m.dek', 'like', $like)
                        ->orWhere('news.summary', 'like', $like)->orWhere('news.description', 'like', $like)
                        ->orWhere('a.name', 'like', $like)->orWhere('news.tags', 'like', $like);
                })
                ->orderByRaw("CASE WHEN COALESCE(m.language,'en') = ? THEN 0 ELSE 1 END", [nlocale()])
                ->orderByDesc('news.date')->limit(30)->get();

            if (! $section || $section === 'african-heroes') {
                $heroes = NahauHero::where('name', 'like', $like)->get()
                    ->map(fn ($h) => [$h, Stories::query()->where('news.id', $h->news_id)->first()])->filter(fn ($p) => $p[1]);
            }
            if (! $section || $section === 'jobs-careers') {
                $opps = NahauOpportunity::open()->where(fn ($q) => $q->where('title', 'like', $like)->orWhere('employer', 'like', $like))->limit(10)->get();
            }
            $authors = NahauAuthor::where('name', 'like', $like)->limit(10)->get();
        }

        $count = $stories->count() + $heroes->count() + $opps->count() + $authors->count();

        return view('nahau.search', compact('term', 'section', 'lang', 'stories', 'heroes', 'opps', 'authors', 'count'));
    }
}
