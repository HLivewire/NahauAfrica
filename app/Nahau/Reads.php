<?php

namespace App\Nahau;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/** Anonymous per-day story reads for the admin dashboard (no IP stored, bots skipped). */
class Reads
{
    public static function record(int $newsId, ?string $lang): void
    {
        try {
            $r = request();
            if ($r->isMethod('HEAD') || preg_match('/bot|crawl|spider|slurp|preview|monitor/i', (string) $r->userAgent())) {
                return;
            }
            if (! Schema::hasTable('nahau_reads')) {
                return;
            }
            $visitor = substr(hash('sha256', config('app.key').'|'.$r->ip().'|'.$r->userAgent()), 0, 32);
            $country = strtoupper((string) ($r->header('CF-IPCountry') ?: $r->header('CloudFront-Viewer-Country') ?: ''));
            $country = preg_match('/^[A-Z]{2}$/', $country) && $country !== 'XX' ? $country : null;
            $seen = DB::table('nahau_reads')->where('visitor', $visitor)->where('day', '<', now()->toDateString())->exists();
            DB::table('nahau_reads')->insert([
                'news_id' => $newsId, 'language' => $lang === 'en' ? 'en' : ($lang ? 'sw' : null), 'country' => $country,
                'visitor' => $visitor, 'returning' => $seen, 'day' => now()->toDateString(), 'created_at' => now(),
            ]);
        } catch (\Throwable $e) {
            // analytics must never break a story page
        }
    }
}
