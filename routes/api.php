<?php

use Illuminate\Http\Request;

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

Route::post('/user/register', 'AuthController@register');
Route::post('/user/login', 'AuthController@login');
Route::get('/user/verify-email/{uuid}', 'AuthController@verifyEmail');
Route::get('/foo', 'ContentController@index');
