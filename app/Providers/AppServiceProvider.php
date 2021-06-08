<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use RachidLaasri\LaravelInstaller\Controllers\FinalController;
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
        //
    }
}
