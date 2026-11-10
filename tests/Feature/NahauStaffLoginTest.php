<?php
namespace Tests\Feature;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
class NahauStaffLoginTest extends TestCase
{
    public function test_staff_sign_in_from_drawer_goes_to_dashboard_and_wrong_password_keeps_email(): void
    {
        $u = User::where('user_type','>=','3')->first();
        $this->assertNotNull($u);
        $old = $u->password;
        $u->forceFill(['password'=>Hash::make('Test@12345'),'is_active'=>1])->save();
        try {
            $this->post('/signin',['email'=>$u->email,'password'=>'wrong'])->assertRedirect()->assertSessionHasInput('email',$u->email);
            $this->post('/signin',['email'=>$u->email,'password'=>'Test@12345'])->assertRedirect(route('admin.dashboard'));
            $this->get(route('admin.dashboard'))->assertOk();
        } finally { $u->forceFill(['password'=>$old])->save(); }
    }

    public function test_login_url_opens_the_site_drawer_and_dashboard_uses_dark_design(): void
    {
        $this->get('/login')->assertRedirect('/')->assertSessionHas('nahau_panel', 'login');
        $u = User::where('user_type','>=','3')->first();
        $this->actingAs($u)->get(route('admin.dashboard'))->assertOk()->assertSee('wv-kpi', false)->assertSee('nahau-admin-dark.css', false);
    }
}
