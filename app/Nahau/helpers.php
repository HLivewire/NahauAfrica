<?php

use Illuminate\Support\Str;

if (! function_exists('nlocale')) {
    function nlocale(): string
    {
        return app()->getLocale() === 'sw' ? 'sw' : 'en';
    }
}

/** URL of a Nahau page in the current (or given) language. */
if (! function_exists('nroute')) {
    function nroute(string $name, array $params = [], ?string $locale = null): string
    {
        $locale = $locale ?: nlocale();
        // English Home and Search keep the original route names.
        if ($locale === 'en' && in_array($name, ['home', 'search'], true)) {
            return route($name, $params);
        }

        return route('n.'.$locale.'.'.$name, $params);
    }
}

/** Section config helpers. */
if (! function_exists('nsections')) {
    function nsections(): array
    {
        return config('nahau.sections');
    }
}
if (! function_exists('nsection')) {
    function nsection(string $key, string $field, ?string $locale = null)
    {
        $v = config("nahau.sections.$key.$field");
        return is_array($v) && isset($v['en']) ? ($v[$locale ?: nlocale()] ?? $v['en']) : $v;
    }
}
if (! function_exists('nsection_url')) {
    function nsection_url(string $key, array $query = [], ?string $locale = null): string
    {
        return nroute($key, [], $locale).($query ? '?'.http_build_query($query) : '');
    }
}

/** "17 Oct 2026" / "17 Okt 2026" */
if (! function_exists('ndate')) {
    function ndate($date): string
    {
        if (! $date) {
            return '';
        }
        $d = \Illuminate\Support\Carbon::parse($date);
        $m = nlocale() === 'sw'
            ? ['Jan', 'Feb', 'Mac', 'Apr', 'Mei', 'Jun', 'Jul', 'Ago', 'Sep', 'Okt', 'Nov', 'Des'][$d->month - 1]
            : $d->format('M');
        return $d->day.' '.$m.' '.$d->year;
    }
}

if (! function_exists('nimage')) {
    /** First image of a news row (stored as JSON list), or null. */
    function nimage($news): ?string
    {
        $raw = is_object($news) ? ($news->image ?? null) : $news;
        if (! $raw) {
            return null;
        }
        $list = json_decode($raw, true);
        $first = is_array($list) ? ($list[0] ?? null) : $raw;
        if (! $first) {
            return null;
        }
        // Local file that is missing: let the page show its placeholder instead of a broken image.
        if (is_string($first) && ! preg_match('#^(https?:)?//#i', $first) && config('filesystems.media_disk', 'media') === 'media' && ! is_file(public_path(media_key($first)))) {
            return null;
        }
        return media_url($first);
    }
}

if (! function_exists('nreading')) {
    function nreading(?string $html): int
    {
        return max(1, (int) ceil(str_word_count(strip_tags((string) $html)) / 200));
    }
}

/** Same page in the other language (or that language's Home). */
if (! function_exists('nswitch_url')) {
    function nswitch_url(?string $to = null): string
    {
        $to = $to ?: (nlocale() === 'en' ? 'sw' : 'en');
        $route = request()->route();
        $name = $route?->getName() ?? '';
        if (in_array($name, ['home', 'search'], true)) {
            $name = 'n.en.'.$name;
        }
        if (preg_match('/^n\.(en|sw)\.(.+)$/', $name, $m)) {
            $params = $route->parameters();
            if (isset($params['section'])) {
                foreach (config('nahau.sections') as $k => $s) {
                    if (in_array($params['section'], $s['slug'], true)) {
                        $params['section'] = $s['slug'][$to];
                    }
                }
            }
            // A story's translation (set by an editor) wins over a plain swap.
            if ($m[2] === 'story' && ($t = request()->attributes->get('nahau.translation_url'))) {
                return $t;
            }
            if ($m[2] === 'story') {
                return nroute('home', [], $to);
            }
            $params = array_intersect_key($params, array_flip(['slug', 'n']));
            try {
                $url = nroute($m[2], $params, $to);
            } catch (\Throwable $e) {
                $url = nroute('home', [], $to);
            }
            $qs = request()->query();
            return $qs ? $url.'?'.http_build_query($qs) : $url;
        }

        return nroute('home', [], $to);
    }
}

/** Light sanitising of editor HTML (keeps formatting, drops scripts/handlers). */
if (! function_exists('nclean')) {
    function nclean(?string $html): string
    {
        $html = strip_tags((string) $html, '<p><br><h2><h3><h4><blockquote><strong><b><em><i><u><a><ul><ol><li><img><figure><figcaption><hr><span><sup>');
        $html = preg_replace('/\son\w+\s*=\s*("[^"]*"|\'[^\']*\'|[^\s>]+)/i', '', $html);
        $html = preg_replace('/(href|src)\s*=\s*(["\'])\s*javascript:[^"\']*\2/i', '$1="#"', $html);

        return $html;
    }
}

/** Story ids the signed-in reader has saved as favourites (one query per request). */
if (! function_exists('nfav_ids')) {
    function nfav_ids(): array
    {
        $req = request();
        if (! $req->attributes->has('nahau.fav_ids')) {
            $u = auth('maanuser')->user();
            $req->attributes->set('nahau.fav_ids', $u ? \App\Models\NahauFavorite::where('maanuser_id', $u->id)->pluck('news_id')->all() : []);
        }

        return $req->attributes->get('nahau.fav_ids');
    }
}

/** Split story HTML into book pages of roughly $words words each, never breaking inside a paragraph. */
if (! function_exists('npages')) {
    function npages(?string $html, ?int $words = null): array
    {
        $words = $words ?: (int) config('nahau.words_per_page', 170);
        $parts = preg_split('~(?<=</p>)|(?<=</h2>)|(?<=</h3>)|(?<=</blockquote>)~i', nclean((string) $html), -1, PREG_SPLIT_NO_EMPTY) ?: [];
        $pages = [];
        $cur = '';
        $count = 0;
        foreach ($parts as $part) {
            $cur .= $part;
            $count += str_word_count(strip_tags($part));
            if ($count >= $words) {
                $pages[] = $cur;
                $cur = '';
                $count = 0;
            }
        }
        if (trim(strip_tags($cur)) !== '') {
            $pages[] = $cur;
        }

        return $pages;
    }
}

if (! function_exists('nmoney')) {
    function nmoney($amount): string
    {
        return config('nahau.currency', 'TZS').' '.number_format((float) $amount, 0, '.', ',');
    }
}
