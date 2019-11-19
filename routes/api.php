<?php

use App\Content;
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

Route::get('foo', function () {
    $content = Content::first();
    $content->title = "Test";
    $content->description = "Test 1";
    $content->src = "URI";
    $content->save();
    foreach ($content->image()->get() as $image) {
        echo $image->id . PHP_EOL;
    }
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
