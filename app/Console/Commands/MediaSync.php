<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MediaSync extends Command
{
    protected $signature = 'media:sync {--from= : Folder that holds the existing "uploads" directory (default: public)}';

    protected $description = 'Copy existing files from public/uploads to the configured media disk (use once when moving to S3 / Laravel Cloud storage)';

    public function handle(): int
    {
        $diskName = config('filesystems.media_disk', 'media');
        if ($diskName === 'media') {
            $this->info('MEDIA_DISK is the local "media" disk - files are already in public/uploads. Nothing to do.');

            return self::SUCCESS;
        }

        $base = rtrim($this->option('from') ?: public_path(), '/');
        $source = $base.'/uploads';
        if (! is_dir($source)) {
            $this->error("Folder not found: {$source}");

            return self::FAILURE;
        }

        $count = 0;
        foreach (File::allFiles($source) as $file) {
            $key = 'uploads/'.str_replace('\\', '/', $file->getRelativePathname());
            $stream = fopen($file->getRealPath(), 'r');
            media_disk()->put($key, $stream, 'public');
            if (is_resource($stream)) {
                fclose($stream);
            }
            $count++;
            $this->line("  {$key}");
        }

        $this->info("Copied {$count} file(s) to disk [{$diskName}].");

        return self::SUCCESS;
    }
}
