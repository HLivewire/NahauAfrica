<?php

namespace Tests\Feature;

use App\Nahau\Stories;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class NahauBookTest extends TestCase
{
    use DatabaseTransactions;

    private function book()
    {
        if (! Stories::inSection('fiction')->whereNotNull('m.price')->exists() && ($f = Stories::inSection('fiction')->first())) {
            \DB::table('nahau_story_meta')->where('news_id', $f->id)->update(['price' => 5000]);   // rolled back with the test
        }

        return Stories::inSection('fiction')->whereNotNull('m.price')->first();
    }

    public function test_book_page_has_preview_read_and_read_later_and_no_text_size_buttons(): void
    {
        $b = $this->book();
        $this->assertNotNull($b);
        $this->get(Stories::url($b))->assertOk()
            ->assertSee('nx-pages', false)->assertSee('Page 1')
            ->assertSee(route('n.en.read', $b->slug), false)
            ->assertSee('data-nx-later', false)
            ->assertDontSee('data-nx-size', false);
        $this->get('/sw'.parse_url(Stories::url($b, 'sw'), PHP_URL_PATH) === '' ? '/' : parse_url(Stories::url($b, 'sw'), PHP_URL_PATH))->assertOk();
    }

    public function test_reader_page_renders_with_settings_and_themes(): void
    {
        $b = $this->book();
        $this->get(route('n.en.read', $b->slug))->assertOk()
            ->assertSee('data-rd-theme="moon"', false)->assertSee('data-rd-theme="stars"', false)->assertSee('data-rd-theme="cliff"', false)
            ->assertSee('rd-drawer', false)->assertSee($b->title);
        $this->get(route('n.sw.read', $b->slug))->assertOk();
        $this->get('/read/does-not-exist')->assertNotFound();
    }

    public function test_cart_is_gone_and_read_later_needs_a_reader_login(): void
    {
        $b = $this->book();
        $this->get('/cart')->assertNotFound();
        $this->postJson(route('nahau.later', $b->id))->assertStatus(401)->assertJson(['login' => true]);
    }
}
