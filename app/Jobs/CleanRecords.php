<?php

namespace App\Jobs;

use App\Helpers\SettingManager;
use App\Models\Records;
use Carbon\CarbonImmutable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CleanRecords implements ShouldQueue
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

        $active = SettingManager::get('active', 'housekeeping');
        if ($active->value) {
            $intervalConfig = SettingManager::get('interval', 'housekeeping');

            $interval = empty($intervalConfig) ? 432000 : $intervalConfig->value;

            $deleteTime = CarbonImmutable::now()->change('- ' . (int)round($interval, 0) . ' seconds');

            /** @var Records $records */
            Records::where('created_at', '<', $deleteTime)->delete();
        }


    }
}
