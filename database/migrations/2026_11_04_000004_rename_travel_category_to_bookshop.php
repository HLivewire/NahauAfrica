<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('newscategories')) {
            return;
        }

        DB::table('newscategories')
            ->where(fn ($q) => $q->where('slug', 'travel-news')->orWhere('slug', 'travel')->orWhere('name', 'Travel'))
            ->update(['name' => 'Bookshop', 'slug' => 'bookshop']);

        Cache::forget('maannews.route.newscategories');
    }

    public function down(): void
    {
        if (! Schema::hasTable('newscategories')) {
            return;
        }

        DB::table('newscategories')->where('slug', 'bookshop')->update(['name' => 'Travel', 'slug' => 'travel-news']);
        Cache::forget('maannews.route.newscategories');
    }
};
