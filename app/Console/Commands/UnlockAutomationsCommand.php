<?php

namespace App\Console\Commands;

use App\Models\Automations;
use Illuminate\Console\Command;

class UnlockAutomationsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'simplehome:automations:unlock:all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Unlock all Automation locked either by bug or mistake';

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
        $allEnabledAutomations = Automations::where("is_locked", true)->get();
        foreach ($allEnabledAutomations as $key => $automation) {
            $automation->is_locked = false;
            $automation->save();
            $this->info('Automation: "' . $automation->name . '" unlocked');
        }
        return Command::SUCCESS;
    }
}
