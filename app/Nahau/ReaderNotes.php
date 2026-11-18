<?php

namespace App\Nahau;

use App\Models\Maanuser;
use App\Models\NahauHero;
use App\Models\NahauOpportunity;
use App\Models\NahauSubmission;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/** Live notifications for a signed-in reader: built from the site's own data, nothing to keep in sync. */
class ReaderNotes
{
    public const TYPES = [
        'story' => ['file', 'Hadithi mpya'], 'hero' => ['star', 'African Hero mpya'], 'mine' => ['send', 'Hadithi yako'],
        'job' => ['briefcase', 'Kazi mpya'], 'opp' => ['flag', 'Fursa mpya'],
    ];

    public static function statusText(string $s): array
    {
        return match ($s) {
            'new' => ['Tumepokea hadithi yako', 'Wahariri wataipitia hivi karibuni.'],
            'under_review' => ['Hadithi yako inapitiwa', 'Wahariri wanaisoma sasa.'],
            'revisions' => ['Hadithi yako inahitaji marekebisho', 'Angalia maelezo ya mhariri na uitume tena.'],
            'accepted' => ['Hadithi yako imekubaliwa', 'Itachapishwa hivi karibuni. Hongera!'],
            'declined' => ['Hadithi yako haijakubaliwa', 'Asante kwa kuandika. Unaweza kutuma nyingine.'],
            default => ['Hadithi yako imebadilika', $s],
        };
    }

    public static function for(Maanuser $u, int $limit = 40): array
    {
        $seen = $u->notif_seen_at;
        $out = [];
        $add = function (string $type, string $title, string $body, string $url, $at) use (&$out, $seen) {
            $at = $at instanceof Carbon ? $at : Carbon::parse($at);
            $out[] = ['type' => $type, 'icon' => self::TYPES[$type][0], 'label' => self::TYPES[$type][1], 'title' => $title, 'body' => $body, 'url' => $url, 'at' => $at, 'unread' => ! $seen || $at->gt($seen)];
        };

        foreach (Stories::query()->where('news.date', '>=', now()->subDays(45)->toDateString())->limit(8)->get() as $s) {
            $add('story', Str::limit($s->title, 70), 'Imetoka hivi punde kwenye '.nsection($s->section, 'name', 'en'), Stories::url($s), $s->date ?: $s->created_at);
        }
        foreach (NahauHero::query()->orderByDesc('id')->limit(4)->get() as $h) {
            $st = Stories::query()->where('news.id', $h->news_id)->first();
            if ($st) {
                $add('hero', $h->name, 'Hadithi mpya ya African Heroes imechapishwa.', Stories::url($st), $h->created_at);
            }
        }
        foreach (NahauSubmission::where('email', $u->email)->orderByDesc('updated_at')->limit(6)->get() as $sub) {
            [$t, $b] = self::statusText((string) $sub->status);
            $add('mine', $t, '"'.Str::limit($sub->title, 50).'" · '.$b, route('account.mine'), $sub->updated_at);
        }
        foreach (NahauOpportunity::open()->orderByDesc('id')->limit(8)->get() as $o) {
            $isJob = $o->type === 'job';
            $add($isJob ? 'job' : 'opp', $o->title, $o->employer.' · inafungwa '.Carbon::parse($o->closing_date)->format('d M'), nroute('opportunity', ['slug' => $o->slug]), $o->created_at);
        }
        usort($out, fn ($a, $b) => $b['at']->timestamp <=> $a['at']->timestamp);

        return array_slice($out, 0, $limit);
    }

    public static function unread(array $notes): int
    {
        return count(array_filter($notes, fn ($n) => $n['unread']));
    }
}
