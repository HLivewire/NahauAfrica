<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * The original migrations are missing two columns that exist in the SQL dump
 * shipped with Maan News (and that the code uses). On existing databases this
 * migration does nothing; on a fresh `php artisan migrate` it adds them.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('photogalleries') && ! Schema::hasColumn('photogalleries', 'viewers')) {
            Schema::table('photogalleries', function (Blueprint $table) {
                $table->integer('viewers')->nullable()->default(0);
            });
        }

        if (Schema::hasTable('themes') && ! Schema::hasColumn('themes', 'page_slug')) {
            Schema::table('themes', function (Blueprint $table) {
                $table->string('page_slug', 100)->nullable();
            });
        }
    }

    public function down(): void
    {
        //
    }
};
