<?php

namespace App\Console\Commands;

use App\Models\ActivityLog;
use Illuminate\Console\Command;

class PruneAuditLog extends Command
{
    protected $signature = 'nahau:audit-prune {--days=365 : Keep this many days of Audit Activity}';

    protected $description = 'Delete Audit Activity rows older than N days (default 365) so the table stays small and fast';

    public function handle(): int
    {
        $n = ActivityLog::where('created_at', '<', now()->subDays(max(30, (int) $this->option('days'))))->delete();
        $this->info("Removed {$n} old audit rows.");

        return self::SUCCESS;
    }
}
