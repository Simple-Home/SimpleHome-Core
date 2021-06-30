<?php

namespace App\Console\Commands;

use App\Jobs\CleanRecords;
use Carbon\CarbonImmutable;
use Illuminate\Console\Command;

class RunIntegrationsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'simplehome:integrations:all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run the jobs for the installed integrations';

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
        // loop though and add the integraions jobs here
        $integrations = \Module::all();
        foreach ($integrations as $name => $integration) {
            $classString = 'Modules\\'.$name.'\\Jobs\\'.$name.'Job';

            if (class_exists($classString)){
                $class = new $classString();
                $class->dispatch(); // Queue the job
            }
        }

        return 0;
    }
}
