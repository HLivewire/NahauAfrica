<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('settings')) {
            return;
        }

        $row = [
            'logo'        => 'public/uploads/images/logo/nahau_logo.png',
            'logo_footer' => 'public/uploads/images/logo/nahau_logo_footer.png',
            'favicon'     => 'public/uploads/images/logo/nahau_favicon.png',
            'theme_color' => 'theme-nahau',
        ];
        foreach (array_keys($row) as $column) {
            if (! Schema::hasColumn('settings', $column)) {
                unset($row[$column]);
            }
        }

        if (DB::table('settings')->count() > 0) {
            DB::table('settings')->update($row);
        }
    }

    public function down(): void
    {
        // Branding is data; nothing to roll back.
    }
};
