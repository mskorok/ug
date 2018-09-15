<?php

/**
 * Developer routes
 */
Route::get('dev', 'Dev\DevController@index');
Route::post('dev/dotenv', 'Dev\DevController@postDotenv');
Route::get('dev/dotenv', 'Dev\DevController@copyDotenv');
Route::get('dev/appkey', 'Dev\DevController@generateAppKey');
Route::get('dev/composer-install', 'Dev\DevController@composerInstall');
Route::get('dev/db-rebuild', 'Dev\DevController@dbRebuild');
