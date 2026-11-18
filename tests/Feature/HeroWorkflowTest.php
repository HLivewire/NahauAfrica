<?php

namespace Tests\Feature;

use App\Models\Maanuser;
use App\Models\NahauHero;
use App\Models\NahauSlide;
use App\Models\NahauSubmission;
use App\Models\News;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class HeroWorkflowTest extends TestCase
{
    use DatabaseTransactions;

    private $h = ['X-Requested-With' => 'XMLHttpRequest'];

    private function admin(): User
    {
        $u = (new User)->forceFill(['first_name' => 'Her', 'last_name' => 'T', 'email' => 'her-'.uniqid().'@t.test', 'user_name' => 'her'.uniqid(), 'password' => 'Secret12345', 'user_type' => '2', 'is_active' => 1]);
        $u->save();
        $u->roles()->attach(Role::where('slug', 'admin')->firstOrFail()->id);
        $this->actingAs($u);

        return $u;
    }

    private function newHero(array $extra = [])
    {
        return $this->postJson('/admin/nahau/heroes', $extra + ['name' => 'Mama Test Hero', 'language' => 'en', 'country' => 'Tanzania', 'story_text' => "First paragraph.\n\nSecond paragraph."], $this->h);
    }

    public function test_new_hero_with_written_story_is_hidden_until_previewed_and_switched_on(): void
    {
        $this->admin();
        $this->postJson('/admin/nahau/heroes', ['name' => 'No Story', 'language' => 'en'], $this->h)->assertStatus(422)->assertJsonValidationErrors('story_text');
        $this->newHero()->assertOk();
        $hero = NahauHero::where('name', 'Mama Test Hero')->firstOrFail();
        $news = News::find($hero->news_id);
        $this->assertFalse((bool) $hero->active);
        $this->assertEquals(0, $news->status);
        $this->assertStringContainsString('<p>Second paragraph.</p>', $news->description);

        $slug = \DB::table('nahau_story_meta')->where('news_id', $news->id)->value('slug');
        $public = '/african-heroes/'.$slug;
        auth()->logout();
        $this->get($public)->assertNotFound();

        $this->admin();
        $this->get('/admin/nahau/heroes/'.$hero->id.'/preview')->assertOk()->assertSee('Mama Test Hero')->assertSee('Second paragraph.')->assertSee('Washa (Active)');
        $this->get('/admin/nahau/heroes')->assertOk()->assertSee('data-toggle', false)->assertSee('heroes/'.$hero->id.'/preview', false);

        $this->patchJson('/admin/nahau/heroes/'.$hero->id.'/toggle/active', ['value' => 1])->assertOk()->assertJson(['value' => 1]);
        $this->assertEquals(1, $news->fresh()->status);
        auth()->logout();
        $this->get($public)->assertOk()->assertSee('Mama Test Hero');
    }

    public function test_hero_story_can_be_a_pdf_that_is_private_until_active_and_edit_shows_the_text(): void
    {
        Storage::fake();
        $this->admin();
        $this->newHero(['name' => 'Pdf Hero', 'story_text' => '', 'story_pdf' => UploadedFile::fake()->create('story.pdf', 80, 'application/pdf')])->assertOk();
        $hero = NahauHero::where('name', 'Pdf Hero')->firstOrFail();
        $this->assertNotNull($hero->story_pdf);
        Storage::assertExists($hero->story_pdf);
        $this->get(route('hero.pdf', $hero->id))->assertOk();   // staff can open it for the preview
        auth()->logout();
        $this->get(route('hero.pdf', $hero->id))->assertNotFound();   // readers cannot while inactive
        $this->admin();
        $this->patchJson('/admin/nahau/heroes/'.$hero->id.'/toggle/active', ['value' => 1])->assertOk();
        auth()->logout();
        $this->get(route('hero.pdf', $hero->id))->assertOk();

        $this->admin();
        $this->newHero(['name' => 'Edit Hero'])->assertOk();
        $e = NahauHero::where('name', 'Edit Hero')->firstOrFail();
        $this->get('/admin/nahau/heroes/'.$e->id.'/edit', $this->h)->assertOk()->assertSee("First paragraph.\n\nSecond paragraph.", false)->assertSee('Preview');
        $this->putJson('/admin/nahau/heroes/'.$e->id, ['name' => 'Edit Hero', 'language' => 'sw', 'story_text' => 'Rewritten.'], $this->h)->assertOk();
        $this->assertStringContainsString('Rewritten.', News::find($e->fresh()->news_id)->description);
        $this->assertSame('sw', \DB::table('nahau_story_meta')->where('news_id', $e->news_id)->value('language'));
    }

    public function test_hero_cannot_be_switched_on_without_a_story_and_all_heroes_are_in_the_carousel_list(): void
    {
        $this->admin();
        $this->newHero(['name' => 'Empty Hero'])->assertOk();
        $empty = NahauHero::where('name', 'Empty Hero')->firstOrFail();
        News::where('id', $empty->news_id)->update(['description' => '']);   // a hero whose story was cleared
        $this->patchJson('/admin/nahau/heroes/'.$empty->id.'/toggle/active', ['value' => 1])->assertStatus(422);
        $this->newHero(['name' => 'Carousel Pick'])->assertOk();
        $this->get('/admin/nahau/carousel/create', $this->h)->assertSee('Carousel Pick (inactive)')->assertSee('Empty Hero');
        $hero = NahauHero::where('name', 'Carousel Pick')->firstOrFail();
        NahauSlide::query()->delete();
        NahauSlide::create(['slot' => 1, 'kind' => 'hero', 'hero_id' => $hero->id, 'days' => 5, 'starts_at' => now(), 'ends_at' => now()->addDays(5)]);
        $this->get('/')->assertDontSee('Carousel Pick');   // inactive hero: not on Home
        $this->post('/admin/nahau/heroes/'.$hero->id.'/activate', ['on' => 1])->assertRedirect();
        $this->get('/')->assertSee('Carousel Pick');
    }

    public function test_reader_hero_story_is_previewed_published_or_rejected_and_reader_sees_it(): void
    {
        Storage::fake();
        $reader = (new Maanuser)->forceFill(['first_name' => 'Zawadi', 'last_name' => 'K', 'email' => 'z'.uniqid().'@t.test', 'password' => Hash::make('Secret12345'), 'phone' => '0700000001']);
        $reader->save();
        $mk = fn ($t, $extra = []) => NahauSubmission::create($extra + ['reference' => 'NA-T-'.strtoupper(substr(md5($t), 0, 4)), 'name' => 'Zawadi K', 'email' => $reader->email, 'section' => 'african-heroes', 'language' => 'English', 'title' => $t, 'summary' => 'A short life story.', 'body' => "Born in Moshi.\n\nShe led the village.", 'original' => true]);
        $one = $mk('Hero One');
        $two = $mk('Hero Two');

        $admin = $this->admin();
        $this->get('/admin')->assertOk();
        $this->get('/admin/nahau/carousel')->assertOk()->assertSee('Hero story · Zawadi K');   // bell
        $this->get('/admin/nahau/submissions/'.$one->id.'/preview')->assertOk()->assertSee('Born in Moshi.')->assertSee('Kataa (Reject)')->assertSee('Chapisha kama Hero (Publish)');

        $this->post('/admin/nahau/submissions/'.$two->id.'/decide', ['action' => 'reject', 'note' => 'Needs sources'])->assertRedirect();
        $this->assertSame('declined', $two->fresh()->status);

        $this->post('/admin/nahau/submissions/'.$one->id.'/decide', ['action' => 'publish', 'note' => 'Lovely piece'])->assertRedirect();
        $one = $one->fresh();
        $this->assertSame('accepted', $one->status);
        $hero = NahauHero::findOrFail($one->hero_id);
        $this->assertTrue((bool) $hero->active);
        $this->assertEquals(1, News::find($hero->news_id)->status);
        $this->post('/admin/nahau/submissions/'.$one->id.'/decide', ['action' => 'publish'])->assertRedirect();   // second time is refused, no duplicate
        $this->assertEquals(1, NahauHero::where('name', 'Hero One')->count());

        auth()->logout();
        $this->actingAs($reader, 'maanuser');
        $this->get(route('account.mine'))->assertOk()->assertSee('Imekubaliwa')->assertSee('Haijakubaliwa')->assertSee('Needs sources')->assertSee('Angalia ulichotuma');
        $this->get(route('account.submission', $one->id))->assertOk()->assertSee('Hongera')->assertSee('Born in Moshi.')->assertSee('Tazama kwenye site')->assertSee('Lovely piece');
        $this->get(route('account.submission', $two->id))->assertOk()->assertSee('Samahani')->assertSee('Needs sources');

        $other = (new Maanuser)->forceFill(['first_name' => 'O', 'last_name' => 'T', 'email' => 'o'.uniqid().'@t.test', 'password' => Hash::make('Secret12345'), 'phone' => '0700000002']);
        $other->save();
        auth('maanuser')->logout();
        $this->actingAs($other, 'maanuser')->get(route('account.submission', $one->id))->assertNotFound();
    }

    public function test_hero_screens_have_no_swahili_in_english_mode(): void
    {
        $this->admin();
        $s = NahauSubmission::create(['reference' => 'NA-EN-1', 'name' => 'Q', 'email' => 'q@t.test', 'section' => 'african-heroes', 'language' => 'English', 'title' => 'EN Hero', 'body' => 'Text.', 'original' => true]);
        $bad = ['Ongeza', 'Ondoa', 'Chagua', 'Hifadhi', 'Funga', 'Hariri', 'Preview na', 'Kataa', 'Chapisha', 'Rudi ', 'Ujumbe', 'Faili', 'Andika', 'Muhtasari', 'Hero mpya', 'Washa', 'Zima'];
        $leaks = [];
        foreach (['/admin/nahau/heroes', '/admin/nahau/heroes/create', '/admin/nahau/submissions/'.$s->id.'/preview', '/admin/nahau/submissions/'.$s->id.'/edit'] as $u) {
            $html = $this->withCookie('nh_lang', 'en')->get($u, str_contains($u, '/create') || str_contains($u, '/edit') ? $this->h : [])->assertOk()->getContent();
            $text = strip_tags(preg_replace('/<(script|style)\b.*?<\/\1>/si', '', $html));
            foreach ($bad as $w) {
                if (str_contains($text, $w)) {
                    $leaks[] = $u.' => '.$w;
                }
            }
        }
        $this->assertSame([], $leaks);
    }
}
