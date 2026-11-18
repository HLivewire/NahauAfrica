<?php

namespace App\Nahau;

use App\Models\ActivityLog;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;

/** Audit Activity: who did what, when, from where. Never throws into the request. */
class Audit
{
    /** Models that are noise or that would log themselves. */
    private const SKIP = [ActivityLog::class, \App\Models\NahauFavorite::class, \App\Models\Googleanalytic::class];

    /** Columns that change without a human decision. */
    private const QUIET = ['updated_at', 'created_at', 'views', 'view', 'view_count', 'hits', 'remember_token', 'last_login_at'];

    private const SECRET = ['password', 'remember_token', 'api_token', 'token', 'secret'];

    private const NAMES = [
        'News' => 'Story', 'NahauHero' => 'Hero', 'NahauAuthor' => 'Author', 'NahauOpportunity' => 'Opportunity', 'NahauSeries' => 'Series',
        'NahauPage' => 'Page', 'NahauTeam' => 'Team', 'NahauSubscriber' => 'Subscriber', 'NahauMessage' => 'Ujumbe', 'NahauSubmission' => 'Submission ya hadithi',
        'NahauOpportunitySubmission' => 'Ombi la fursa', 'NahauOpportunityReport' => 'Ripoti ya fursa', 'NahauStoryMeta' => 'Story details',
        'User' => 'User', 'Maanuser' => 'Msomaji', 'Newscomment' => 'Comment', 'Settings' => 'Settings', 'Role' => 'Role',
    ];

    public static function enabled(): bool
    {
        return ! app()->runningInConsole() || app()->runningUnitTests();
    }

    public static function boot(): void
    {
        foreach (['created', 'updated', 'deleted'] as $ev) {
            Event::listen("eloquent.$ev: *", function ($name, $payload) use ($ev) {
                $m = $payload[0] ?? null;
                if ($m instanceof Model) {
                    self::model($ev, $m);
                }
            });
        }
        Event::listen(Login::class, fn (Login $e) => self::log('login', $e->user, 'Ameingia kwenye mfumo', null, $e->guard));
        Event::listen(Logout::class, fn (Logout $e) => $e->user ? self::log('logout', $e->user, 'Ametoka kwenye mfumo', null, $e->guard) : null);
    }

    private static function model(string $ev, Model $m): void
    {
        if (! self::enabled() || in_array($m::class, self::SKIP, true) || ! str_starts_with($m::class, 'App\\Models\\') || str_starts_with($m::class, 'App\\Models\\Api\\')) {
            return;
        }
        $changes = null;
        $action = $ev;
        if ($ev === 'updated') {
            $dirty = array_diff_key($m->getChanges(), array_flip(self::QUIET));
            if (! $dirty) {
                return;
            }
            $changes = [];
            foreach ($dirty as $k => $new) {
                $changes[$k] = in_array($k, self::SECRET, true) ? ['•••', '•••'] : [self::clip($m->getOriginal($k)), self::clip($new)];
            }
            if (isset($dirty['password'])) {
                $action = 'password_change';
            }
        } elseif ($ev === 'created') {
            $changes = [];
            foreach (array_diff_key($m->getAttributes(), array_flip(self::QUIET)) as $k => $v) {
                if ($v !== null && $v !== '') {
                    $changes[$k] = [null, in_array($k, self::SECRET, true) ? '•••' : self::clip($v)];
                }
            }
        }
        $verb = ActivityLog::ACTIONS[$action] ?? $action;
        self::log($action, $m, $verb.' '.self::typeName($m).': '.self::label($m), $changes);
    }

    public static function log(string $action, ?Model $subject = null, ?string $description = null, ?array $changes = null, ?string $guard = null, bool $force = false): void
    {
        if (! $force && ! self::enabled()) {
            return;
        }
        try {
            $console = $guard === 'console';
            $actor = (! $console && $guard && $guard !== 'web' && Auth::guard($guard)->check()) ? Auth::guard($guard)->user() : null;
            $actor = $console ? null : ($actor ?: ($subject instanceof \App\Models\User && in_array($action, ['login', 'logout'], true) ? $subject : (Auth::guard('web')->user() ?: Auth::guard('maanuser')->user())));
            $req = request();
            ActivityLog::create([
                'user_id' => $actor?->getAuthIdentifier(),
                'user_name' => $console ? 'Server (console)' : ($actor ? (self::label($actor) ?: 'User') : 'Mgeni'),
                'user_role' => $actor instanceof \App\Models\User ? Panel::roleName($actor) : ($actor ? 'Msomaji' : null),
                'guard' => $guard ?: ($actor instanceof \App\Models\Maanuser ? 'maanuser' : 'web'),
                'action' => $action,
                'subject_type' => $subject ? self::typeName($subject) : null,
                'subject_id' => $subject?->getKey(),
                'subject_label' => $subject ? mb_substr(self::label($subject), 0, 190) : null,
                'description' => mb_substr((string) $description, 0, 250),
                'changes' => $changes ?: null,
                'ip' => $req?->ip(),
                'method' => $req?->method(),
                'url' => $req ? mb_substr('/'.ltrim($req->path(), '/'), 0, 250) : null,
                'user_agent' => $req ? mb_substr((string) $req->userAgent(), 0, 250) : null,
            ]);
        } catch (\Throwable $e) {
            report($e);
        }
    }

    public static function typeName(Model $m): string
    {
        return self::NAMES[class_basename($m)] ?? class_basename($m);
    }

    public static function label(Model $m): string
    {
        if ($m instanceof \App\Models\User) {
            return trim($m->first_name.' '.$m->last_name) ?: (string) $m->email;
        }
        foreach (['title', 'name', 'email', 'slug', 'headline'] as $k) {
            if (filled($m->getAttribute($k))) {
                return (string) $m->getAttribute($k);
            }
        }

        return '#'.$m->getKey();
    }

    private static function clip($v)
    {
        if (is_array($v) || is_object($v)) {
            $v = json_encode($v, JSON_UNESCAPED_UNICODE);
        }

        return is_string($v) && mb_strlen($v) > 300 ? mb_substr($v, 0, 300).'…' : $v;
    }
}
