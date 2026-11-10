<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('nahau_favorites')) {
            return;
        }
        Schema::create('nahau_favorites', function (Blueprint $t) {
            $t->id();
            $t->unsignedBigInteger('maanuser_id')->index();
            $t->unsignedBigInteger('news_id')->index();
            $t->timestamps();
            $t->unique(['maanuser_id', 'news_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nahau_favorites');
    }
};
