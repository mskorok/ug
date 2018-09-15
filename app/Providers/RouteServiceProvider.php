<?php

namespace App\Providers;

use App\Models\Adventures\Adventure;
use App\Models\Reviews\Review;
use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\App;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function boot(Router $router)
    {
        parent::boot($router);

        $router->bind('review', function ($slug_id) {
            $pos = strrpos($slug_id, '-');
            if ($pos !== false) {
                $id = substr($slug_id, $pos+1);
                $slug = substr($slug_id, 0, $pos);
                $model = Review::findOrFail($id);
                if ($model->slug === $slug) {
                    return $model;
                }
                return App::abort(404);
            } else {
                return App::abort(404);
            }
        });

        $router->bind('adventure', function ($slug_id) {
            $pos = strrpos($slug_id, '-');
            if ($pos !== false) {
                $id = substr($slug_id, $pos+1);
                $slug = substr($slug_id, 0, $pos);
                $model = Adventure::findOrFail($id);
                if ($model->slug === $slug) {
                    return $model;
                }
                return App::abort(404);
            } else {
                return App::abort(404);
            }
        });
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function map(Router $router)
    {
        $router->group(['prefix' => App::getLocalePrefix(), 'namespace' => $this->namespace], function ($router) {
            require app_path('Http/Routes/app_routes.php');
            require app_path('Http/Routes/api_routes.php');
            require app_path('Http/Routes/admin_routes.php');
            if (env('APP_ENV') === 'local' || env('APP_ENV') === 'dev') {
                require app_path('Http/Routes/dev_routes.php');
            }
        });
    }
}
