<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AdminLoginTest extends TestCase
{
    use DatabaseTransactions;

    public function test_reset_command_lets_superadmin_and_admin_log_in(): void
    {
        $this->artisan('nahau:reset-admin', ['--password' => 'NewSecret#2026'])->assertSuccessful();

        foreach (User::where('user_type', '>=', '3')->get() as $u) {
            $this->post('/login', ['email' => $u->email, 'password' => 'NewSecret#2026'])
                ->assertRedirect(route('admin.dashboard'));
            $this->get(route('admin.dashboard'))->assertOk();
            auth()->logout();
        }
    }

    public function test_plain_text_password_assignment_is_hashed(): void
    {
        $u = User::where('user_type', '4')->first();
        $u->password = 'Plain#Pass2026';
        $u->save();
        $this->assertNotSame('Plain#Pass2026', $u->fresh()->password);
        $this->post('/login', ['email' => $u->email, 'password' => 'Plain#Pass2026'])->assertRedirect(route('admin.dashboard'));
    }

    public function test_wrong_password_is_rejected(): void
    {
        $u = User::where('user_type', '4')->first();
        $this->post('/login', ['email' => $u->email, 'password' => 'definitely-wrong'])->assertRedirect();
        $this->assertGuest();
    }
}
