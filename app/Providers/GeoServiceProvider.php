<?php

namespace App\Providers;

use App\Services\GoogleGeoService;
use Illuminate\Support\ServiceProvider;

/**
 * Class GeoServiceProvider
 * @package App\Providers
 */
class GeoServiceProvider extends ServiceProvider
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

        $this->app->bind('App\Contracts\Geo', function () {
            return new GoogleGeoService();
        });
    }
}
