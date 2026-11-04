<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class AdminTest extends TestCase
{
    private function userWithRole(string $slug): User
    {
        return User::whereHas('roles', fn ($q) => $q->where('slug', $slug))->firstOrFail();
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get('/admin')->assertRedirect(route('login'));
    }

    public function test_super_admin_can_open_every_admin_page(): void
    {
        $this->actingAs($this->userWithRole('super-admin'));

        $pages = [
            'admin.dashboard', 'admin.role', 'admin.user', 'admin.user.create', 'admin.settings.index',
            'admin.company.index', 'admin.theme.index', 'admin.seo.index', 'admin.ads.index', 'admin.social.index',
            'admin.header.index', 'admin.header.create', 'admin.footer.index', 'admin.footer.create',
            'admin.subscriber', 'admin.news.category', 'admin.news.subcategory', 'admin.news.speciality',
            'admin.news', 'admin.news.create', 'admin.photogallery', 'admin.videogallery', 'admin.videogallery.create',
            'admin.blog.category', 'admin.blog.subcategory', 'admin.blog', 'admin.blog.create',
            'admin.reporter', 'admin.reporter.create', 'admin.contact',
        ];
        foreach ($pages as $name) {
            $this->get(route($name))->assertOk();
        }
    }

    public function test_reporter_cannot_manage_users(): void
    {
        $this->actingAs($this->userWithRole('reporter'));
        $this->get(route('admin.user'))->assertNotFound();
        $this->get(route('admin.news'))->assertOk();
    }

    public function test_login_form_rejects_bad_credentials(): void
    {
        $this->post('/login', ['email' => 'nobody@example.com', 'password' => 'wrong'])->assertRedirect();
        $this->assertGuest();
    }
}
