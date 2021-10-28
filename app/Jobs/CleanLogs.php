<?php

namespace App\Jobs;

use App\Helpers\SettingManager;
use Carbon\CarbonImmutable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class CleanLogs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $records = null;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
       $active = SettingManager::get('logs_cleaning_active', 'housekeeping');
        if ($active->value) {
            $intervalInDays = SettingManager::get('logs_cleaning_interval', 'housekeeping');

            $dir = storage_path('logs/');
            $logFiles = scandir($dir);
            foreach ($logFiles as $key => $file) {
                if (in_array($file, array(".", "..", ".gitkeep", ".gitignore"))) {
                    continue;
                }
                $fileNameFull = storage_path('logs/' . $file);
                if (file_exists($fileNameFull)) {
                    $oldInDays = Carbon::createFromTimestamp(filemtime($fileNameFull))->diffInDays();
                    if ($oldInDays >= $intervalInDays->value){
                        dd($fileNameFull);
                         unlink($fileNameFull);
                    }
                }
            }
        }
        Cache::lock('job-cleningOldLogs-lock')->forceRelease();
    }
}
