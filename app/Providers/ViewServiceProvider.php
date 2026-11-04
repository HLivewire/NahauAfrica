<?php

namespace App\Providers;

use App\Models\Advertisement;
use App\Models\Company;
use App\Models\Seooptimization;
use App\Models\Settings;
use App\Models\Socialshare;
use App\Models\Theme;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Build/deploy commands (package:discover, config:cache ...) run without a
        // database, so only touch it for web requests and the test suite.
        if ($this->app->runningInConsole() && ! $this->app->runningUnitTests()) {
            return;
        }

        try {
            if (Schema::hasTable('seooptimizations')) {
                View::share('seooptimization', Seooptimization::first() ?? new Seooptimization());
            }
            if (Schema::hasTable('settings')) {
                View::share('settings', Settings::first() ?? new Settings());
            }
            if (Schema::hasTable('companies')) {
                View::share('companyInfo', Company::first() ?? new Company());
            }
            if (Schema::hasTable('socialshares')) {
                View::share('socials', Socialshare::take(5)->get());
            }
            if (Schema::hasTable('themes')) {
                View::share('themes', Theme::where('is_active', 1)->first());
            }
            if (Schema::hasTable('advertisements')) {
                View::share('advertisement', Advertisement::latest()->first() ?? new Advertisement());
            }
        } catch (\Throwable $e) {
            report($e);
        }
    }
}
