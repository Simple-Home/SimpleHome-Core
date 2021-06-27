<?php

namespace App\Console\Commands;

use App\Jobs\CleanRecords;
use App\Models\Configurations;
use App\Models\Records;
use Carbon\CarbonImmutable;
use Illuminate\Console\Command;

class ClearRecordsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'simplehome:clear:records';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove old records';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        CleanRecords::dispatch();
        return 0;
    }
}
