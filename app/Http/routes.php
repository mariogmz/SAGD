<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['namespace' => 'Api', 'prefix' => 'api'], function(){
    Route::group(['namespace' => 'V1', 'prefix' => 'v1'], function(){
        Route::resource('authenticate', 'AuthenticateController', ['only' => ['authenticate']]);
        Route::post('authenticate', 'AuthenticateController@authenticate');
        Route::get('logout', 'AuthenticateController@logout');

        Route::resource('empleado', 'EmpleadoController', ['only' => ['index']]);
    });
});
