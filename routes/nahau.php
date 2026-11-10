<?php

use App\Http\Controllers\Nahau\FormController;
use App\Http\Controllers\Nahau\PageController;
use App\Http\Controllers\Nahau\SearchController;
use App\Http\Controllers\Nahau\SectionController;
use App\Http\Controllers\Nahau\StoryController;
use Illuminate\Support\Facades\Route;

/*
| NahauAfrica public site (English at "/", Kiswahili under "/sw").
| Route names: n.en.<key> and n.sw.<key>  -> use nroute('<key>').
*/
$pages = config('nahau.pages');
$sections = config('nahau.sections');

foreach (['en' => '', 'sw' => 'sw'] as $loc => $prefix) {
    Route::prefix($prefix)->middleware("nlocale:$loc")->name("n.$loc.")->group(function () use ($loc, $pages, $sections) {
        if ($loc === 'sw') {
            Route::get('/', [PageController::class, 'home'])->name('home');
            Route::get($pages['search'][$loc], [SearchController::class, 'index'])->name('search');
        }

        // Section pages
        foreach ($sections as $key => $s) {
            Route::get($s['slug'][$loc], [SectionController::class, 'show'])->defaults('section', $key)->name($key);
        }
        // Reading page for a book
        Route::get($pages['read'][$loc].'/{slug}', [StoryController::class, 'read'])->name('read');
        // Opportunities
        Route::get($pages['opportunities'][$loc], [SectionController::class, 'opportunities'])->name('opportunities');
        Route::get($pages['opportunities'][$loc].'/{slug}', [SectionController::class, 'opportunity'])->name('opportunity');

        // Series, authors
        Route::get($pages['series'][$loc].'/{slug}', [StoryController::class, 'series'])->name('series');
        Route::get($pages['series'][$loc].'/{slug}/'.$pages['chapter'][$loc].'{n}', [StoryController::class, 'chapter'])->whereNumber('n')->name('chapter');
        Route::get($pages['authors'][$loc].'/{slug}', [StoryController::class, 'author'])->name('author');


        // Static-ish pages
        Route::get($pages['write'][$loc], [PageController::class, 'write'])->name('write');
        Route::get($pages['about'][$loc], [PageController::class, 'about'])->name('about');
        Route::get($pages['contact'][$loc], [PageController::class, 'contact'])->name('contact');
        foreach (['privacy', 'terms', 'copyright', 'standards'] as $p) {
            Route::get($pages[$p][$loc], [PageController::class, 'policy'])->defaults('page', $p === 'standards' ? 'editorial-standards' : $p)->name($p);
        }

        // Story / hero profile: /{section}/{slug}
        $sectionSlugs = collect($sections)->map(fn ($s) => $s['slug'][$loc])->implode('|');
        Route::get('{section}/{slug}', [StoryController::class, 'show'])->where('section', $sectionSlugs)->name('story');
    });
}

// English home and search keep the original route names `home` and `search`
// (a route name can only exist once per URL, and the old site links to these names).
Route::middleware('nlocale:en')->group(function () use ($pages) {
    Route::get('/', [PageController::class, 'home'])->name('home');
    Route::get($pages['search']['en'], [SearchController::class, 'index'])->name('search');
});

// Language-neutral form endpoints
Route::prefix('nahau')->name('nahau.')->group(function () {
    Route::post('write', [FormController::class, 'submitStory'])->middleware('throttle:6,1')->name('write.store');
    Route::post('contact', [FormController::class, 'contact'])->middleware('throttle:6,1')->name('contact.store');
    Route::post('opportunity', [FormController::class, 'submitOpportunity'])->middleware('throttle:6,1')->name('opportunity.store');
    Route::post('opportunity/{id}/report', [FormController::class, 'report'])->middleware('throttle:10,1')->name('report');
    Route::post('newsletter', [FormController::class, 'subscribe'])->middleware('throttle:6,1')->name('newsletter');
    Route::get('newsletter/confirm/{token}', [FormController::class, 'confirm'])->name('newsletter.confirm');
    Route::get('newsletter/unsubscribe/{token}', [FormController::class, 'unsubscribe'])->name('newsletter.unsubscribe');
});

// Favourites (readers must be logged in)
Route::post('/favorites/{news}', [\App\Http\Controllers\Nahau\FavoriteController::class, 'toggle'])->whereNumber('news')->middleware('throttle:60,1')->name('nahau.favorite');
Route::get('/favourites', [\App\Http\Controllers\Nahau\FavoriteController::class, 'index'])->name('nahau.favorites');

// Cart (session based; online payment is not connected yet)
Route::get('/cart', [\App\Http\Controllers\Nahau\CartController::class, 'index'])->name('nahau.cart');
Route::post('/cart/add/{news}', [\App\Http\Controllers\Nahau\CartController::class, 'add'])->whereNumber('news')->middleware('throttle:60,1')->name('nahau.cart.add');
Route::post('/cart/remove/{news}', [\App\Http\Controllers\Nahau\CartController::class, 'remove'])->whereNumber('news')->name('nahau.cart.remove');
