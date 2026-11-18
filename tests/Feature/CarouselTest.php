<?php

namespace Tests\Feature;

use App\Models\NahauHero;
use App\Models\NahauSlide;
use App\Models\Role;
use App\Models\User;
use App\Nahau\Stories;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CarouselTest extends TestCase
{
    use DatabaseTransactions;

    private $h = ['X-Requested-With' => 'XMLHttpRequest'];

    private function admin(): User
    {
        $u = (new User)->forceFill(['first_name' => 'Car', 'last_name' => 'T', 'email' => 'car-'.uniqid().'@t.test', 'user_name' => 'car'.uniqid(), 'password' => 'Secret12345', 'user_type' => '2', 'is_active' => 1]);
        $u->save();
        $u->roles()->attach(Role::where('slug', 'admin')->firstOrFail()->id);
        $this->actingAs($u);

        return $u;
    }

    private function hero(int $n = 0): NahauHero
    {
        $h = NahauHero::orderBy('id')->skip($n)->first();
        $this->assertNotNull($h, 'demo heroes are seeded');

        return $h;
    }

    private function book()
    {
        return Stories::inSection('fiction')->first();
    }

    public function test_form_has_kind_choice_with_hero_and_book_fields_and_min_four_days(): void
    {
        $this->admin();
        NahauSlide::query()->delete();
        $this->get('/admin/nahau/carousel/create', $this->h)->assertOk()
            ->assertSee('data-dep="kind=hero"', false)->assertSee('data-dep="kind=book"', false)->assertSee('minimum 4');
        $this->postJson('/admin/nahau/carousel', ['slot' => 1, 'kind' => 'hero', 'hero_id' => $this->hero()->id, 'days' => 3], $this->h)->assertStatus(422)->assertJsonValidationErrors('days');
        $this->postJson('/admin/nahau/carousel', ['slot' => 1, 'kind' => 'hero', 'days' => 5], $this->h)->assertStatus(422)->assertJsonValidationErrors('hero_id');
        $this->postJson('/admin/nahau/carousel', ['slot' => 3, 'kind' => 'book', 'days' => 5], $this->h)->assertStatus(422)->assertJsonValidationErrors('news_id');
    }

    public function test_two_heroes_and_two_books_max_and_home_shows_them(): void
    {
        $this->admin();
        NahauSlide::query()->delete();
        $b = $this->book();
        $this->postJson('/admin/nahau/carousel', ['slot' => 1, 'kind' => 'hero', 'hero_id' => $this->hero(0)->id, 'headline' => 'Hero A', 'days' => 4], $this->h)->assertOk();
        $this->postJson('/admin/nahau/carousel', ['slot' => 2, 'kind' => 'hero', 'hero_id' => $this->hero(1)->id, 'headline' => 'Hero B', 'days' => 7], $this->h)->assertOk();
        $this->postJson('/admin/nahau/carousel', ['slot' => 3, 'kind' => 'hero', 'hero_id' => $this->hero(2)->id, 'days' => 7], $this->h)->assertStatus(422)->assertJsonValidationErrors('kind');
        $this->postJson('/admin/nahau/carousel', ['slot' => 2, 'kind' => 'book', 'news_id' => $b->id, 'days' => 7], $this->h)->assertStatus(422)->assertJsonValidationErrors('slot');
        $this->postJson('/admin/nahau/carousel', ['slot' => 3, 'kind' => 'book', 'news_id' => $b->id, 'kicker' => 'New book', 'days' => 10], $this->h)->assertOk();
        $this->postJson('/admin/nahau/carousel', ['slot' => 4, 'kind' => 'book', 'news_id' => $b->id, 'headline' => 'Cream Book', 'days' => 10], $this->h)->assertOk();
        $this->assertEquals(4, NahauSlide::count());
        $this->assertNull(NahauSlide::where('slot', 3)->first()->hero_id);
        $html = $this->get('/')->assertOk()->assertSee('Hero A')->assertSee('Hero B')->assertSee('New book')->assertSee('Cream Book')->assertSee('Read the book')->getContent();
        $this->assertSame(4, substr_count($html, 'role="group" aria-roledescription="slide"'));
        $this->get('/admin/nahau/carousel')->assertOk()->assertSee('days left');
    }

    public function test_expired_slide_leaves_home_and_two_days_left_raises_alerts_and_can_be_extended(): void
    {
        $this->admin();
        NahauSlide::query()->delete();
        $s = NahauSlide::create(['slot' => 1, 'kind' => 'hero', 'hero_id' => $this->hero(0)->id, 'headline' => 'Soon Gone', 'days' => 10, 'starts_at' => now()->subDays(8), 'ends_at' => now()->addDays(2)->subHour()]);
        $this->get('/')->assertSee('Soon Gone');
        $this->get('/admin')->assertOk()->assertSee('Ongeza siku')->assertSee('Soon Gone');
        $this->get('/admin/nahau/carousel')->assertOk()->assertSee('Slide inaisha karibu');   // bell notification
        $s->update(['ends_at' => now()->subHour()]);
        $this->get('/')->assertDontSee('Soon Gone');
        $this->get('/admin')->assertSee('Muda umeisha');
        $this->post('/admin/nahau/carousel/'.$s->id.'/extend', ['days' => 7])->assertRedirect();
        $this->assertTrue($s->fresh()->ends_at->isFuture());
        $this->get('/')->assertSee('Soon Gone');
        $this->get('/admin')->assertDontSee('Ongeza siku');
    }

    public function test_opportunity_pay_or_duration_can_be_empty_and_is_not_shown(): void
    {
        $this->admin();
        $this->postJson('/admin/nahau/opportunities', ['title' => 'No Pay Job', 'type' => 'job', 'employer' => 'Acme', 'location' => 'Dar', 'description' => 'Short', 'closing_date' => now()->addMonth()->toDateString(),
            'apply_link' => 'https://example.com/apply', 'status' => 'draft'], $this->h)->assertOk();
        $this->assertDatabaseHas('nahau_opportunities', ['title' => 'No Pay Job', 'terms' => null]);
        $this->get('/admin/nahau/opportunities/create', $this->h)->assertSee('Pay or duration (optional');
    }

    public function test_inactive_slide_is_hidden_and_colour_is_one_of_three(): void
    {
        $this->admin();
        NahauSlide::query()->delete();
        $s = NahauSlide::create(['slot' => 1, 'kind' => 'hero', 'hero_id' => $this->hero(0)->id, 'headline' => 'Off Slide', 'days' => 10, 'color' => 'gray', 'starts_at' => now(), 'ends_at' => now()->addDays(10)]);
        $this->get('/')->assertSee('Off Slide')->assertSee('--pc:#EDEDED', false);
        $this->get('/admin/nahau/carousel/'.$s->id.'/edit', $this->h)->assertDontSee('name="active"', false);   // the switch lives in the table
        $this->get('/admin/nahau/carousel')->assertSee('data-toggle', false);
        $this->patchJson('/admin/nahau/carousel/'.$s->id.'/toggle/active', ['value' => 0])->assertOk()->assertJson(['value' => 0]);
        $this->assertEquals(0, $s->fresh()->active);
        $this->putJson('/admin/nahau/carousel/'.$s->id, ['slot' => 1, 'kind' => 'hero', 'hero_id' => $this->hero(0)->id, 'headline' => 'Off Slide', 'color' => 'cream', 'days' => 10], $this->h)->assertOk();
        $this->assertEquals(0, $s->fresh()->active);   // saving the form does not switch it back on
        $this->get('/')->assertDontSee('Off Slide');
        $this->get('/admin/nahau/carousel')->assertSee('Inactive');
        $this->putJson('/admin/nahau/carousel/'.$s->id, ['slot' => 1, 'kind' => 'hero', 'hero_id' => $this->hero(0)->id, 'color' => 'pink', 'days' => 10], $this->h)->assertStatus(422)->assertJsonValidationErrors('color');
        $this->get('/admin/nahau/carousel/'.$s->id.'/edit', $this->h)->assertSee('sw-dark', false)->assertSee('sw-cream', false)->assertSee('sw-gray', false);
        $s->update(['active' => 0, 'ends_at' => now()->addHour()]);
        $this->get('/admin')->assertDontSee('Off Slide');   // no expiry alert for a slide that is switched off
    }

    public function test_english_mode_leaves_no_swahili_on_the_new_screens(): void
    {
        $this->admin();
        NahauSlide::query()->delete();
        NahauSlide::create(['slot' => 1, 'kind' => 'hero', 'hero_id' => $this->hero(0)->id, 'days' => 10, 'color' => 'dark', 'starts_at' => now()->subDays(9), 'ends_at' => now()->addDay()]);
        $leaks = [];
        $bad = ['Ongeza', 'Ondoa', 'Chagua', 'Hifadhi', 'Funga', 'Hariri', 'zimebaki', 'Siku ', 'kuisha', 'Tembelea', 'Hakuna', 'Muda ', 'Mpya', 'Kipindi', 'Habari,', 'Badilisha'];
        foreach (['/admin', '/admin/nahau/carousel', '/admin/nahau/carousel/create', '/admin/nahau/heroes', '/admin/nahau/opportunities', '/admin/nahau/opportunities/create', '/admin/nahau/authors', '/admin/nahau/series', '/admin/nahau/submissions', '/admin/nahau/messages', '/admin/nahau/opportunity-submissions', '/admin/nahau/subscribers', '/admin/nahau/pages', '/admin/nahau/team', '/admin/nahau/authors/create', '/admin/nahau/heroes/create', '/admin/panel/users', '/admin/panel/users/create', '/admin/audit'] as $u) {
            $html = $this->withCookie('nh_lang', 'en')->get($u, $u === '/admin/nahau/carousel/create' || str_ends_with($u, '/create') ? $this->h : [])->assertOk()->getContent();
            $text = strip_tags(preg_replace('/<(script|style)\b.*?<\/\1>/si', '', $html));
            foreach ($bad as $w) {
                if (str_contains($text, $w)) {
                    $leaks[] = $u.' => '.$w.' :: '.trim(preg_replace('/\s+/', ' ', mb_substr($text, max(0, mb_strpos($text, $w) - 40), 110)));
                }
            }
        }
        $this->assertSame([], $leaks, 'Swahili left in English mode');
    }
}
