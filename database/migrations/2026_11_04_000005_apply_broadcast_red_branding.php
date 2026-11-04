<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('settings') || DB::table('settings')->count() === 0) {
            return;
        }

        $row = [
            'logo'        => 'public/uploads/images/logo/broadcast_logo.png',
            'logo_footer' => 'public/uploads/images/logo/broadcast_logo_footer.png',
            'favicon'     => 'public/uploads/images/logo/broadcast_favicon.png',
            'theme_color' => 'theme-broadcast',
        ];
        foreach (array_keys($row) as $column) {
            if (! Schema::hasColumn('settings', $column)) {
                unset($row[$column]);
            }
        }
        DB::table('settings')->update($row);
    }

    public function down(): void
    {
        // Branding is data; nothing to roll back.
    }
};
