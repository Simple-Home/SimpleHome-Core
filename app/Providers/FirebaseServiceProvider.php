<?php

namespace App\Providers;

use App\Channels\FirebaseChannel;
use Illuminate\Support\ServiceProvider;

class FirebaseServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Notification::extend('firebase', function ($app) {
            return new FirebaseChannel();
        });
    }
}
