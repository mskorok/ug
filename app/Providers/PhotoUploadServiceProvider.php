<?php

namespace App\Providers;

use App\Services\PhotoUploadService;
use Illuminate\Support\ServiceProvider;

/**
 * Class PhotoUploadServiceProvider
 * @package App\Providers
 */
class PhotoUploadServiceProvider extends ServiceProvider
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
        $this->app->bind('App\Contracts\PhotoUpload', function () {
            return new PhotoUploadService();
        });
        $this->app->bind('photoUpload', 'App\Services\PhotoUploadService');

    }
}
