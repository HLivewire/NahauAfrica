<?php

namespace App\Providers;

use App\Http\Controllers\Frontend\NewsController;
use App\Models\Newscategory;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

/**
 * News categories are created in the admin panel, and every category gets its
 * own named front-end routes (e.g. "business" and "business.details").
 *
 * These used to be registered inside routes/web.php with a database query,
 * which breaks `route:cache`, fresh installs and Laravel Cloud builds
 * (no database during the build). They are now registered at runtime, after
 * the cached/static routes, and the category list is cached.
 */
class CategoryRouteServiceProvider extends ServiceProvider
{
    public const CACHE_KEY = 'maannews.route.newscategories';

    public function boot(): void
    {
        // Never bake these into `route:cache` / `optimize` (they would go stale).
        if ($this->app->runningInConsole() && ! $this->app->runningUnitTests()) {
            return;
        }

        $this->app->booted(function () {
            foreach ($this->categorySlugs() as $slug) {
                Route::middleware('web')->group(function () use ($slug) {
                    Route::get($slug.'/{newscategory?}', [NewsController::class, 'maanNews'])->name($slug);
                    Route::get($slug.'/details/{id}/{slug?}', [NewsController::class, 'maanNewsDetails'])->name($slug.'.details');
                });
            }
            Route::getRoutes()->refreshNameLookups();
            Route::getRoutes()->refreshActionLookups();
        });
    }

    /**
     * @return array<int,string>
     */
    protected function categorySlugs(): array
    {
        try {
            return Cache::remember(self::CACHE_KEY, 300, function () {
                if (! Schema::hasTable('newscategories')) {
                    return [];
                }

                return Newscategory::where('type', 'news')
                    ->orderBy('id')
                    ->pluck('slug')
                    ->filter()
                    ->values()
                    ->all();
            });
        } catch (\Throwable $e) {
            report($e);

            return [];
        }
    }
}
