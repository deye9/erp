<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
 */

$router->get('/', function () use ($router) {
    return $router->app->version();
});

Route::group(['middleware' => 'api', 'prefix' => 'auth',], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});

$router->group(['prefix' => 'api/v1'], function () use ($router) {
    $router->get('/products', 'ProductController@index');
    $router->post('/product', 'ProductController@create');
    $router->get('/product/{id}', 'ProductController@show');
    $router->put('/product/{id}', 'ProductController@update');
    $router->delete('/product/{id}', 'ProductController@destroy');
});
