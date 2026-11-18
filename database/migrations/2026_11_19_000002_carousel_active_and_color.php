<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('nahau_carousel', function (Blueprint $t) {
            $t->boolean('active')->default(true)->after('kind');
            $t->string('color', 10)->default('dark')->after('active');   // dark | cream | gray (the three site colours)
        });
        foreach ([1 => 'dark', 2 => 'cream', 3 => 'gray', 4 => 'cream'] as $slot => $c) {
            DB::table('nahau_carousel')->where('slot', $slot)->update(['color' => $c]);
        }
    }

    public function down(): void
    {
        Schema::table('nahau_carousel', fn (Blueprint $t) => $t->dropColumn(['active', 'color']));
    }
};
