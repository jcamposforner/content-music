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
use Elasticsearch\ClientBuilder;

Route::get('foo', function () {
    $client = ClientBuilder::create()->build();
    $params = [
        'index' => 'my_index2',
        'body'  => [
            'query' => [
                'match' => [
                    'field1' => 'asd'
                ]
            ]
        ]
    ];

    $response = $client->search($params);
    print_r($response);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
