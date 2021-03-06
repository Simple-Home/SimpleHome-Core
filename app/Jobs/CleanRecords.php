<?php

namespace App\Jobs;

use App\Helpers\SettingManager;
use App\Models\Devices;
use App\Models\Records;
use Carbon\CarbonImmutable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

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

            // delete entries based on properties history setting
            $sql = "
                delete r
                from records r
                inner join properties p on r.property_id = p.id
                where r.created_at < (CURDATE() - INTERVAL p.history DAY) and p.history > 0;
                ";
            DB::statement($sql);

            // delete entries if properties history is 0 use global intervall
            $intervalConfig = SettingManager::get('interval', 'housekeeping');
            $interval = (int)empty($intervalConfig) ? 432000 : $intervalConfig->value;
            $sql = " 
                delete r
                from records r
                inner join properties p on r.property_id = p.id
                where r.created_at < (CURDATE() - INTERVAL $interval SECOND ) and p.history = 0;
                ";

            DB::statement($sql);
        }
    }
}
