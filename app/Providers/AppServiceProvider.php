<?php

namespace App\Providers;

use App\Core\Mail;
use App\Core\MysqlConnection;
use Illuminate\Support\ServiceProvider;

/**
 * Class AppServiceProvider
 * @package App\Providers
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /*DB::listen(function($query) {
            Log::error($query->sql);
            Log::error($query->bindings);
            Log::error($query->time);
        });*/
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('db.connection.mysql', MysqlConnection::class);
    }
}
