<?php

/**
 * JSON API routes
 */
use App\Models\Users\User;

Route::group(
    [
        'prefix' => config('_project.api_prefix'),
        'namespace' => 'Api'
    ],
    function () {

        Route::get('search', function () {
            //
        });

        Route::group(['prefix' => 'adventures'], function () {
            // Load more adventures
            Route::get('load_more', function () {
                //
            });
        });

        Route::group(['prefix' => 'reviews'], function () {

            // Load more reviews
            Route::get('load_more', function () {
                //
            });

        });

        Route::post('register', ['uses' => 'AuthController@signUp', 'middleware' => 'session']);
        Route::post('social-login', ['uses' => 'AuthController@socialLogin', 'middleware' => 'session']);

        Route::group(['prefix' => 'users'], function () {

            // Check if e-mail is registered
            Route::get('check-email/{email}', 'UsersController@checkEmail');

            /*Route::get('search_by_name_or_email/{search}', function ($search) {
                // TODO: http://bugs.mysql.com/bug.php?id=80432
                $search = preg_replace('~[^\p{L}\p{N}.-]++~u', ' ', $search);
                $search = trim($search);
                if (strlen($search) === 0) {
                    return [];
                }
                $words = explode(' ', $search);
                $search = '';
                foreach ($words as $word) {
                    $search .= '+' . $word . '* ';
                }
                //dd($search);
                $users = DB::select(
                    'SELECT id, first_name, last_name, email FROM users WHERE
                    MATCH (email, last_name, first_name) AGAINST (? IN BOOLEAN MODE)
                    ORDER BY MATCH(email, last_name, first_name) AGAINST (? IN BOOLEAN MODE) DESC LIMIT 0, 10',
                    [$search, $search]
                );
                $res = [];
                foreach ($users as $user) {
                    $res[$user->id] = $user->email . ' (' . $user->first_name . ' ' . $user->last_name . ')';
                }
                return $res;
            });*/

            Route::get(
                '/add-interest/{interest}/{user}',
                ['uses' => 'UsersController@addInterest', 'middleware' => ['session', 'auth']]
            );
            Route::get(
                '/remove-interest/{interest}/{user}',
                ['uses' => 'UsersController@removeInterest', 'middleware' => ['session', 'auth']]
            );
            Route::get(
                '/interests/{user}/{page?}',
                ['uses' => 'UsersController@interests', 'middleware' => 'session']
            );
            Route::get('/string', ['uses' => 'UsersController@usersFirstLastNameString', 'middleware' => 'session']);
            Route::get('/userId/{slug}', ['uses' => 'UsersController@userById', 'middleware' => 'session']);

            Route::any(
                '/block/{user}/{blockedUSer}',
                ['uses' => 'UsersController@blockUser', 'middleware' => ['session', 'auth']]
            );
        });

        Route::group(['namespace' => 'Geo'], function () {
            Route::resource('countries', 'CountryController', ['only' => ['index', 'show']]);
            Route::resource('countries.cities', 'CityController', ['only' => ['index', 'show']]);
        });

        Route::group(['prefix' => 'interests', 'middleware' => 'session'], function () {
            Route::any('/', 'InterestController@index');
            Route::any('/show/{id}', 'InterestController@show');
            Route::any('/list', 'InterestController@interests');
            Route::any('/add/{interest}', ['uses' => 'InterestController@postAddInterest', 'middleware' => 'auth']);
            Route::any('/edit/{old}/{new}', ['uses' => 'InterestController@editInterest', 'middleware' => 'admin']);
            Route::get('/{interest}', 'InterestController@interest');
            Route::get('/{interest}/delete', ['uses' => 'InterestController@deleteInterest', 'middleware' => 'admin']);
        });

        Route::group(['prefix' => 'adventures', 'middleware' => 'session'], function () {
            Route::any('/invite', ['uses' => 'ActivitiesController@invite', 'middleware' => 'auth']);
            Route::get(
                '/add-interest/{interest}/{model}',
                ['uses' => 'ActivitiesController@addInterest', 'middleware' => 'auth']
            );
            Route::get(
                '/remove-interest/{interest}/{model}',
                ['uses' => 'ActivitiesController@removeInterest', 'middleware' => 'auth']
            );
            Route::get('/interests/{model}/{page?}', 'ActivitiesController@interests');
            Route::any('/like/{model}', ['uses' => 'ActivitiesController@like', 'middleware' => 'auth']);
        });

        Route::group(['prefix' => 'reviews', 'middleware' => 'session'], function () {
            Route::get(
                '/add-interest/{interest}/{model}',
                ['uses' => 'ReviewsController@addInterest', 'middleware' => 'auth']
            );
            Route::get(
                '/remove-interest/{interest}/{model}',
                ['uses' => 'ReviewsController@removeInterest', 'middleware' => 'auth']
            );
            Route::get('/interests/{model}/{page?}', 'ReviewsController@interests');
            Route::any('/like/{model}', ['uses' => 'ReviewsController@like', 'middleware' => 'auth']);
            Route::any('/recommend/{model}', ['uses' => 'ReviewsController@recommend', 'middleware' => 'auth']);
            Route::get(
                '/related/{model}',
                ['as' => 'review_related', 'uses' => 'ReviewsController@related', 'middleware' => 'auth']
            );

        });

        Route::group(['prefix' => 'activity_comments', 'middleware' => ['session', 'auth']], function () {
            Route::any('/like/{post}', 'ActivityCommentsController@like');
            Route::any('/reply/{id?}', 'ActivityCommentsController@reply');
        });
        Route::group(['prefix' => 'review_comments', 'middleware' => ['session', 'auth']], function () {
            Route::any('/like/{post}', 'ReviewCommentsController@like');
            Route::any('/reply/{id?}', 'ReviewCommentsController@reply');
            Route::any(
                '/delete/{reviewComment}',
                ['uses' => 'ReviewCommentsController@deleteReply', 'middleware' => 'session']
            );
        });

        // Require authentication

        Route::group(['middleware', 'auth'], function () {

            Route::post('edit-profile', ['uses' => 'ProfileController@postEdit', 'middleware' => 'session']);
            Route::post('change-password', ['uses' => 'AuthController@changePassword', 'middleware' => 'web']);
            Route::post('deactivate-account', ['uses' => 'AuthController@deactivateAccount', 'middleware' => 'web']);

            Route::post(
                'profile-notifications',
                [
                    'uses' => 'ProfileController@postNotifications',
                    'middleware' => 'web'
                ]
            );

            Route::group(['prefix' => 'profile'], function () {
                Route::get('is-password-empty', 'ProfileController@getIsPasswordEmpty');
                Route::post('unblock-user', ['uses' => 'ProfileController@unblockUser', 'middleware' => 'web']);
            });

            Route::group(['prefix' => 'users'], function () {
                Route::post(
                    '/{user}/unblock/{blocked-user}',
                    ['uses' => 'UsersController@unblockUser', 'middleware' => 'session']
                );
            });

            Route::get('languages', 'LanguageController@index');
        });
    }
);
