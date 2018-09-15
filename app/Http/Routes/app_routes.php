<?php

/**
 * Main client-side routes (translatable)
 */
use Illuminate\Support\Facades\Input;

Route::group(['middleware' => ['web']], function () {

    // index
    Route::get('/', ['uses' => 'HomeController@index', 'as' => 'home']);

    // auth
    Route::auth(); // TODO: remove this

    Route::group(['namespace' => 'Auth', 'middleware' => 'guest'], function () {

        Route::get('register', 'AuthController@showRegister');
        Route::get('confirm-email/{code}', 'AuthController@activate');

        Route::get('registration-completed', function () {
            return view('app.auth.registration_completed');
        });

        // Social login
        Route::group(['prefix' => 'login','as' => 'login.'], function () {
            Route::get('/facebook', ['uses' => 'AuthController@facebookCallback', 'as' => 'facebook']);
        });
    });

    // Web hook listeners, triggered by other servers
    Route::group(['prefix' => 'hook'], function () {
        Route::get('/facebook/deauthorize', 'Auth\AuthController@retrieveFacebookAuth');
    });

    // profile
    Route::group(['prefix' => 'users/{user}', ], function () {
        Route::get('/', 'PublicProfileController@showProfile');
        Route::get('/about', 'PublicProfileController@showProfile');
        Route::get('/activities', 'PublicProfileController@showActivities');
        Route::get('/reviews', 'PublicProfileController@showReviews');
        Route::get('/friends', 'PublicProfileController@showFriends');
    });

    // activities

    Route::group(['prefix' => 'activities'], function () {
        Route::any('/', ['as' =>'activities_list', 'uses' =>'ActivitiesController@activities']);
        Route::get(
            '/create',
            ['as' => 'activity_show_create', 'uses' => 'ActivitiesController@showAdd', 'middleware' => 'auth']
        );
        Route::post(
            '/create',
            ['as' => 'activity_create', 'uses' => 'ActivitiesController@postAdd', 'middleware' => 'auth']
        );
        Route::get(
            '/{adventure}',
            ['as' => 'activity_show', 'uses' => 'ActivitiesController@show']
        );
        Route::get(
            '/edit/{adventure}',
            ['as' => 'activity_edit', 'uses' => 'ActivitiesController@edit', 'middleware' => 'auth']
        );
        Route::get(
            '/{adventure}/delete',
            ['as' => 'activity_delete', 'uses' => 'ActivitiesController@delete', 'middleware' => 'auth']
        );
    });



    // reviews

    Route::group(['prefix' => 'reviews'], function () {
        Route::any('/', ['as' =>'reviews_list', 'uses' =>'ReviewsController@reviews']);
        Route::get(
            '/create',
            ['as' => 'review_show_create', 'uses' => 'ReviewsController@showAdd', 'middleware' => 'auth']
        );
        Route::post(
            '/create',
            ['as' => 'review_create', 'uses' => 'ReviewsController@postAdd', 'middleware' => 'auth']
        );
        Route::get(
            '/{review}',
            ['as' => 'review_show', 'uses' => 'ReviewsController@show']
        );

        Route::get(
            '/edit/{review}',
            ['as' => 'app_review_edit', 'uses' => 'ReviewsController@edit', 'middleware' => 'auth']
        );
        //delete
        Route::get(
            '/{review}/delete',
            ['as' => 'app_review_delete', 'uses' => 'ReviewsController@delete', 'middleware' => 'auth']
        );
    });

    // require authentication
    Route::group(['middleware' => 'auth'], function () {
        Route::get('edit-profile', ['uses' => 'ProfileController@showEditProfile', 'middleware' => 'auth']);

        Route::get('/people', 'PeopleController@showPeople');
    });
});
