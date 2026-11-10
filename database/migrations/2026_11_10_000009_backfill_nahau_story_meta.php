<?php

use App\Models\News;
use App\Nahau\Stories;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** Give every existing story in the four Nahau sections a slug/meta row. */
    public function up(): void
    {
        if (! Schema::hasTable('nahau_story_meta')) {
            return;
        }
        News::query()
            ->join('newssubcategories', 'news.subcategory_id', '=', 'newssubcategories.id')
            ->join('newscategories', 'newssubcategories.category_id', '=', 'newscategories.id')
            ->whereIn('newscategories.slug', array_keys(config('nahau.sections')))
            ->select('news.*')
            ->get()
            ->each(fn (News $n) => Stories::ensureMeta($n));
    }

    public function down(): void
    {
        //
    }
};
