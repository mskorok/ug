<?php

namespace App\Providers;

use App\Services\GoogleService;
use Illuminate\Support\ServiceProvider;

/**
 * Class GoogleServiceProvider
 * @package App\Providers
 */
class GoogleServiceProvider extends ServiceProvider
{


    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->bind('App\Contracts\Google', function () {
            return new GoogleService();
        });
        $this->app->bind('google', 'App\Contracts\Google');
    }
}
