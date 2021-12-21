<?php

namespace App\Console\Commands;

use App\Jobs\CleanLogs;
use Illuminate\Console\Command;

class ClearLogsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'simplehome:clear:logs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove old Log Files';

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
        CleanLogs::dispatch();
        return 0;
    }
}
