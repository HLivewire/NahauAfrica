<?php

namespace App\Http\Controllers\Nahau;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\NahauAuthor;
use App\Models\NahauHero;
use App\Models\NahauSeries;
use App\Nahau\Stories;

class StoryController extends Controller
{
    protected function sectionKey(string $slug): string
    {
        foreach (config('nahau.sections') as $k => $s) {
            if (in_array($slug, $s['slug'], true)) {
                return $k;
            }
        }
        abort(404);
    }

    public function show(string $section, string $slug)
    {
        $key = $this->sectionKey($section);
        $story = Stories::find($key, $slug);
        if (! $story && \Illuminate\Support\Str::slug(rawurldecode($slug)) === \Illuminate\Support\Str::slug(nsection($key, 'name', 'en'))) {
            return app(SectionController::class)->show(request(), $key);   // old links like /fiction/fiction
        }
        abort_unless($story, 404);

        // Correct language segment / section slug -> canonical redirect
        $canonical = Stories::url($story);
        if (rtrim(url()->current(), '/') !== rtrim($canonical, '/')) {
            return redirect($canonical, 301);
        }

        News::where('id', $story->id)->increment('viewers');
        return $this->render($story, $key);
    }

    protected function render($story, string $key, $series = null)
    {
        $cfg = config("nahau.sections.$key");

        // Linked translation (either direction)
        $translation = null;
        if ($story->translation_of) {
            $translation = Stories::query()->where('news.id', $story->translation_of)->first();
        }
        if (! $translation) {
            $translation = Stories::query()->where('m.translation_of', $story->id)->first();
        }
        if ($translation) {
            request()->attributes->set('nahau.translation_url', Stories::url($translation, $translation->language === 'sw' ? 'sw' : 'en'));
        }

        // Related (editor picks, else newest in section)
        $ids = array_filter([$story->related_1, $story->related_2, $story->related_3]);
        $related = $ids ? Stories::query()->whereIn('news.id', $ids)->where('news.id', '!=', $story->id)->limit(3)->get() : collect();
        if ($related->count() < 3) {
            $more = Stories::inSection($key)->where('news.id', '!=', $story->id)->whereNotIn('news.id', $related->pluck('id'))->limit(3 - $related->count())->get();
            $related = $related->concat($more);
        }

        $author = $story->author_id ? NahauAuthor::find($story->author_id) : null;
        $hero = $key === 'african-heroes' ? NahauHero::where('news_id', $story->id)->first() : null;

        $series = $story->series_id ? NahauSeries::find($story->series_id) : null;
        $nav = null;
        if ($series) {
            $chapters = Stories::query()->where('m.series_id', $series->id)->reorder('m.chapter_no')->get();
            $i = $chapters->search(fn ($c) => $c->id === $story->id);
            $nav = ['series' => $series, 'total' => $chapters->count(), 'prev' => $i > 0 ? $chapters[$i - 1] : null, 'next' => $chapters[$i + 1] ?? null];
        }

        $corrections = collect(preg_split('/\R/', (string) $story->corrections))->filter()->map(fn ($l) => array_map('trim', explode('|', $l, 2)));
        $view = $hero ? 'nahau.hero' : 'nahau.story';

        return view($view, compact('story', 'key', 'cfg', 'translation', 'related', 'author', 'hero', 'nav', 'corrections'));
    }

    public function author(string $slug)
    {
        $author = NahauAuthor::where('slug', $slug)->firstOrFail();
        $stories = Stories::query()->where('m.author_id', $author->id)->paginate(12);

        return view('nahau.author', compact('author', 'stories'));
    }

    public function series(string $slug)
    {
        $series = NahauSeries::where('slug', $slug)->firstOrFail();
        $chapters = Stories::query()->where('m.series_id', $series->id)->reorder('m.chapter_no')->get();

        return view('nahau.series', compact('series', 'chapters'));
    }

    public function chapter(string $slug, int $n)
    {
        $series = NahauSeries::where('slug', $slug)->firstOrFail();
        $story = Stories::query()->where('m.series_id', $series->id)->where('m.chapter_no', $n)->first();
        abort_unless($story, 404);

        return $this->render($story, $story->section);
    }
}
