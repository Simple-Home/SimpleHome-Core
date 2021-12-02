<?php

namespace App\Console\Commands;

use App\Models\Automations;
use Illuminate\Console\Command;

class RunAutomationsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'simplehome:automations:all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run all automations';

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
        $allEnabledAutomations = Automations::where('is_enabled', true)->where('conditions', "!=", "")->get();
        foreach ($allEnabledAutomations as $key => $automation) {
            $result = $automation->run();
            if ($result) {
                $this->info('Automation: "' . $automation->name . '" run Correctly');
            } else {
                $this->error('Automation: "' . $automation->name . '" run with errors!!!');
            }
        }
        return Command::SUCCESS;
    }
}
