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
        Route::get('authenticate/empleado', 'AuthenticateController@getAuthenticatedEmpleado');
        Route::get('logout', 'AuthenticateController@logout');

        Route::resource('producto', 'ProductoController', ['only' => ['index','store','show','update','destroy']]);
        Route::resource('marca', 'MarcaController', ['only' => ['index','store','show','update','destroy']]);
        Route::resource('unidad', 'UnidadController', ['only' => ['index','store','show','update','destroy']]);
        Route::resource('tipo-garantia', 'TipoGarantiaController', ['only' => ['index','store','show','update','destroy']]);
        Route::resource('dimension', 'DimensionController', ['only' => ['index','store','show','update','destroy']]);
        Route::resource('familia', 'FamiliaController', ['only' => ['index','store','show','update','destroy']]);
        Route::resource('subfamilia', 'SubfamiliaController', ['only' => ['index','store','show','update','destroy']]);
        Route::resource('margen', 'MargenController', ['only' => ['index','store','show','update','destroy']]);
        Route::resource('cliente', 'ClienteController', ['only' => ['index','store','show','update','destroy']]);


        Route::resource('empleado', 'EmpleadoController', ['only' => ['index']]);

        Route::resource('proveedor', 'ProveedorController', ['only' => ['index','store','show','update']]);
    });
});
