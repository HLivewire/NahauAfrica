<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useBootstrap();

        // The existing oauth_clients / oauth_access_tokens tables use numeric client ids
        // (created by Passport 10). Passport 13 defaults to UUID clients, so keep numeric ids
        // to leave the database - and every mobile app token already issued - untouched.
        Passport::$clientUuids = false;

        // API rate limiter (previously in RouteServiceProvider).
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        // Role gates used by the admin sidebar (@can('isSuperAdmin') etc.).
        $roleGate = fn (string $slug) => fn (User $user) => $user->roles->first()?->slug === $slug;

        Gate::define('isSuperAdmin', $roleGate('super-admin'));
        Gate::define('isAdmin', $roleGate('admin'));
        Gate::define('isEditor', $roleGate('editor'));
        Gate::define('isAccountent', $roleGate('accountent'));
        Gate::define('isReporter', $roleGate('reporter'));
    }
}
