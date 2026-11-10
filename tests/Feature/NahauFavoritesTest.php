<?php

namespace Tests\Feature;

use App\Models\Maanuser;
use App\Nahau\Stories;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class NahauFavoritesTest extends TestCase
{
    use DatabaseTransactions;

    private function storyId(): int
    {
        return (int) Stories::inSection('fiction')->value('news.id');
    }

    public function test_guest_cannot_favourite(): void
    {
        $id = $this->storyId();
        $this->assertGreaterThan(0, $id);
        $this->postJson(route('nahau.favorite', $id))->assertStatus(401)->assertJson(['login' => true]);
        $this->get(route('nahau.favorites'))->assertRedirect();
    }

    public function test_reader_can_toggle_favourite_and_see_it(): void
    {
        $id = $this->storyId();
        $u = Maanuser::first() ?? Maanuser::create(['first_name' => 'T', 'last_name' => 'R', 'email' => 'fav'.uniqid().'@example.com', 'phone' => '0700000000', 'password' => bcrypt('secret123')]);
        $this->actingAs($u, 'maanuser');
        $this->postJson(route('nahau.favorite', $id))->assertOk()->assertJson(['favorite' => true]);
        $this->get('/fiction')->assertOk()->assertSee('nx-heart is-on', false);
        $this->get(route('nahau.favorites'))->assertOk();
        $this->postJson(route('nahau.favorite', $id))->assertOk()->assertJson(['favorite' => false]);
    }
}
