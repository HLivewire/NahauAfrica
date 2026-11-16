<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('users', 'must_change_password')) {
            Schema::table('users', function (Blueprint $t) {
                $t->boolean('must_change_password')->default(false)->after('password');
            });
        }
        // Anybody still on the well-known default password must choose a new one at next sign-in.
        foreach (DB::table('users')->get(['id', 'password']) as $u) {
            if (Hash::check('admin@12345', $u->password)) {
                DB::table('users')->where('id', $u->id)->update(['must_change_password' => true]);
            }
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $t) {
            $t->dropColumn('must_change_password');
        });
    }
};
