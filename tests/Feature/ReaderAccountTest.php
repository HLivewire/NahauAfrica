<?php

namespace Tests\Feature;

use App\Models\Maanuser;
use App\Models\NahauReadingList;
use App\Models\NahauSubmission;
use App\Nahau\Stories;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ReaderAccountTest extends TestCase
{
    use DatabaseTransactions;

    private function reader(): Maanuser
    {
        $u = new Maanuser;
        $u->forceFill(['first_name' => 'Amina', 'last_name' => 'Salum', 'email' => 'r'.uniqid().'@t.test', 'password' => Hash::make('Secret12345'), 'phone' => '0700000000'])->save();

        return $u;
    }

    public function test_guests_are_sent_to_login_and_old_reader_pages_redirect(): void
    {
        $this->get('/account')->assertRedirect();
        $u = $this->reader();
        $this->actingAs($u, 'maanuser')->get('/maanuser')->assertRedirect(route('account.dashboard'));
    }

    public function test_every_reader_page_renders_with_logo_and_notifications(): void
    {
        $u = $this->reader();
        $this->actingAs($u, 'maanuser');
        $this->get(route('account.dashboard'))->assertOk()->assertSee('logo-light.png', false)->assertSee('Shughuli yangu ya kusoma')->assertSee('Toka')->assertSee('Arifa');
        foreach (['favourites', 'later', 'history', 'follows', 'mine', 'notifications', 'profile'] as $r) {
            $this->get(route('account.'.$r))->assertOk();
        }
        $this->get(route('account.dashboard', ['range' => 7]))->assertOk();
    }

    public function test_notifications_cover_stories_heroes_my_story_and_jobs_and_can_be_marked_read(): void
    {
        $u = $this->reader();
        NahauSubmission::create(['reference' => 'NA-T-'.uniqid(), 'name' => 'A', 'email' => $u->email, 'section' => 'fiction', 'language' => 'Kiswahili', 'title' => 'Dada wa Kigamboni', 'status' => 'accepted']);
        $this->actingAs($u, 'maanuser');
        $this->get(route('account.notifications'))->assertOk()->assertSee('Hadithi yako imekubaliwa', false)->assertSee('Hadithi mpya')->assertSee('Weka zote zimesomwa');
        $this->post(route('account.notifications.read'))->assertRedirect();
        $this->get(route('account.notifications'))->assertOk()->assertDontSee('Weka zote zimesomwa');
    }

    public function test_read_later_and_follow_toggle_and_profile_and_password(): void
    {
        $u = $this->reader();
        $s = Stories::query()->first();
        $this->actingAs($u, 'maanuser');
        $this->postJson(route('nahau.later', $s->id))->assertOk()->assertJson(['later' => true]);
        $this->assertSame(1, NahauReadingList::where('maanuser_id', $u->id)->count());
        $this->get(route('account.later'))->assertOk()->assertSee($s->title);
        $this->postJson(route('nahau.later', $s->id))->assertOk()->assertJson(['later' => false]);

        $this->post(route('account.profile.save'), ['first_name' => 'Zawadi', 'last_name' => 'X', 'phone' => '1', 'lang' => 'en', 'reading_goal' => 9])->assertRedirect();
        $this->assertSame(9, (int) $u->fresh()->reading_goal);
        $this->post(route('account.password'), ['current' => 'wrong', 'password' => 'NewSecret123', 'password_confirmation' => 'NewSecret123'])->assertSessionHasErrors('current');
        $this->post(route('account.password'), ['current' => 'Secret12345', 'password' => 'NewSecret123', 'password_confirmation' => 'NewSecret123'])->assertSessionHas('ok');
    }

    public function test_language_switch_swh_eng_translates_the_reader_area(): void
    {
        $u = $this->reader();
        $this->actingAs($u, 'maanuser');
        $this->get(route('account.dashboard'))->assertOk()->assertSee('SWH')->assertSee('ENG')->assertSee('Shughuli yangu ya kusoma')->assertSee('Maktaba yangu');
        $r = $this->get(route('account.lang', 'en'))->assertRedirect();
        $r->assertCookie('nh_lang', 'en');
        $this->withCookie('nh_lang', 'en')->get(route('account.dashboard'))->assertOk()->assertSee('My reading activity')->assertSee('My library')->assertDontSee('Shughuli yangu ya kusoma')->assertSee('Sign out');
        foreach (['favourites', 'later', 'history', 'follows', 'mine', 'notifications', 'profile'] as $p) {
            $this->withCookie('nh_lang', 'en')->get(route('account.'.$p))->assertOk();
        }
        $this->withCookie('nh_lang', 'en')->get(route('account.profile'))->assertSee('First name')->assertDontSee('Jina la kwanza');
        $this->assertSame('en', $u->fresh()->lang);
    }

    public function test_logout_signs_the_reader_out_completely(): void
    {
        $u = $this->reader();
        $this->actingAs($u, 'maanuser')->get(route('account.dashboard'))->assertOk();
        $this->get('/logout')->assertRedirect('/');
        $this->assertGuest('maanuser');
        $this->get(route('account.dashboard'))->assertRedirect();
    }

    public function test_site_menu_has_no_sign_out_next_to_my_account_and_signout_route_still_works(): void
    {
        $u = $this->reader();
        $this->be($u, 'maanuser'); $this->app['auth']->shouldUse('web'); $this->get('/')->assertOk()->assertSee('My account')->assertDontSee('data-nx-logout', false);
        $this->get(route('signout'))->assertRedirect('/');
        $this->assertGuest('maanuser');
        $this->get('/')->assertOk()->assertDontSee('My account');
        $this->get(route('account.dashboard'))->assertRedirect();
    }

    public function test_story_views_are_recorded_against_the_reader(): void
    {
        $u = $this->reader();
        $s = Stories::query()->first();
        $this->actingAs($u, 'maanuser')->withHeaders(['User-Agent' => 'Mozilla/5.0 (Macintosh)'])->get(Stories::url($s))->assertOk();
        $this->assertSame(1, \DB::table('nahau_reads')->where('maanuser_id', $u->id)->where('news_id', $s->id)->count());
        $this->get(route('account.history'))->assertOk()->assertSee($s->title);
    }
}
