<?php

namespace App\Providers;

use App\Services\FacebookService;
use Illuminate\Support\ServiceProvider;

/**
 * Class FacebookServiceProvider
 * @package App\Providers
 */
class FacebookServiceProvider extends ServiceProvider
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

        $this->app->bind('App\Contracts\Facebook', function () {
            return new FacebookService();
        });
        $this->app->bind('facebook', 'App\Contracts\Facebook');
    }
}
