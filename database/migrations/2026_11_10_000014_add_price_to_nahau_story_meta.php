<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('nahau_story_meta', 'price')) {
            Schema::table('nahau_story_meta', function (Blueprint $t) {
                $t->unsignedInteger('price')->nullable();   // book price in whole currency units (TZS); empty = not for sale
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('nahau_story_meta', 'price')) {
            Schema::table('nahau_story_meta', fn (Blueprint $t) => $t->dropColumn('price'));
        }
    }
};
