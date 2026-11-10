<?php

namespace App\Nahau;

use App\Models\News;
use App\Models\NahauStoryMeta;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Stories are rows of the existing `news` table that sit in one of the four
 * Nahau sections (news categories), plus extra fields in nahau_story_meta.
 */
class Stories
{
    public static function query()
    {
        return News::query()
            ->join('newssubcategories', 'news.subcategory_id', '=', 'newssubcategories.id')
            ->join('newscategories', 'newssubcategories.category_id', '=', 'newscategories.id')
            ->leftJoin('nahau_story_meta as m', 'm.news_id', '=', 'news.id')
            ->leftJoin('nahau_authors as a', 'a.id', '=', 'm.author_id')
            ->leftJoin('users as u', 'u.id', '=', 'news.reporter_id')
            ->where('news.status', 1)
            ->whereIn('newscategories.slug', array_keys(config('nahau.sections')))
            ->select([
                'news.id', 'news.title', 'news.summary', 'news.description', 'news.image', 'news.date', 'news.tags',
                'news.meta_description', 'news.updated_at',
                'newscategories.slug as section',
                'm.slug', 'm.format', 'm.label', 'm.language', 'm.dek', 'm.reading_minutes', 'm.author_id',
                'm.series_id', 'm.chapter_no', 'm.translation_of', 'm.featured', 'm.image_alt', 'm.image_caption',
                'm.image_credit', 'm.sponsored_by', 'm.corrections', 'm.related_1', 'm.related_2', 'm.related_3',
                'a.name as author_name', 'a.slug as author_slug',
                DB::raw("CONCAT(u.first_name,' ',u.last_name) as reporter_name"),
            ])
            ->orderByDesc('news.date')->orderByDesc('news.id');
    }

    public static function inSection(string $section)
    {
        return static::query()->where('newscategories.slug', $section);
    }

    public static function find(string $section, string $slug)
    {
        return static::inSection($section)->where('m.slug', $slug)->first();
    }

    public static function url($s, ?string $locale = null): string
    {
        $locale = $locale ?: nlocale();

        return route('n.'.$locale.'.story', [
            'section' => nsection($s->section, 'slug', $locale),
            'slug' => $s->slug ?: Str::slug($s->title).'-'.$s->id,
        ]);
    }

    public static function authorName($s): string
    {
        return $s->author_name ?: ($s->reporter_name ?: 'Nahau Africa');
    }

    public static function dek($s): string
    {
        return Str::limit($s->dek ?: ($s->summary ?: strip_tags((string) $s->description)), 140);
    }

    public static function minutes($s): int
    {
        return $s->reading_minutes ?: nreading($s->description);
    }

    public static function format($s): string
    {
        return $s->format ?: '';
    }

    /** Unique, stable slug for a news row. */
    public static function makeSlug(string $title, ?int $ignoreNewsId = null): string
    {
        $base = Str::slug(Str::limit($title, 80, '')) ?: 'story';
        $slug = $base;
        $i = 2;
        while (NahauStoryMeta::where('slug', $slug)->when($ignoreNewsId, fn ($q) => $q->where('news_id', '!=', $ignoreNewsId))->exists()) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }

    /** Make sure a news row has a meta row (used by the model observer). */
    public static function ensureMeta(News $news): NahauStoryMeta
    {
        $meta = NahauStoryMeta::firstOrNew(['news_id' => $news->id]);
        if (! $meta->exists) {
            $meta->slug = static::makeSlug($news->title, $news->id);
            $meta->language = 'en';
            $meta->reading_minutes = nreading($news->description);
            $meta->save();
        } elseif (! $meta->slug) {
            $meta->slug = static::makeSlug($news->title, $news->id);
            $meta->save();
        }

        return $meta;
    }
}
