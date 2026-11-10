<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $new = [
        ['Fiction', 'fiction'],
        ['Relationships', 'relationships'],
        ['Jobs', 'jobs-careers'],
        ['African Heroes', 'african-heroes'],
    ];

    public function up(): void
    {
        if (! Schema::hasTable('newscategories') || ! Schema::hasTable('newssubcategories')) {
            return;
        }

        $userId = DB::table('users')->orderBy('id')->value('id') ?? 1;
        $slugs = array_column($this->new, 1);

        // Hide the demo categories from the menu (their news stays in the database).
        DB::table('newscategories')->where('type', 'news')->whereNotIn('slug', $slugs)->update(['menu_publish' => 0]);

        foreach ($this->new as [$name, $slug]) {
            $cat = DB::table('newscategories')->where('slug', $slug)->first();
            if (! $cat) {
                $id = DB::table('newscategories')->insertGetId([
                    'name' => $name, 'slug' => $slug, 'type' => 'news',
                    'image' => 'public/uploads/images/news_category/lifestyle.png',
                    'post_counter' => 0, 'menu_publish' => 1, 'user_id' => $userId,
                    'created_at' => now(), 'updated_at' => now(),
                ]);
            } else {
                $id = $cat->id;
                DB::table('newscategories')->where('id', $id)->update(['menu_publish' => 1]);
            }
            if (! DB::table('newssubcategories')->where('category_id', $id)->exists()) {
                DB::table('newssubcategories')->insert([
                    'category_id' => $id, 'name' => 'General', 'user_id' => $userId,
                    'created_at' => now(), 'updated_at' => now(),
                ]);
            }
        }

        Cache::forget('maannews.route.newscategories');
    }

    public function down(): void
    {
        if (! Schema::hasTable('newscategories')) {
            return;
        }
        DB::table('newscategories')->where('type', 'news')->whereNotIn('slug', array_column($this->new, 1))->update(['menu_publish' => 1]);
        DB::table('newscategories')->whereIn('slug', array_column($this->new, 1))->update(['menu_publish' => 0]);
        Cache::forget('maannews.route.newscategories');
    }
};
