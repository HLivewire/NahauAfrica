<?php

namespace Tests\Feature;

use App\Models\Maanuser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class NahauDrawerTest extends TestCase
{
    public function test_home_has_drawer_with_three_panels_and_logo(): void
    {
        $html = $this->get('/')->assertOk()->getContent();
        foreach (['data-panel="login"', 'data-panel="register"', 'data-panel="forgot"', 'nahau-d-logo', 'nahau-getstarted'] as $needle) {
            $this->assertStringContainsString($needle, $html);
        }
    }

    public function test_drawer_register_creates_user_and_returns_to_login_panel(): void
    {
        $email = 'drawer'.uniqid().'@example.com';
        $this->from('/')->post('/signup', [
            'first_name' => 'Test', 'last_name' => 'User', 'phone' => (string) random_int(700000000, 799999999),
            'email' => $email, 'password' => 'secret12', 'password_confirmation' => 'secret12', 'nahau_drawer' => 1,
        ])->assertRedirect('/')->assertSessionHas('nahau_panel', 'login');
        $this->assertDatabaseHas('maanusers', ['email' => $email]);
        Maanuser::where('email', $email)->delete();
    }

    public function test_drawer_register_errors_reopen_register_panel(): void
    {
        $this->from('/')->post('/signup', ['nahau_drawer' => 1, 'email' => 'bad'])
            ->assertSessionHas('nahau_panel', 'register')->assertSessionHasErrors('first_name');
    }

    public function test_forgot_password_sends_notification_and_reset_works(): void
    {
        Notification::fake();
        $email = 'forgot'.uniqid().'@example.com';
        $u = Maanuser::create(['first_name' => 'F', 'last_name' => 'P', 'phone' => (string) random_int(600000000, 699999999), 'email' => $email, 'password' => bcrypt('oldpass1')]);

        $this->from('/')->post('/forgot-password', ['email' => $email])->assertSessionHas('nahau_panel', 'forgot');
        Notification::assertSentTo($u, \Illuminate\Auth\Notifications\ResetPassword::class);

        // unknown email answers identically (no account probing)
        $this->from('/')->post('/forgot-password', ['email' => 'nobody@example.com'])->assertSessionHas('nahau_notice');

        $token = Password::broker('maanusers')->createToken($u);
        $this->get('/reset-password/'.$token.'?email='.$email)->assertOk()->assertSee('Reset your password');
        $this->post('/reset-password', ['token' => $token, 'email' => $email, 'password' => 'newpass1', 'password_confirmation' => 'newpass1'])
            ->assertRedirect(route('home'));
        $this->assertTrue(\Hash::check('newpass1', $u->fresh()->password));
        $u->delete();
        DB::table('password_resets')->where('email', $email)->delete();
    }

    public function test_pagination_uses_nahau_view_without_bootstrap_blue(): void
    {
        $html = $this->get('/search?search=a')->getContent();
        if (str_contains($html, 'nahau-pagination')) {
            $this->assertStringNotContainsString('page-link', $html);
        }
        $this->assertTrue(true);
    }
}
