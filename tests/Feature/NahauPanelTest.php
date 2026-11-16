<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class NahauPanelTest extends TestCase
{
    use DatabaseTransactions;

    private function userWith(string $slug): User
    {
        $u = (new User)->forceFill(['first_name' => ucfirst($slug), 'last_name' => 'T', 'email' => $slug.'-'.uniqid().'@t.test', 'user_name' => $slug.uniqid(), 'password' => 'Secret12345', 'user_type' => '2', 'is_active' => 1]);
        $u->save();
        $u->roles()->attach(Role::where('slug', $slug)->firstOrFail()->id);

        return $u;
    }

    public function test_menu_and_screens_follow_the_role(): void
    {
        $this->actingAs($this->userWith('translator'));
        $this->get(route('admin.dashboard'))->assertOk()->assertSee('Collapsed View', false)->assertDontSee('Users na Roles');
        $this->get('/admin/nahau/stories')->assertOk();
        $this->get('/admin/nahau/heroes')->assertForbidden();
        $this->get(route('admin.panel.users'))->assertNotFound();
    }

    public function test_section_editor_can_manage_authors_but_not_heroes(): void
    {
        $this->actingAs($this->userWith('section-editor'));
        $this->get('/admin/nahau/authors')->assertOk();
        $this->get('/admin/nahau/heroes')->assertForbidden();
    }

    public function test_modal_form_returns_partial_and_saves_as_json(): void
    {
        $this->actingAs($this->userWith('admin'));
        $h = ['X-Requested-With' => 'XMLHttpRequest'];
        $this->get('/admin/nahau/authors/create', $h)->assertOk()->assertSee('data-ajax', false)->assertDontSee('<html', false);
        $this->postJson('/admin/nahau/authors', ['name' => ''], $h)->assertStatus(422)->assertJsonValidationErrors('name');
        $this->postJson('/admin/nahau/authors', ['name' => 'Panel Test Author'], $h)->assertOk()->assertJson(['message' => 'Imehifadhiwa']);
        $this->assertDatabaseHas('nahau_authors', ['name' => 'Panel Test Author', 'home_order' => 0]);
    }

    public function test_administrator_invites_a_user_and_last_admin_is_protected(): void
    {
        $admin = $this->userWith('admin');
        $this->actingAs($admin);
        $r = $this->postJson(route('admin.panel.users.store'), ['first_name' => 'Neema', 'email' => 'neema@t.test', 'role' => 'translator'])->assertOk();
        $new = User::where('email', 'neema@t.test')->firstOrFail();
        $this->assertTrue($new->hasRole('translator'));
        $this->assertTrue((bool) $new->must_change_password);
        $this->assertStringContainsString('Nenosiri la muda', $r->json('text'));

        // remove every other administrator: the last one cannot be demoted, disabled or deleted
        foreach (User::whereHas('roles', fn ($q) => $q->whereIn('slug', ['super-admin', 'admin']))->where('id', '!=', $admin->id)->get() as $o) {
            $o->roles()->detach();
        }
        $this->putJson(route('admin.panel.users.update', $admin), ['role' => 'editor'])->assertStatus(422);
        $this->deleteJson(route('admin.panel.users.destroy', $admin))->assertStatus(422);
    }

    public function test_only_administrator_manages_users(): void
    {
        $this->actingAs($this->userWith('editor'));
        $this->get(route('admin.panel.users'))->assertNotFound();
        $this->postJson(route('admin.panel.users.store'), ['first_name' => 'X', 'email' => 'x@t.test', 'role' => 'admin'])->assertNotFound();
    }

    public function test_user_changes_own_password(): void
    {
        $u = $this->userWith('editor');
        $u->forceFill(['must_change_password' => true])->save();
        $this->actingAs($u);
        $this->postJson(route('admin.panel.password.save'), ['current_password' => 'wrong', 'password' => 'NewPassword123', 'password_confirmation' => 'NewPassword123'])->assertStatus(422);
        $this->postJson(route('admin.panel.password.save'), ['current_password' => 'Secret12345', 'password' => 'short1', 'password_confirmation' => 'short1'])->assertStatus(422);
        $this->postJson(route('admin.panel.password.save'), ['current_password' => 'Secret12345', 'password' => 'NewPassword123', 'password_confirmation' => 'NewPassword123'])->assertOk();
        $u->refresh();
        $this->assertTrue(Hash::check('NewPassword123', $u->password));
        $this->assertFalse((bool) $u->must_change_password);
    }

    public function test_each_invited_role_signs_in_and_reaches_its_own_pages(): void
    {
        $this->actingAs($this->userWith('admin'));
        $expect = [   // role => [pages that open, pages that are refused]
            'admin' => [['/admin/nahau/subscribers', '/admin/panel/users', '/admin/news'], []],
            'editor' => [['/admin/nahau/heroes', '/admin/news'], ['/admin/panel/users']],
            'section-editor' => [['/admin/nahau/authors', '/admin/news'], ['/admin/nahau/heroes', '/admin/panel/users']],
            'translator' => [['/admin/nahau/stories', '/admin/news'], ['/admin/nahau/authors', '/admin/panel/users']],
            'contributor' => [['/admin/news'], ['/admin/nahau/stories', '/admin/panel/users']],
        ];
        foreach ($expect as $slug => [$ok, $no]) {
            $this->postJson(route('admin.panel.users.store'), ['first_name' => 'R'.$slug, 'email' => $slug.'@role.test', 'role' => $slug])->assertOk();
            $u = User::where('email', $slug.'@role.test')->firstOrFail();
            $this->assertSame($slug === 'admin' ? 'A' : null, $slug === 'admin' ? \App\Nahau\Panel::letter($u) : null);
            $this->actingAs($u);
            $this->get(route('admin.dashboard'))->assertOk()->assertSee('Collapsed View', false);
            foreach ($ok as $url) {
                $this->get($url)->assertOk();
            }
            foreach ($no as $url) {
                $this->assertContains($this->get($url)->status(), [403, 404], "$slug must not open $url");
            }
            $this->actingAs($this->userWith('admin'));
        }
    }

    public function test_disabled_account_cannot_sign_in(): void
    {
        $u = $this->userWith('editor');
        $u->forceFill(['is_active' => 0])->save();
        $this->post('/login', ['email' => $u->email, 'password' => 'Secret12345'])->assertRedirect();
        $this->assertGuest();
    }
}
