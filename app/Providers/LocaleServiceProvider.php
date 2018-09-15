<?php

namespace App\Providers;

use App\Core\UrlGenerator;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;

class LocaleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // detect user language and set app locale
        if (in_array($s1 = Request::segment(1), config('app.additional_locales'))) {
            // 1. set app locale if first URL segment is in additional locales
            App::setLocale($s1);
            Carbon::setLocale($s1);
        } /*else if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            // 3. detect lang from user agent
            $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
            if (in_array($lang, config('app.additional_locales'))) {
                App::setLocale($lang);
            }
        }*/
        // 4. else Laravel automatically will use fallback_locale
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('url', function ($app) {
            return new UrlGenerator($app['router']->getRoutes(), $app['request']);
        });
    }
}
