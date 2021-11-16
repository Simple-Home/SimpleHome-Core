<?php

namespace App\Providers;

use App\Listeners\InstallFinishedListener;
use Illuminate\Support\ServiceProvider;
use RachidLaasri\LaravelInstaller\Controllers\FinalController;
use RachidLaasri\LaravelInstaller\Events\LaravelInstallerFinished;
use RachidLaasri\LaravelInstaller\Helpers\EnvironmentManager;
use Illuminate\Support\Facades\Schema;

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
    }
}
