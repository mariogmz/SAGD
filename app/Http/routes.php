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
        Route::post('password/email', 'PasswordController@postEmail');
        Route::post('password/reset', 'PasswordController@postReset');
        Route::post('password/verify', 'AuthenticateController@verify');

        Route::resource('producto', 'ProductoController', ['only' => ['index','store','show','update','destroy']]);
        Route::get('producto/buscar/upc/{upc}', 'ProductoController@buscarUpc');
        Route::group(['prefix' => 'producto', 'as' => 'api.v1.productos'], function(){
            Route::group(['prefix' => '{id}/existencias', 'as' => '.existencias'], function(){
                Route::get('/', 'ProductoController@indexExistencias');
                Route::post('pretransferir', ['uses' => 'ProductoController@pretransferir', 'as' => '.pretransferir']);
            });
            Route::group(['prefix' => '{id}/movimientos', 'as' => '.movimientos'], function(){
                Route::get('sucursal/{sucursal}', ['as' => '.sucursal', 'uses' => 'ProductoController@indexMovimientos']);
            });
        });

        Route::group(['prefix' => 'inventario', 'as' => 'api.v1.inventarios'], function(){
            Route::group(['prefix' => 'pretransferencias', 'as' => '.pretransferencias'], function(){
                Route::get('origen/{id}', 'PretransferenciaController@index');
                Route::post('imprimir', ['as' => '.imprimir', 'uses' => 'PretransferenciaController@imprimir']);
                Route::post('transferir/origen/{origen}/destino/{destino}', ['as' => '.transferir', 'uses' => 'PretransferenciaController@transferir']);
                Route::delete('/eliminar/{id}', ['as' => '.delete', 'uses' => 'PretransferenciaController@delete']);
            });
        });

        Route::get('productos/buscar', 'ProductoController@buscar');
        Route::resource('marca', 'MarcaController', ['only' => ['store','show','update','destroy']]);
        Route::get('marca/{campo?}/{valor?}', 'MarcaController@index');
        Route::resource('unidad', 'UnidadController', ['only' => ['index','store','show','update','destroy']]);
        Route::resource('tipo-garantia', 'TipoGarantiaController', ['only' => ['index','store','show','update','destroy']]);
        Route::resource('dimension', 'DimensionController', ['only' => ['index','store','show','update','destroy']]);
        Route::get('/calcular-precio','PrecioController@calcular');
        Route::resource('precio', 'PrecioController', ['only' => ['index','store','show','update','destroy']]);
        Route::resource('familia', 'FamiliaController', ['only' => ['index','store','show','update','destroy']]);
        Route::resource('subfamilia', 'SubfamiliaController', ['only' => ['store','show','update','destroy']]);
        Route::get('subfamilia/{campo?}/{valor?}', 'SubfamiliaController@index');
        Route::resource('margen', 'MargenController', ['only' => ['index','store','show','update','destroy']]);
		Route::resource('producto-sucursal', 'ProductoSucursalController', ['only' => ['index', 'store', 'show', 'update', 'destroy']]);
        Route::resource('cliente', 'ClienteController', ['only' => ['index','store','show','update','destroy']]);
        Route::get('clientes/buscar', 'ClienteController@buscar');
        Route::get('clientes/listar', 'ClienteController@listar');
        Route::resource('cliente-comentario', 'ClienteComentarioController', ['only' => ['index', 'store', 'show', 'update', 'destroy']]);
        Route::resource('cliente-referencia', 'ClienteReferenciaController', ['only' => ['index','store','show','update','destroy']]);
        Route::resource('cliente-estatus', 'ClienteEstatusController', ['only' => ['index','store','show','update','destroy']]);
        Route::resource('codigo-postal', 'CodigoPostalController', ['only' => ['index','store','show','update','destroy']]);
        Route::get('/codigo-postal/find/{id}', 'CodigoPostalController@find');
        Route::resource('domicilio', 'DomicilioController', ['only' => ['index','store','show','update','destroy']]);
        Route::resource('rol', 'RolController', ['only' => ['index','store','show','update','destroy']]);
        Route::get('permiso/generales', 'RolController@generales');
        Route::get('permiso/individuales', 'RolController@individuales');
        Route::post('rol/attach/{rol}/{permiso}', 'RolController@attach');
        Route::delete('rol/detach/{rol}/{permiso}', 'RolController@detach');
        Route::get('rol/{id}/empleados', 'RolController@empleados');
        Route::post('rol/{id}/empleados/attach/{empleado}', 'RolController@attachEmpleado');
        Route::delete('rol/{id}/empleados/detach/{empleado}', 'RolController@detachEmpleado');
        Route::get('roles/clientes', 'RolController@rolesClientes');
        Route::resource('permiso', 'PermisoController', ['only' => ['index','store','show','update','destroy']]);
        Route::resource('telefono', 'TelefonoController', ['only' => ['index','store','show','update','destroy']]);

        Route::resource('ficha', 'FichaController',['only' => ['index','store','show','update','destroy']]);
        Route::get('ficha/completa/{id}', 'FichaController@fichaCompleta');
        Route::group(['prefix' => 'icecat', 'as' => 'api.v1.icecat'], function () {
            Route::get('/{numero_parte}/marca/{marca}','IcecatController@obtenerFicha')->name('.ficha');
            Route::get('/supplier/{campo?}/{valor?}', 'IcecatSupplierController@index')->name('.supplier');
            Route::put('/supplier/{id}', 'IcecatSupplierController@update')->name('.supplier.update');
            Route::get('/category/{campo?}/{valor?}', 'IcecatCategoryController@index')->name('.category');
            Route::put('/category/{id}', 'IcecatCategoryController@update')->name('.category.update');
            Route::get('/feature/{id}', 'IcecatFeatureController@show')->name('.feature.show');
            Route::get('/feature/{campo?}/{valor?}', 'IcecatFeatureController@index')->name('.feature');
        });


        Route::resource('empleado', 'EmpleadoController', ['only' => ['index', 'store', 'show', 'update', 'destroy']]);
        Route::get('empleado/{id}/roles', 'EmpleadoController@roles');
        Route::post('empleado/{id}/roles/attach/{rol}', 'EmpleadoController@attach');
        Route::delete('empleado/{id}/roles/detach/{rol}', 'EmpleadoController@detach');
        Route::post('empleado/{empleadoId}/sucursal/{sucursalId}', 'EmpleadoController@cambiarSucursal');
        Route::resource('sucursal', 'SucursalController', ['only' => ['index', 'store', 'show', 'update', 'destroy']]);
        Route::get('sucursal/proveedor/{clave}', 'SucursalController@conProveedor');
        Route::resource('proveedor', 'ProveedorController', ['only' => ['index','store','show','update']]);
        Route::get('logs-acceso', 'LogsAccesoController@index');
        Route::resource('salida', 'SalidaController', ['only' => ['index', 'store', 'show', 'update', 'destroy']]);
        Route::post('salida/{id}/detalles', 'SalidaController@saveDetalle');
        Route::delete('salida/{id}/detalles/{detalle_id}', 'SalidaController@unsaveDetalle');
        Route::get('salida/{id}/cargar', 'SalidaController@cargarSalida');
        Route::resource('entrada', 'EntradaController', ['only' => ['index', 'store', 'show', 'update', 'destroy']]);
        Route::post('entrada/{id}/detalles', 'EntradaController@saveDetalle');
        Route::delete('entrada/{id}/detalles/{detalle_id}', 'EntradaController@unsaveDetalle');
        Route::get('entrada/{id}/cargar', 'EntradaController@cargarEntrada');
        Route::resource('razon-social-emisor', 'RazonSocialEmisorController', ['only' => ['index', 'store', 'show', 'update', 'destroy']]);
        Route::get('emisor/entrada', 'RazonSocialEmisorController@emisorEntrada');

        Route::group(['prefix' => 'transferencias', 'as' => 'api.v1.transferencias'], function(){
            Route::delete('eliminar/{id}', 'TransferenciaController@destroy')->name('.delete');
            Route::group(['prefix' => 'salidas', 'as' => '.salidas'], function() {
                Route::delete('{id}/detalle/{detalle}', 'TransferenciaController@unsaveDetalle');
                Route::get('/', 'TransferenciaController@indexSalidas');
                Route::get('ver/{id}', 'TransferenciaController@show')->name('.ver');
                Route::post('crear', 'TransferenciaController@create');
                Route::post('transferir/{id}', 'TransferenciaController@transferir');
                Route::post('{id}/detalle', 'TransferenciaController@saveDetalle');
                Route::put('/{id}', 'TransferenciaController@update');
            });
            Route::group(['prefix' => 'entradas', 'as' => '.entradas'], function() {
                Route::get('/', 'TransferenciaController@indexEntradas');
                Route::get('ver/{id}', 'TransferenciaController@show');
                Route::post('cargar/{id}', 'TransferenciaController@cargar');
                Route::post('/{id}/detalle/{detalle}/escanear', 'TransferenciaController@escanear');
                Route::post('/{id}/detalle/{detalle}/reset', 'TransferenciaController@reset');
                Route::post('/{id}/cargando-destino', 'TransferenciaController@cargandoDestino');
                Route::put('/{id}', 'TransferenciaController@update');
            });
        });
    });
});
