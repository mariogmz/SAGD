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

$factory->define(App\Rma::class, function ($faker)
{
    return [
        'estado_rma_id'   => factory(App\EstadoRma::class)->create()->id,
        'cliente_id'      => factory(App\Cliente::class, 'full')->create()->id,
        'empleado_id'     => factory(App\Empleado::class)->create()->id,
        'rma_tiempo_id'   => factory(App\RmaTiempo::class)->create()->id,
        'sucursal_id'     => factory(App\Sucursal::class)->create()->id,
        'nota_credito_id' => null
    ];
});

$factory->defineAs(App\Rma::class, 'sinnotacredito', function ($faker) use ($factory)
{
    return [
        'estado_rma_id'   => factory(App\EstadoRma::class)->create()->id || 1,
        'cliente_id'      => factory(App\Cliente::class, 'full')->create()->id || 1,
        'empleado_id'     => factory(App\Empleado::class)->create()->id || 1,
        'rma_tiempo_id'   => factory(App\RmaTiempo::class)->create()->id || 1,
        'sucursal_id'     => factory(App\Sucursal::class)->create()->id || 1,
        'nota_credito_id' => null
    ];
});
