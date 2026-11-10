<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nahau_authors', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('slug')->unique();
            $t->string('role')->nullable();
            $t->string('city')->nullable();
            $t->text('bio')->nullable();
            $t->string('photo')->nullable();
            $t->string('email')->nullable();      // private
            $t->string('website')->nullable();
            $t->string('social')->nullable();
            $t->boolean('show_on_home')->default(false);
            $t->unsignedInteger('home_order')->default(0);
            $t->timestamps();
        });

        Schema::create('nahau_series', function (Blueprint $t) {
            $t->id();
            $t->string('title');
            $t->string('title_sw')->nullable();
            $t->string('slug')->unique();
            $t->text('description')->nullable();
            $t->string('cover')->nullable();
            $t->unsignedBigInteger('author_id')->nullable();
            $t->string('rhythm')->nullable();
            $t->boolean('featured')->default(false);
            $t->date('next_chapter_date')->nullable();
            $t->timestamps();
        });

        // One row per story (news row) holding the extra storytelling fields.
        Schema::create('nahau_story_meta', function (Blueprint $t) {
            $t->id();
            $t->unsignedBigInteger('news_id')->unique();
            $t->string('slug')->index();
            $t->string('format')->nullable();
            $t->string('label')->default('Fiction');          // content label
            $t->string('language', 2)->default('en');
            $t->string('dek', 220)->nullable();
            $t->unsignedSmallInteger('reading_minutes')->nullable();
            $t->unsignedBigInteger('author_id')->nullable();
            $t->unsignedBigInteger('series_id')->nullable();
            $t->unsignedSmallInteger('chapter_no')->nullable();
            $t->unsignedBigInteger('translation_of')->nullable(); // news id of the other-language story
            $t->boolean('featured')->default(false);
            $t->string('image_alt')->nullable();
            $t->string('image_caption')->nullable();
            $t->string('image_credit')->nullable();
            $t->string('sponsored_by')->nullable();
            $t->boolean('consent_on_file')->default(false);
            $t->text('corrections')->nullable();                // "date | note" per line
            $t->unsignedBigInteger('related_1')->nullable();
            $t->unsignedBigInteger('related_2')->nullable();
            $t->unsignedBigInteger('related_3')->nullable();
            $t->timestamps();
        });

        Schema::create('nahau_heroes', function (Blueprint $t) {
            $t->id();
            $t->unsignedBigInteger('news_id')->unique();
            $t->string('name');
            $t->string('born')->nullable();
            $t->string('died')->nullable();
            $t->string('country')->nullable();
            $t->string('known_for')->nullable();
            $t->string('spotlight_summary', 220)->nullable();
            $t->boolean('show_in_spotlight')->default(false);
            $t->unsignedInteger('spotlight_order')->default(0);
            $t->string('portrait')->nullable();
            $t->string('portrait_credit')->nullable();
            $t->text('sources')->nullable();                    // "title | url" per line
            $t->timestamps();
        });

        Schema::create('nahau_opportunities', function (Blueprint $t) {
            $t->id();
            $t->string('title');
            $t->string('slug')->unique();
            $t->string('type')->default('job');                 // job|internship|training|grant
            $t->string('employer');
            $t->string('location');
            $t->string('terms');
            $t->string('description', 300);
            $t->string('apply_link');
            $t->date('closing_date');
            $t->string('verified_by')->nullable();
            $t->date('verified_on')->nullable();
            $t->string('status')->default('draft');             // draft|published|hidden
            $t->boolean('featured')->default(false);
            $t->timestamps();
        });

        Schema::create('nahau_opportunity_reports', function (Blueprint $t) {
            $t->id();
            $t->unsignedBigInteger('opportunity_id')->index();
            $t->string('reason');
            $t->text('details')->nullable();
            $t->timestamps();
        });

        Schema::create('nahau_submissions', function (Blueprint $t) {
            $t->id();
            $t->string('reference')->unique();
            $t->string('name');
            $t->string('email');
            $t->string('section');
            $t->string('language');
            $t->string('title');
            $t->text('summary')->nullable();
            $t->longText('body')->nullable();
            $t->string('file_path')->nullable();                // private disk
            $t->boolean('original')->default(false);
            $t->boolean('consent')->default(false);
            $t->boolean('published_before')->default(false);
            $t->string('status')->default('new');
            $t->text('notes')->nullable();
            $t->timestamps();
        });

        Schema::create('nahau_messages', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('email');
            $t->string('reason')->default('General enquiry');
            $t->string('page_url')->nullable();
            $t->text('message');
            $t->string('status')->default('new');
            $t->timestamps();
        });

        Schema::create('nahau_opportunity_submissions', function (Blueprint $t) {
            $t->id();
            $t->string('organisation');
            $t->string('contact_person');
            $t->string('email');
            $t->string('phone');
            $t->string('website')->nullable();
            $t->string('title');
            $t->string('type');
            $t->string('location');
            $t->string('terms');
            $t->string('description', 300);
            $t->string('apply_link');
            $t->date('closing_date');
            $t->string('status')->default('new');
            $t->timestamps();
        });

        Schema::create('nahau_subscribers', function (Blueprint $t) {
            $t->id();
            $t->string('email')->unique();
            $t->string('language', 2)->default('en');
            $t->string('token', 64);
            $t->string('consent_text')->nullable();
            $t->timestamp('confirmed_at')->nullable();
            $t->timestamp('unsubscribed_at')->nullable();
            $t->timestamps();
        });

        Schema::create('nahau_pages', function (Blueprint $t) {
            $t->id();
            $t->string('slug')->unique();
            $t->string('title_en');
            $t->string('title_sw')->nullable();
            $t->longText('body_en')->nullable();
            $t->longText('body_sw')->nullable();
            $t->timestamps();
        });

        Schema::create('nahau_team', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('role');
            $t->string('photo')->nullable();
            $t->unsignedInteger('sort')->default(0);
            $t->timestamps();
        });

        $now = now();
        $policy = fn ($t) => '<p>[This page is a template. The final text is supplied by Nahau Africa after legal review.]</p>';
        foreach ([
            ['privacy', 'Privacy notice', 'Taarifa ya faragha'],
            ['terms', 'Terms of use', 'Masharti ya matumizi'],
            ['copyright', 'Copyright', 'Hakimiliki'],
            ['editorial-standards', 'Editorial standards', 'Viwango vya uhariri'],
        ] as [$slug, $en, $sw]) {
            \Illuminate\Support\Facades\DB::table('nahau_pages')->insert([
                'slug' => $slug, 'title_en' => $en, 'title_sw' => $sw,
                'body_en' => $policy($en), 'body_sw' => $policy($sw),
                'created_at' => $now, 'updated_at' => $now,
            ]);
        }
    }

    public function down(): void
    {
        foreach (['team', 'pages', 'subscribers', 'opportunity_submissions', 'messages', 'submissions',
                  'opportunity_reports', 'opportunities', 'heroes', 'story_meta', 'series', 'authors'] as $t) {
            Schema::dropIfExists('nahau_'.$t);
        }
    }
};
