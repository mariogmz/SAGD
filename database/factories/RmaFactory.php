<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\Rma::class, function ($faker) {
    return [
        'estado_rma_id'   => factory(App\EstadoRma::class)->create()->id,
        'cliente_id'      => factory(App\Cliente::class, 'full')->create()->id,
        'empleado_id'     => factory(App\Empleado::class)->create()->id,
        'rma_tiempo_id'   => factory(App\RmaTiempo::class)->create()->id,
        'sucursal_id'     => App\Caker::getSucursal()->id,
        'nota_credito_id' => factory(App\NotaCredito::class, 'full')->create()->id
    ];
});

$factory->defineAs(App\Rma::class, 'sinnotacredito', function ($faker) use ($factory) {
    return [
        'estado_rma_id'   => factory(App\EstadoRma::class)->create()->id,
        'cliente_id'      => factory(App\Cliente::class, 'full')->create()->id,
        'empleado_id'     => factory(App\Empleado::class)->create()->id,
        'rma_tiempo_id'   => factory(App\RmaTiempo::class)->create()->id,
        'sucursal_id'     => App\Caker::getSucursal()->id,
        'nota_credito_id' => null
    ];
});
