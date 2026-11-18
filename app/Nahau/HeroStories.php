<?php

namespace App\Nahau;

use App\Models\NahauHero;
use App\Models\NahauStoryMeta;
use App\Models\NahauSubmission;
use App\Models\News;
use App\Models\Newscategory;
use App\Models\Newssubcategory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * A hero profile and its story are one thing for the admin: the story is a news row in "African Heroes"
 * (written text or an uploaded PDF), the profile holds the facts. This class keeps the two in step.
 */
class HeroStories
{
    public const DIR = 'nahau-heroes';

    /** Plain text typed by the admin → paragraphs. HTML that is already there is left alone. */
    public static function html(?string $t): string
    {
        $t = trim((string) $t);
        if ($t === '' || $t !== strip_tags($t)) {
            return $t;
        }

        return collect(preg_split('/\R{2,}/', $t))->map(fn ($p) => '<p>'.nl2br(e(trim($p))).'</p>')->implode("\n");
    }

    /** The reverse, for the edit form: simple <p> paragraphs become blank-line separated text again. */
    public static function text(?string $html): string
    {
        $html = trim((string) $html);
        if ($html === '' || preg_match('/<(?!\/?(p|br)\b)[a-z]/i', $html)) {
            return $html;
        }
        $t = preg_replace('/<br\s*\/?>/i', "\n", $html);
        $t = preg_replace('/<\/p>\s*<p>/i', "\n\n", $t);

        return trim(html_entity_decode(strip_tags($t)));
    }

    public static function hasStory(NahauHero $h): bool
    {
        return (bool) $h->story_pdf || ($h->news_id && trim(strip_tags((string) News::where('id', $h->news_id)->value('description'))) !== '');
    }

    /** A hero is public only while it is active: its story row follows. */
    public static function sync(NahauHero $h): void
    {
        if ($h->news_id) {
            News::where('id', $h->news_id)->update(['status' => $h->active ? 1 : 0]);
        }
    }

    public static function savePdf(NahauHero $h, UploadedFile $f): void
    {
        if ($h->story_pdf) {
            Storage::delete($h->story_pdf);
        }
        $h->story_pdf = $f->store(self::DIR);
    }

    /** Create or update the hero and its story row from admin-form data. */
    public static function save(NahauHero $h, array $d, ?string $text, ?UploadedFile $pdf = null): NahauHero
    {
        $h->fill($d);
        if ($pdf) {
            self::savePdf($h, $pdf);
        }
        $news = $h->news_id ? News::find($h->news_id) : null;
        $body = $text !== null && trim($text) !== '' ? self::html($text) : ($news->description ?? '');
        $summary = trim((string) ($d['spotlight_summary'] ?? '')) ?: ($news->summary ?? $h->name);

        $row = ['title' => $h->name, 'summary' => Str::limit(strip_tags($summary), 250, ''), 'description' => $body,
            'meta_description' => Str::limit(strip_tags($summary), 290), 'status' => $h->active ? 1 : 0];
        if (! $news) {
            $cat = Newscategory::where('slug', 'african-heroes')->firstOrFail();
            $sub = Newssubcategory::where('category_id', $cat->id)->orderBy('id')->firstOrFail();
            $news = new News($row + ['subcategory_id' => $sub->id, 'date' => now()->toDateString(), 'speciality_id' => 1, 'reporter_id' => auth()->id(),
                'user_id' => auth()->id(), 'breaking_news' => 0, 'viewers' => 0, 'image' => json_encode($h->portrait ? [$h->portrait] : '')]);
        } else {
            $news->fill($row);
            if ($h->portrait && (! $news->image || in_array($news->image, ['""', '[]'], true))) {
                $news->image = json_encode([$h->portrait]);
            }
        }
        $news->save();

        $meta = NahauStoryMeta::firstOrNew(['news_id' => $news->id]);
        $meta->fill(['slug' => $meta->slug ?: Stories::makeSlug($h->name, $news->id), 'format' => 'Biography', 'label' => $meta->label ?: 'Researched biography',
            'language' => $h->language ?: 'en', 'dek' => Str::limit(strip_tags($summary), 215, ''), 'reading_minutes' => nreading($body ?: $summary)])->save();

        $h->news_id = $news->id;
        $h->save();

        return $h;
    }

    /** An editor publishes a hero story a reader sent. Returns [hero, wentLive]. A Word-only file becomes a hidden draft. */
    public static function fromSubmission(NahauSubmission $s): array
    {
        $h = new NahauHero(['name' => Str::limit($s->title, 160, ''), 'language' => $s->language === 'Kiswahili' ? 'sw' : 'en', 'spotlight_summary' => Str::limit((string) $s->summary, 320, '')]);
        $isPdf = $s->file_path && strtolower(pathinfo($s->file_path, PATHINFO_EXTENSION)) === 'pdf';
        $hasText = trim((string) $s->body) !== '';
        $live = $hasText || $isPdf;
        $h->active = $live;
        if ($isPdf && Storage::exists($s->file_path)) {
            $to = self::DIR.'/'.Str::random(20).'.pdf';
            Storage::copy($s->file_path, $to);
            $h->story_pdf = $to;
        }
        self::save($h, ['active' => $live], $hasText ? $s->body : null);

        return [$h, $live];
    }
}
