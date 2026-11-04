<?php

namespace Tests\Feature;

use App\Models\News;
use App\Models\Maanuser;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ApiTest extends TestCase
{
    use DatabaseTransactions;

    public function test_public_api_endpoints_respond(): void
    {
        $urls = [
            'news_categories', 'latest_news', 'latest_news_national', 'latest_news_world', 'latest_news_politics',
            'latest_news_lifestyle', 'latest_news_entertainment', 'latest_news_sports', 'latest_news_technology',
            'latest_news_business', 'popular_news', 'popular_news_all', 'popular_news_world', 'popular_news_lifestyle',
            'popular_news_entertainment', 'popular_news_sports', 'popular_news_technology', 'latest_photo_galleries',
            'video_galleries', 'breaking_news',
        ];
        foreach ($urls as $url) {
            $this->getJson('/api/'.$url)->assertOk()->assertJson(['success' => true]);
        }
    }

    public function test_news_details_and_comments(): void
    {
        $news = News::where('status', 1)->first();
        $this->getJson('/api/news_details/'.$news->id)->assertOk();
        $this->getJson('/api/news_comments/'.$news->id)->assertOk();
        $this->getJson('/api/category_news/1')->assertOk();
    }

    public function test_unknown_api_route_returns_json_404(): void
    {
        $this->getJson('/api/does-not-exist')->assertNotFound()->assertJson(['status' => false]);
    }

    public function test_search_validates_input_and_works(): void
    {
        $this->postJson('/api/search_news', [])->assertStatus(422)->assertJson(['status' => false]);
        $this->postJson('/api/search_news', ['search' => 'a'])->assertOk();
    }

    public function test_protected_routes_need_a_token(): void
    {
        $this->getJson('/api/bookmarks')->assertUnauthorized();
    }

    public function test_user_can_login_and_use_a_bearer_token(): void
    {
        $user = Maanuser::create([
            'first_name' => 'Api', 'last_name' => 'Tester', 'phone' => '255700000001',
            'email' => 'api-tester@example.com', 'password' => Hash::make('secret123'),
        ]);

        $login = $this->postJson('/api/user_login', ['email' => $user->email, 'password' => 'secret123'])
            ->assertOk()
            ->assertJson(['status' => 'Success', 'token_type' => 'Bearer']);

        $token = $login->json('access_token');
        $headers = ['Authorization' => 'Bearer '.$token];

        $this->getJson('/api/bookmarks', $headers)->assertOk();
        $this->postJson('/api/update_profile', [
            'first_name' => 'Api', 'last_name' => 'Renamed', 'email' => $user->email,
        ], $headers)->assertOk()->assertJson(['success' => true]);
        $this->assertDatabaseHas('maanusers', ['id' => $user->id, 'last_name' => 'Renamed']);
    }

    public function test_wrong_password_is_rejected(): void
    {
        $user = Maanuser::create([
            'first_name' => 'Api', 'last_name' => 'Tester', 'phone' => '255700000002',
            'email' => 'api-tester2@example.com', 'password' => Hash::make('secret123'),
        ]);
        $this->postJson('/api/user_login', ['email' => $user->email, 'password' => 'nope-nope'])->assertStatus(422);
    }
}
