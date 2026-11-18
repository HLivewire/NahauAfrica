<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nahau_carousel', function (Blueprint $t) {
            $t->id();
            $t->unsignedTinyInteger('slot')->unique();          // 1..4, the order on the Home carousel
            $t->string('kind', 10);                              // hero | book
            $t->unsignedBigInteger('hero_id')->nullable();
            $t->unsignedBigInteger('news_id')->nullable();       // the book (a fiction story)
            $t->string('headline', 160)->nullable();
            $t->string('kicker', 60)->nullable();                // book only, e.g. "Book of the week"
            $t->string('summary', 320)->nullable();
            $t->string('image')->nullable();
            $t->unsignedSmallInteger('days')->default(4);
            $t->timestamp('starts_at')->nullable();
            $t->timestamp('ends_at')->nullable();
            $t->timestamps();
        });

        // The heroes that were already on the Home spotlight keep their place (first two), 30 days.
        if (Schema::hasTable('nahau_heroes')) {
            $slot = 1;
            foreach (DB::table('nahau_heroes')->where('show_in_spotlight', 1)->orderBy('spotlight_order')->limit(2)->get() as $h) {
                DB::table('nahau_carousel')->insert(['slot' => $slot++, 'kind' => 'hero', 'hero_id' => $h->id, 'days' => 30, 'starts_at' => now(), 'ends_at' => now()->addDays(30), 'created_at' => now(), 'updated_at' => now()]);
            }
        }

        // Pay or duration is optional: some jobs do not state it.
        foreach (['nahau_opportunities', 'nahau_opportunity_submissions'] as $tb) {
            if (Schema::hasTable($tb) && Schema::hasColumn($tb, 'terms')) {
                DB::statement("ALTER TABLE {$tb} MODIFY terms VARCHAR(255) NULL");
            }
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('nahau_carousel');
    }
};
