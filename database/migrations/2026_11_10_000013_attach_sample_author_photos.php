<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

// Gives the two sample authors their pictures (safe to run more than once, never overwrites a real photo).
return new class extends Migration
{
    public function up(): void
    {
        if (! DB::getSchemaBuilder()->hasTable('nahau_authors')) {
            return;
        }
        DB::table('nahau_authors')->whereIn('slug', ['amina-mwakyusa', 'juma-mwakyusa'])->update([
            'name' => 'Juma Mwakyusa', 'slug' => 'juma-mwakyusa',
        ]);
        DB::table('nahau_authors')->where('slug', 'juma-mwakyusa')->whereNull('photo')->update(['photo' => 'public/uploads/images/nahau/author_1.jpg']);
        DB::table('nahau_authors')->where('slug', 'baraka-ndege')->whereNull('photo')->update(['photo' => 'public/uploads/images/nahau/author_2.jpg']);
    }

    public function down(): void {}
};
