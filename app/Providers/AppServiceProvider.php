<?php

namespace App\Providers;

use App\Listeners\InstallFinishedListener;
use Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use RachidLaasri\LaravelInstaller\Controllers\FinalController;
use RachidLaasri\LaravelInstaller\Events\LaravelInstallerFinished;
use RachidLaasri\LaravelInstaller\Helpers\EnvironmentManager;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(EnvironmentManager::class, \App\Helpers\EnvironmentManager::class);
        $this->app->bind(FinalController::class, \App\Http\Controllers\FinalController::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \URL::forceScheme('https');
        Schema::defaultStringLength(191);
        Blade::directive('progressbar', function ($data) {
            eval("\$params = [$data];");
            list($steps_position, $steps_max) = $params;



            $progressBarHtml = "<div class=\"position-relative m-4\">";

            $progressBarHtml .= "<div class=\"progress\" style=\"height: 3px;\">
                    <div 
                        class=\"progress-bar\" 
                        role=\"progressbar\" 
                        style=\"width: " . (int) ($steps_position / ($steps_max / 100))  . "%;\" 
                        aria-valuenow=\"" . (int) ($steps_position / ($steps_max / 100))  . "\" 
                        aria-valuemin=\"0\" 
                        aria-valuemax=\"100\"
                    >
                    </div>
                </div>";

            for ($i = 0; $i <= $steps_max; $i++) {
                $progressBarHtml .= "<button type=\"button\"
                class=\"position-absolute top-0 start-" . (int) ($i / ($steps_max / 100))  . " translate-middle btn btn-sm btn-" . ($i < $steps_position ? "primary" : "secondary") . " rounded-pill\"
                style=\"width: 2rem; height:2rem;\">";

                if ($i == 0) {
                    $progressBarHtml .= "<i class=\"fas fa-play\"></i>";
                } elseif ($i == $steps_max) {
                    $progressBarHtml .= "<i class=\"fas fa-check\"></i>";
                } else {
                    $progressBarHtml .= $i;
                }

                $progressBarHtml .= "</button>";
            }

            $progressBarHtml .= "</div>";
            return strtolower($progressBarHtml);
        });
    }
}
