<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Makes sure the super admin and admin accounts exist and can log in.
 * Safe to run repeatedly (it creates the roles/users when missing and resets the passwords).
 */
class AdminSetup extends Command
{
    protected $signature = 'admin:setup
        {--super-email=superadmin21@gmail.com : Super admin e-mail}
        {--super-password=superadmin21 : Super admin password}
        {--admin-email=admin21@gmail.com : Admin e-mail}
        {--admin-password=admin21 : Admin password}';

    protected $description = 'Create or reset the super admin and admin logins';

    public function handle(): int
    {
        $roles = [
            'super-admin' => 'Super Admin', 'admin' => 'Admin', 'editor' => 'Editor',
            'accountent' => 'Accountent', 'reporter' => 'Reporter',
        ];
        foreach ($roles as $slug => $name) {
            if (! DB::table('roles')->where('slug', $slug)->exists()) {
                DB::table('roles')->insert(['name' => $name, 'slug' => $slug, 'created_at' => now(), 'updated_at' => now()]);
            }
        }

        $this->ensure('Super', 'Admin', 'super-admin', $this->option('super-email'), $this->option('super-password'), '1');
        $this->ensure('Admin', 'User', 'admin', $this->option('admin-email'), $this->option('admin-password'), '2');

        $this->newLine();
        $this->table(['Role', 'E-mail', 'Password'], [
            ['Super admin', $this->option('super-email'), $this->option('super-password')],
            ['Admin', $this->option('admin-email'), $this->option('admin-password')],
        ]);
        $this->info('Log in at /login');

        return self::SUCCESS;
    }

    private function ensure(string $first, string $last, string $slug, string $email, string $password, string $type): void
    {
        $user = User::where('email', $email)->first() ?? new User();
        $user->first_name = $user->first_name ?: $first;
        $user->last_name = $user->last_name ?: $last;
        $user->email = $email;
        $user->user_name = $user->user_name ?: strtok($email, '@');
        $user->user_type = $user->user_type ?: $type;
        $user->is_active = 1;
        $user->is_approve = 1;
        $user->password = Hash::make($password);
        $user->save();

        $roleId = DB::table('roles')->where('slug', $slug)->value('id');
        DB::table('users_roles')->where('user_id', $user->id)->delete();
        DB::table('users_roles')->insert(['user_id' => $user->id, 'role_id' => $roleId]);
    }
}
