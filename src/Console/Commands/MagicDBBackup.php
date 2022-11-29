<?php

namespace Flamento\MagicDB\Console\Commands;


use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class MagicDBBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'magicdb:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a backup of the database and store it to the storage/app/magicdb/backup folder';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $filename = "backup-" . now()->format('Y-m-d-H-i-s') . ".gz";
        $dir = storage_path('app/magicdb/backup');
        $path = $dir . '/' . $filename;

        //check if backup dir exists
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }

        $command = "mysqldump --user=" . config('magicdb.DB_USERNAME') . " --password=" . config('magicdb.DB_PASSWORD') . " --host=" . config('magicdb.DB_HOST') . " " . config('magicdb.DB_DATABASE') . "  | gzip > " . $path;

        $returnVar = NULL;
        $output  = NULL;
        try {
            $result = exec($command, $output, $returnVar);
            if ($returnVar == 0) {
                Log::info('MagicDB Backup created: ' . $path);
                return Command::SUCCESS;
            } else {
                Log::error('MagicDB Backup Failed', ['result' => $result, 'output' => $output, 'returnVar' => $returnVar]);
                return Command::FAILURE;
            }
        } catch (Exception $e) {
            Log::error('MagicDB Backup Failed', ['error' => $e->getMessage()]);
            return Command::FAILURE;
        }
    }
}
