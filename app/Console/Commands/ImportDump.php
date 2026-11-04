<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

/**
 * Loads database/nahauafrica.sql through PHP (no mysql command line needed), then runs the migrations
 * that adapt the old schema to this version.
 */
class ImportDump extends Command
{
    protected $signature = 'nahau:import-dump {--file=database/nahauafrica.sql : SQL dump to load} {--force : Do not ask for confirmation}';

    protected $description = 'WIPE the configured database, load the original SQL dump, then run migrations and admin:setup';

    public function handle(): int
    {
        $file = base_path($this->option('file'));
        if (! is_file($file)) {
            $this->error("Dump not found: {$file}");

            return self::FAILURE;
        }

        $name = DB::connection()->getDatabaseName();
        if (! $this->option('force') && ! $this->confirm("This ERASES every table in database '{$name}' and loads the dump. Continue?")) {
            return self::FAILURE;
        }

        $this->components->task('Wiping database', fn () => Artisan::call('db:wipe', ['--force' => true]) === 0);
        $this->components->task('Importing dump', function () use ($file) {
            DB::unprepared('SET FOREIGN_KEY_CHECKS=0');
            DB::unprepared(file_get_contents($file));
            DB::unprepared('SET FOREIGN_KEY_CHECKS=1');

            return true;
        });
        $this->components->task('Running migrations', fn () => Artisan::call('migrate', ['--force' => true]) === 0);
        Artisan::call('admin:setup');
        $this->line(Artisan::output());
        $this->info('Done. Log in at /login');

        return self::SUCCESS;
    }
}
