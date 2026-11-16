<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Heroes: one summary under the name (320 chars). The old one-line "known for" becomes the summary when none was written.
        DB::statement('ALTER TABLE nahau_heroes MODIFY spotlight_summary VARCHAR(320) NULL');
        DB::statement("UPDATE nahau_heroes SET spotlight_summary = known_for WHERE (spotlight_summary IS NULL OR spotlight_summary = '') AND known_for IS NOT NULL");

        // Opportunities: full job-page content, work mode, posted time, longer apply URL.
        DB::statement('ALTER TABLE nahau_opportunities MODIFY apply_link VARCHAR(500) NOT NULL');
        Schema::table('nahau_opportunities', function (Blueprint $t) {
            $t->string('work_mode', 20)->nullable()->after('type');
            $t->text('about')->nullable();
            $t->text('responsibilities')->nullable();
            $t->text('qualifications')->nullable();
            $t->text('benefits')->nullable();
            $t->text('apply_notes')->nullable();
            $t->text('employer_about')->nullable();
            $t->string('employer_logo')->nullable();
            $t->timestamp('published_at')->nullable();
        });
        DB::statement("UPDATE nahau_opportunities SET published_at = created_at WHERE status = 'published'");
        DB::statement("UPDATE nahau_opportunities SET work_mode = 'full-time' WHERE type = 'job' AND terms LIKE 'Full%'");
    }

    public function down(): void
    {
        Schema::table('nahau_opportunities', function (Blueprint $t) {
            $t->dropColumn(['work_mode', 'about', 'responsibilities', 'qualifications', 'benefits', 'apply_notes', 'employer_about', 'employer_logo', 'published_at']);
        });
    }
};
