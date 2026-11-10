<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class ResetAdminPassword extends Command
{
    protected $signature = 'nahau:reset-admin
        {email? : Email of the admin (default: every admin and super admin)}
        {--password= : New password (min 8 characters). If omitted, you are asked for it.}';

    protected $description = 'Safely reset the password of an admin / super admin so they can log in again';

    public function handle(): int
    {
        $password = $this->option('password') ?: $this->secret('New password (min 8 characters)');
        if (! is_string($password) || strlen($password) < 8) {
            $this->error('The password must be at least 8 characters.');

            return self::FAILURE;
        }

        $query = User::query()->where('user_type', '>=', '3');
        if ($email = $this->argument('email')) {
            $query = User::query()->where('email', $email);
        }
        $users = $query->get();
        if ($users->isEmpty()) {
            $this->error('No matching admin account found. Existing admins: ' . User::where('user_type', '>=', '3')->pluck('email')->implode(', '));

            return self::FAILURE;
        }

        foreach ($users as $user) {
            // Hash::make here, written straight to the column, so it is never stored in plain text or hashed twice.
            $user->forceFill(['password' => Hash::make($password), 'is_active' => 1])->save();
            $this->line("Reset: {$user->email} (user_type {$user->user_type})");
        }
        $this->info('Done. Log in at /login with the new password.');

        return self::SUCCESS;
    }
}
