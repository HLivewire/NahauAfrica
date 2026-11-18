<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

/** Indexes for the columns the public pages filter and sort by (cheap now, essential once there are thousands of rows). */
return new class extends Migration
{
    private array $indexes = [
        'news' => [['status', 'date'], ['status', 'created_at']],
        'nahau_opportunities' => [['status', 'published_at'], ['status', 'closing_date'], ['type']],
        'nahau_heroes' => [['show_in_spotlight', 'spotlight_order']],
        'nahau_authors' => [['show_on_home', 'home_order']],
        'newscategories' => [['type'], ['slug']],
    ];

    public function up(): void
    {
        foreach ($this->indexes as $table => $list) {
            if (! Schema::hasTable($table)) {
                continue;
            }
            foreach ($list as $cols) {
                if (! Schema::hasColumns($table, $cols) || Schema::hasIndex($table, $cols)) {
                    continue;
                }
                Schema::table($table, fn ($t) => $t->index($cols, 'nx_'.$table.'_'.implode('_', $cols)));
            }
        }
    }

    public function down(): void
    {
        foreach ($this->indexes as $table => $list) {
            foreach ($list as $cols) {
                $name = 'nx_'.$table.'_'.implode('_', $cols);
                if (Schema::hasTable($table) && Schema::hasIndex($table, $name)) {
                    Schema::table($table, fn ($t) => $t->dropIndex($name));
                }
            }
        }
    }
};
