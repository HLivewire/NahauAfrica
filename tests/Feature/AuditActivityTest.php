<?php

namespace Tests\Feature;

use App\Models\ActivityLog;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuditActivityTest extends TestCase
{
    use DatabaseTransactions;

    private function staff(string $slug): User
    {
        return $this->mk($slug);
    }

    private function mk(string $slug): User
    {
        $u = new User;
        $u->forceFill(['first_name' => ucfirst($slug), 'last_name' => 'Test', 'email' => $slug.'-'.uniqid().'@t.test', 'user_name' => $slug.uniqid(), 'password' => Hash::make('Passw0rd!x'), 'is_active' => 1, 'user_type' => '3'])->save();
        $u->roles()->attach(Role::where('slug', $slug)->firstOrFail()->id);

        return $u;
    }

    public function test_only_administrators_see_audit_activity(): void
    {
        $admin = $this->staff('admin');
        $editor = $this->mk('editor');
        $this->actingAs($editor)->get('/admin/audit')->assertNotFound();
        $this->actingAs($admin)->get('/admin/audit')->assertOk()->assertSee('Audit Activity');
    }

    public function test_changes_are_recorded_with_before_and_after_and_secrets_masked(): void
    {
        $admin = $this->staff('admin');
        $this->actingAs($admin);
        $h = \App\Models\NahauHero::create(['news_id' => \DB::table('news')->value('id'), 'name' => 'Audit Hero', 'show_in_spotlight' => 1, 'spotlight_order' => 0]);
        $this->patchJson('/admin/nahau/heroes/'.$h->id.'/toggle/show_in_spotlight', ['value' => 0])->assertOk();
        $log = ActivityLog::where('action', 'updated')->where('subject_type', 'Hero')->latest('id')->first();
        $this->assertNotNull($log);
        $this->assertEquals($admin->id, $log->user_id);
        $this->assertEquals(['1', '0'], array_map('strval', $log->changes['show_in_spotlight']));

        $admin->forceFill(['password' => Hash::make('NewPassw0rd!y')])->save();
        $pw = ActivityLog::where('action', 'password_change')->latest('id')->first();
        $this->assertNotNull($pw);
        $this->assertEquals(['•••', '•••'], $pw->changes['password']);
        $this->assertStringNotContainsString('Passw0rd', json_encode(ActivityLog::all()->toArray()));

        $h->delete();
        $this->assertTrue(ActivityLog::where('action', 'deleted')->where('subject_label', 'Audit Hero')->exists());
    }

    public function test_logins_and_failed_logins_are_recorded(): void
    {
        $admin = $this->staff('admin');
        $this->post('/signin', ['email' => $admin->email, 'password' => 'wrong-password']);
        $this->assertTrue(ActivityLog::where('action', 'login_failed')->where('description', 'like', '%'.$admin->email.'%')->exists());
        $this->post('/signin', ['email' => $admin->email, 'password' => 'Passw0rd!x']);
        $this->assertTrue(ActivityLog::where('action', 'login')->where('user_id', $admin->id)->exists());
    }

    public function test_filter_detail_and_csv_export(): void
    {
        $admin = $this->staff('admin');
        $this->actingAs($admin);
        ActivityLog::create(['user_id' => $admin->id, 'user_name' => 'Zed Tester', 'action' => 'created', 'description' => 'Ameongeza Story: Findable Title', 'subject_type' => 'Story', 'changes' => ['title' => [null, 'Findable Title']]]);
        ActivityLog::create(['user_id' => null, 'user_name' => 'Mgeni', 'action' => 'login_failed', 'description' => 'Kuingia kumeshindwa: x@y.z']);
        $this->get('/admin/audit?q=Findable')->assertOk()->assertSee('Findable Title')->assertDontSee('x@y.z');
        $this->get('/admin/audit?action=login_failed')->assertOk()->assertSee('x@y.z');
        $id = ActivityLog::where('user_name', 'Zed Tester')->value('id');
        $this->get('/admin/audit/'.$id, ['X-Requested-With' => 'XMLHttpRequest'])->assertOk()->assertSee('Mabadiliko')->assertSee('Findable Title');
        $csv = $this->get('/admin/audit/export?q=Findable')->assertOk();
        $this->assertStringContainsString('Findable Title', $csv->streamedContent());
        $this->assertStringNotContainsString('x@y.z', $csv->streamedContent());
    }
}
