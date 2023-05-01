<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

final class S3cacheClearCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 's3cache:clear {--days=0 : The number of days to keep files in the cache}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear the S3 cache of files older than the specified number of days';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $days = $this->option('days');

        foreach (Storage::disk('s3cache')->allFiles() as $path) {
            if ($path === '.gitignore') {
                continue;
            }

            $lastModified = Storage::disk('s3cache')->lastModified($path);
            $fileAge = Carbon::createFromTimestamp($lastModified)->diffInDays();
            if ($fileAge >= $days) {
                Storage::disk('s3cache')->delete($path);
            }
        }

        $this->components->info("Files older than [$days days] deleted successfully.");
    }
}
