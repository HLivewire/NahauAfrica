<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('nahau_heroes', function (Blueprint $t) {
            $t->boolean('active')->default(false)->after('name');      // a new hero stays hidden until an admin previews it and switches it on
            $t->string('story_pdf')->nullable();                        // private disk; the story may be written text or an uploaded PDF
            $t->string('language', 2)->default('en');
        });
        DB::table('nahau_heroes')->update(['active' => 1]);             // heroes that already existed stay visible
        DB::statement("UPDATE nahau_heroes h JOIN nahau_story_meta m ON m.news_id = h.news_id SET h.language = m.language WHERE m.language IN ('sw','en')");

        Schema::table('nahau_submissions', function (Blueprint $t) {
            $t->unsignedBigInteger('hero_id')->nullable();              // set when an editor publishes a hero story as a hero profile
            $t->timestamp('decided_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('nahau_heroes', fn (Blueprint $t) => $t->dropColumn(['active', 'story_pdf', 'language']));
        Schema::table('nahau_submissions', fn (Blueprint $t) => $t->dropColumn(['hero_id', 'decided_at']));
    }
};
