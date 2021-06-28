<?php

namespace App\Jobs;

use App\Models\Configurations;
use App\Models\Records;
use Carbon\CarbonImmutable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
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
        /** @var Configurations $config */
        $config = Configurations::query()
            ->where('configuration_key', '=', "simplehome.housekeeping.active")
            ->first();

        $active = (bool)$config->getAttribute('configuration_value');
        if ($active) {
            $intervalConfig = Configurations::query()
                ->where('configuration_key', '=', "simplehome.housekeeping.interval")
                ->first();

            $interval = empty($intervalConfig) ? 432000 : $intervalConfig->getAttribute('configuration_value');

            $deleteTime = CarbonImmutable::now()->change('- ' . (int)round($interval, 0) . ' seconds');

            /** @var Records $records */
            Records::where('created_at', '<', $deleteTime)->delete();
        }


    }
}
