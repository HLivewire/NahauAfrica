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
        return Stories::inSection('fiction')->whereNotNull('m.price')->first();
    }

    public function test_book_page_has_preview_read_and_cart_and_no_text_size_buttons(): void
    {
        $b = $this->book();
        $this->assertNotNull($b);
        $this->get(Stories::url($b))->assertOk()
            ->assertSee('nx-pages', false)->assertSee('Page 1')
            ->assertSee(route('n.en.read', $b->slug), false)
            ->assertSee('data-nx-cart', false)
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

    public function test_cart_add_remove_and_page(): void
    {
        $b = $this->book();
        $this->postJson(route('nahau.cart.add', $b->id))->assertOk()->assertJson(['count' => 1]);
        $this->postJson(route('nahau.cart.add', $b->id))->assertOk()->assertJson(['count' => 1]);
        $this->get(route('nahau.cart'))->assertOk()->assertSee($b->title)->assertSee('TZS 5,000');
        $this->postJson(route('nahau.cart.remove', $b->id))->assertOk()->assertJson(['count' => 0]);
        $this->get(route('nahau.cart'))->assertOk()->assertSee('Your cart is empty');
        $this->postJson(route('nahau.cart.add', 99999999))->assertNotFound();
    }
}
