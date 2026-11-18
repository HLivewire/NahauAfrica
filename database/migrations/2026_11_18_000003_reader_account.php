<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('nahau_reading_list', function (Blueprint $t) {
            $t->id();
            $t->unsignedBigInteger('maanuser_id')->index();
            $t->unsignedBigInteger('news_id')->index();
            $t->timestamps();
            $t->unique(['maanuser_id', 'news_id']);
        });
        Schema::create('nahau_follows', function (Blueprint $t) {
            $t->id();
            $t->unsignedBigInteger('maanuser_id')->index();
            $t->unsignedBigInteger('author_id')->index();
            $t->timestamps();
            $t->unique(['maanuser_id', 'author_id']);
        });
        Schema::table('nahau_reads', function (Blueprint $t) {
            $t->unsignedBigInteger('maanuser_id')->nullable()->index()->after('news_id');
        });
        Schema::table('maanusers', function (Blueprint $t) {
            $t->timestamp('notif_seen_at')->nullable();
            $t->unsignedSmallInteger('reading_goal')->default(6);
            $t->string('lang', 2)->default('sw');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nahau_reading_list');
        Schema::dropIfExists('nahau_follows');
        Schema::table('nahau_reads', fn (Blueprint $t) => $t->dropColumn('maanuser_id'));
        Schema::table('maanusers', fn (Blueprint $t) => $t->dropColumn(['notif_seen_at', 'reading_goal', 'lang']));
    }
};
