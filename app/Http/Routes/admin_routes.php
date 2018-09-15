<?php

/**
 * Admin panel routes
 */
Route::group(
    ['prefix' => 'admin', 'middleware' => ['web', 'admin'], 'namespace' => 'Admin'],
    function () {

        // Auth
        Route::get('login', 'Auth\AdminAuthController@showLoginForm');
        Route::post('login', 'Auth\AdminAuthController@login');
        Route::get('logout', 'Auth\AdminAuthController@logout');

        // Index
        Route::get('/', 'DashboardController@index');

        // Users
        Route::get('/users', 'UsersController@showUsers');
        Route::get('/users/add', 'UsersController@showAddUser');
        Route::post('/users/add', 'UsersController@postAddUser');
        Route::get('/users/{user}', 'UsersController@showEditUser');
        Route::post('/users/{user}', 'UsersController@postEditUser');
        Route::get('/users/{user}/delete', 'UsersController@deleteUser');

        Route::group(
            ['prefix' => 'countries', 'namespace' => 'Geo'],
            function () {
                Route::get('/', 'CountryController@showCountries');
                Route::get('/add', 'CountryController@showAddCountry');
                Route::post('/add', 'CountryController@postAddCountry');
                Route::get('/{country}', 'CountryController@showEditCountry');
                Route::post('/{country}', 'CountryController@postEditCountry');
                Route::get('/{country}/delete', 'CountryController@deleteCountry');
            }
        );
        Route::group(
            ['prefix' => 'adventures'],
            function () {
                //list
                Route::get(
                    '/',
                    ['as' => 'adventure_list', 'uses' => 'ActivitiesController@showAdventures']
                );
                //show
                Route::get('/show/{model}', ['as' => 'adventure_show', 'uses' => 'ActivitiesController@show']);
                //create
                Route::get(
                    '/create',
                    ['as' => 'adventure_create', 'uses' => 'ActivitiesController@showAddAdventure']
                );
                Route::post('/create', 'ActivitiesController@postAddAdventure');
                //edit
                Route::get(
                    '/edit/{model}',
                    ['as' => 'adventure_edit', 'uses' => 'ActivitiesController@showEditAdventure']
                );
                Route::post('/edit/{model}', 'ActivitiesController@postEditAdventure');
                //delete
                Route::get(
                    '/{model}/delete',
                    ['as' => 'adventure_delete', 'uses' => 'ActivitiesController@deleteAdventure']
                );
            }
        );


        Route::group(
            ['prefix' => 'reviews'],
            function () {
                //list
                Route::get(
                    '/',
                    ['as' => 'review_list', 'uses' => 'ReviewsController@showReviews']
                );
                //show
                Route::get('/show/{model}', ['as' => 'review_show', 'uses' => 'ReviewsController@show']);
                //create
                Route::get(
                    '/create',
                    ['as' => 'review_create', 'uses' => 'ReviewsController@showAddReview']
                );
                Route::post('/create', 'ReviewsController@postAddReview');
                //edit
                Route::get(
                    '/edit/{model}',
                    ['as' => 'review_edit', 'uses' => 'ReviewsController@showEditReview']
                );
                Route::post('/edit/{model}', 'ReviewsController@postEditReview');
                //delete
                Route::get(
                    '/{model}/delete',
                    ['as' => 'review_delete', 'uses' => 'ReviewsController@deleteReview']
                );
            }
        );
        Route::group(
            ['prefix' => 'interests'],
            function () {
                Route::get('/', 'InterestController@index');
            }
        );
    }
);


// model generator todo delete
Route::get('/generate/models', '\\Jimbolino\\Laravel\\ModelBuilder\\ModelGenerator5@start');
