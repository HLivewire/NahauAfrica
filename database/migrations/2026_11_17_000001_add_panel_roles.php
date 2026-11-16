<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/** NahauAfrica admin roles: Section editor, Translator, Contributor (Administrator = admin/super-admin, Editor-in-Chief = editor). */
return new class extends Migration
{
    public function up(): void
    {
        foreach (['section-editor' => 'Section editor', 'translator' => 'Translator', 'contributor' => 'Contributor'] as $slug => $name) {
            if (! DB::table('roles')->where('slug', $slug)->exists()) {
                DB::table('roles')->insert(['name' => $name, 'slug' => $slug, 'created_at' => now(), 'updated_at' => now()]);
            }
        }
    }

    public function down(): void
    {
        DB::table('roles')->whereIn('slug', ['section-editor', 'translator', 'contributor'])->delete();
    }
};
