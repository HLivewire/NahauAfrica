<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('nahau_reads', function (Blueprint $t) {
            $t->id();
            $t->unsignedBigInteger('news_id')->index();
            $t->string('language', 5)->nullable();
            $t->string('country', 2)->nullable();
            $t->string('visitor', 40)->index();     // anonymous daily-salted-free hash, never an IP
            $t->boolean('returning')->default(false);
            $t->date('day')->index();
            $t->timestamp('created_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nahau_reads');
    }
};
