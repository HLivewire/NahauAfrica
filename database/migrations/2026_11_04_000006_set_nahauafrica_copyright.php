<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('companies') && Schema::hasColumn('companies', 'copyright')) {
            DB::table('companies')->update(['copyright' => '<strong>2026 All rights reserved. NahauAfrica</strong>']);
        }
    }

    public function down(): void
    {
        // intentionally left empty (footer text is editable from admin settings)
    }
};
