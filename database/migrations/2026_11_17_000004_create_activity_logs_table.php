<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('activity_logs')) {
            return;
        }
        Schema::create('activity_logs', function (Blueprint $t) {
            $t->id();
            $t->unsignedBigInteger('user_id')->nullable()->index();
            $t->string('user_name', 150)->nullable();
            $t->string('user_role', 60)->nullable();
            $t->string('guard', 20)->nullable();
            $t->string('action', 30)->index();            // login, logout, login_failed, created, updated, deleted, password_change, role_change
            $t->string('subject_type', 60)->nullable()->index();
            $t->unsignedBigInteger('subject_id')->nullable();
            $t->string('subject_label', 191)->nullable();
            $t->string('description', 255)->nullable();
            $t->json('changes')->nullable();
            $t->string('ip', 64)->nullable();
            $t->string('method', 8)->nullable();
            $t->string('url', 255)->nullable();
            $t->string('user_agent', 255)->nullable();
            $t->timestamp('created_at')->useCurrent()->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
