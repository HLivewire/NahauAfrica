<?php

namespace App\Nahau;

use App\Models\User;

/**
 * NahauAfrica admin panel: role mapping and menu.
 * Letters: A Administrator, E Editor-in-Chief, S Section editor, T Translator, C Contributor.
 */
class Panel
{
    public const ROLES = [
        'A' => ['Administrator', ['super-admin', 'admin']],
        'E' => ['Editor-in-Chief', ['editor']],
        'S' => ['Section editor', ['section-editor']],
        'T' => ['Translator', ['translator']],
        'C' => ['Contributor', ['contributor', 'reporter']],
    ];

    /** Role slug => user_type kept in sync for the legacy admin pages. */
    public const USER_TYPE = ['super-admin' => '4', 'admin' => '3', 'editor' => '2', 'section-editor' => '2', 'translator' => '2', 'contributor' => '0'];

    public static function letter(?User $u = null): ?string
    {
        $u = $u ?: auth()->user();
        if (! $u) {
            return null;
        }
        foreach (['A', 'E', 'S', 'T', 'C'] as $l) {
            foreach (self::ROLES[$l][1] as $slug) {
                if ($u->hasRole($slug)) {
                    return $l;
                }
            }
        }

        return null;
    }

    public static function roleName(?User $u = null): string
    {
        $l = self::letter($u);

        return $l ? self::ROLES[$l][0] : 'Staff';
    }

    public static function isAdmin(?User $u = null): bool
    {
        return self::letter($u) === 'A';
    }

    /** Which roles may open a Nahau resource screen. */
    public const RES = [
        'authors' => 'AES', 'series' => 'AES', 'heroes' => 'AE', 'carousel' => 'AE', 'opportunities' => 'AE', 'submissions' => 'AES',
        'messages' => 'AE', 'opportunity-submissions' => 'AE', 'subscribers' => 'A', 'pages' => 'AE', 'team' => 'AE', 'stories' => 'AEST', 'story' => 'AESTC',
    ];

    public static function canRes(string $res, ?User $u = null): bool
    {
        $l = self::letter($u);

        return $l && str_contains(self::RES[$res] ?? 'A', $l);
    }

    /** Menu: [icon, label, [children]] or [icon, label, url, letters]. Child: [label, url, letters, key]. */
    public static function nav(): array
    {
        $n = fn ($r) => route('admin.nahau.index', $r);
        $l = self::letter();
        $badge = fn ($m, $w) => $m::where($w[0], $w[1])->count();
        $new = \App\Models\NahauSubmission::where('status', 'new')->count()
            + \App\Models\NahauMessage::where('status', 'new')->count()
            + \App\Models\NahauOpportunitySubmission::where('status', 'new')->count();

        $tree = [
            ['s' => 'Home'],
            ['home', 'Dashboard', route('admin.dashboard'), 'AECST', 'dashboard'],
            ['s' => 'Content'],
            ['file', 'Stories', [
                ['Hadithi zote', route('admin.stories'), 'AESTC', 'news'],
                ['Series', $n('series'), 'AES', 'series'],
            ]],
            ['star', 'Carousel', [
                ['Carousel ya Home', $n('carousel'), 'AE', 'carousel'],
                ['Hero profiles', $n('heroes'), 'AE', 'heroes'],
            ], \App\Models\NahauSlide::expiring()->count()],
            ['user', 'Authors', $n('authors'), 'AES', 'authors'],
            ['briefcase', 'Opportunities', $n('opportunities'), 'AE', 'opportunities'],
            ['s' => 'Inbox'],
            ['inbox', 'Inbox', [
                ['Submissions za hadithi', $n('submissions'), 'AES', 'submissions'],
                ['Ujumbe', $n('messages'), 'AE', 'messages'],
                ['Maombi ya fursa', $n('opportunity-submissions'), 'AE', 'opportunity-submissions'],
            ], $new],
            ['s' => 'Audience'],
            ['mail', 'Subscribers', $n('subscribers'), 'A', 'subscribers'],
            ['s' => 'Site'],
            ['globe', 'Site', [
                ['Pages za sera', $n('pages'), 'AE', 'pages'],
                ['Team', $n('team'), 'AE', 'team'],
            ]],
            ['s' => 'Admin'],
            ['users', 'Users na Roles', route('admin.panel.users'), 'A', 'users'],
            ['shield', 'Audit Activity', route('admin.audit'), 'A', 'audit'],
        ];

        $out = [];
        $pend = null;
        foreach ($tree as $t) {
            if (isset($t['s'])) {
                $pend = $t['s'];

                continue;
            }
            if (is_array($t[2])) {
                $kids = array_values(array_filter($t[2], fn ($c) => str_contains($c[2], (string) $l)));
                if (! $kids) {
                    continue;
                }
                $item = ['icon' => $t[0], 'label' => $t[1], 'kids' => $kids, 'badge' => $t[3] ?? null];
            } else {
                if (! str_contains($t[3], (string) $l)) {
                    continue;
                }
                $item = ['icon' => $t[0], 'label' => $t[1], 'url' => $t[2], 'key' => $t[4]];
            }
            if ($pend) {
                $out[] = ['section' => $pend];
                $pend = null;
            }
            $out[] = $item;
        }

        return $out;
    }
}
