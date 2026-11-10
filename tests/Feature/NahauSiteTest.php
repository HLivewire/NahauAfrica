<?php

namespace Tests\Feature;

use App\Models\NahauOpportunity;
use App\Models\NahauSubmission;
use Database\Seeders\NahauDemoSeeder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class NahauSiteTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(NahauDemoSeeder::class);
    }

    public function test_public_pages_render_in_both_languages(): void
    {
        foreach (['/', '/sw/', '/fiction', '/sw/hadithi', '/relationships', '/sw/mahusiano', '/jobs-careers', '/jobs-careers/opportunities',
                  '/sw/kazi/fursa', '/african-heroes', '/sw/mashujaa', '/write-for-us', '/sw/andika-nasi', '/about', '/sw/kuhusu',
                  '/contact', '/privacy', '/terms', '/copyright', '/editorial-standards', '/search?q=bus', '/sw/tafuta?q=bus',
                  '/fiction/the-last-bus-to-morogoro', '/african-heroes/wangari-maathai', '/series/mto-wa-kesho',
                  '/series/mto-wa-kesho/chapter-2', '/authors/amina-mwakyusa'] as $url) {
            $this->get($url)->assertOk();
        }
        $this->get('/no-such-page')->assertNotFound()->assertSee("We couldn't find that page");
    }

    public function test_section_filter_and_language_switch(): void
    {
        $this->get('/fiction?format=Flash+fiction')->assertSee('Nyumba ya Bibi')->assertDontSee('The Last Bus to Morogoro');
        $this->get('/sw/hadithi')->assertSee('lang="sw"', false)->assertSee('Hadithi');
        $this->get('/fiction')->assertSee('href="'.url('/sw/hadithi').'"', false);
    }

    public function test_opportunity_expiry_reports_and_verification(): void
    {
        $o = NahauOpportunity::where('slug', 'junior-editor')->first();
        $this->get('/jobs-careers/opportunities')->assertSee('Junior Editor');

        $o->update(['closing_date' => now('Africa/Dar_es_Salaam')->subDay()->toDateString()]);
        $this->get('/jobs-careers/opportunities')->assertDontSee('Junior Editor');
        $o->update(['closing_date' => now()->addDays(5)->toDateString(), 'verified_by' => null]);
        $this->get('/jobs-careers/opportunities')->assertDontSee('Junior Editor');   // unverified never shows
        $o->update(['verified_by' => 'Editor', 'status' => 'published']);

        for ($i = 0; $i < 3; $i++) {
            $this->postJson(route('nahau.report', $o->id), ['reason' => 'Fake employer'])->assertOk();
        }
        $this->get('/jobs-careers/opportunities')->assertDontSee('Junior Editor');   // 3 reports hide it
        $this->assertSame('hidden', $o->fresh()->status);
    }

    public function test_forms_validate_and_save(): void
    {
        $this->post(route('nahau.write.store'), [])->assertSessionHasErrors(['name', 'email', 'title', 'original']);
        $this->post(route('nahau.write.store'), ['name' => 'Asha Mushi', 'email' => 'asha@example.com', 'section' => 'fiction', 'language' => 'English', 'title' => 'My story', 'body' => 'Once upon a time', 'original' => 1])
            ->assertSessionHas('nahau_ok');
        $this->assertSame(1, NahauSubmission::where('email', 'asha@example.com')->count());

        $this->post(route('nahau.write.store'), ['nx_website' => 'spam'])->assertSessionHas('nahau_ok');   // honeypot
        $this->assertSame(1, NahauSubmission::count());

        $this->post(route('nahau.contact.store'), ['name' => 'A', 'email' => 'bad', 'message' => ''])->assertSessionHasErrors(['email', 'message']);
        $this->post(route('nahau.contact.store'), ['name' => 'A', 'email' => 'a@b.co', 'reason' => 'Correction request', 'message' => 'Typo'])->assertSessionHas('nahau_ok');

        $this->postJson(route('nahau.newsletter'), ['email' => 'reader@example.com'])->assertOk();
        $this->assertDatabaseHas('nahau_subscribers', ['email' => 'reader@example.com', 'confirmed_at' => null]);
        $token = \App\Models\NahauSubscriber::where('email', 'reader@example.com')->value('token');
        $this->get(route('nahau.newsletter.confirm', $token))->assertRedirect();
        $this->assertNotNull(\App\Models\NahauSubscriber::where('email', 'reader@example.com')->value('confirmed_at'));
    }

    public function test_admin_screens_and_publish_rule(): void
    {
        $this->actingAs(\App\Models\User::whereHas('roles', fn ($q) => $q->where('slug', 'super-admin'))->firstOrFail());
        $this->get('/admin/nahau')->assertOk();
        foreach (['stories', 'authors', 'series', 'heroes', 'opportunities', 'submissions', 'messages', 'opportunity-submissions', 'subscribers', 'pages', 'team'] as $res) {
            $this->get('/admin/nahau/'.$res)->assertOk();
        }
        $this->get('/admin/nahau/opportunities/create')->assertOk();
        $base = ['title' => 'Test job', 'type' => 'job', 'employer' => 'X', 'location' => 'Dar', 'terms' => 'Full-time', 'description' => 'd', 'apply_link' => 'https://x.co', 'closing_date' => now()->addDays(3)->toDateString(), 'status' => 'published'];
        $this->post('/admin/nahau/opportunities', $base)->assertSessionHasErrors('verified_by');
        $this->post('/admin/nahau/opportunities', $base + ['verified_by' => 'Ed', 'verified_on' => now()->toDateString()])->assertRedirect();
        $meta = \App\Models\NahauStoryMeta::first();
        $this->get('/admin/nahau/stories/'.$meta->id.'/edit')->assertOk();
    }

    public function test_google_login_degrades_gracefully_when_not_configured(): void
    {
        config(['services.google.client_id' => null]);
        $this->get('/auth/google')->assertRedirect(route('home'));
        $this->get('/')->assertSee('Continue with Google');
    }
}
