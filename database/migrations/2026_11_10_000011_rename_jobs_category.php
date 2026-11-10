<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('newscategories')->where('slug', 'jobs-careers')->update(['name' => 'Jobs']);
    }

    public function down(): void
    {
        DB::table('newscategories')->where('slug', 'jobs-careers')->update(['name' => 'Jobs & Careers']);
    }
};
