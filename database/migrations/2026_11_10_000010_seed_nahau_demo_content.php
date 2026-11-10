<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

// Loads the sample stories, heroes, authors and pictures once, so the site is not empty.
// Disable with NAHAU_SEED_DEMO=false (e.g. on production) before running migrations.
return new class extends Migration
{
    public function up(): void
    {
        if (! config('nahau.seed_demo') || DB::table('nahau_authors')->exists()) {
            return;
        }
        Artisan::call('db:seed', ['--class' => \Database\Seeders\NahauDemoSeeder::class, '--force' => true]);
    }

    public function down(): void {}
};
