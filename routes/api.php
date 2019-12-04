<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'prefix' => 'auth'
], function () {
    Route::get('verify-email/{uuid}', 'AuthController@verifyEmail');
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
    Route::group([
        'middleware' => 'auth:api'
    ], function () {
        Route::resource('content', 'ContentController');
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
        Route::post('profile-picture', 'UploadController@uploadProfilePicture');
    });
});

Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'upload'
], function () {
    Route::post('video', 'UploadController@uploadVideoContent');
});

Route::get('/foo', 'ContentController@index')->middleware();
