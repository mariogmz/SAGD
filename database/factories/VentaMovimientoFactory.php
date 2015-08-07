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

$factory->define(App\VentaMovimiento::class, function ($faker) {
    return [
        'venta_id'         => factory(App\Venta::class)->create()->id,
        'empleado_id'      => factory(App\Empleado::class)->create()->id,
        'estatus_venta_id' => factory(App\EstatusVenta::class)->create()->id,
        'estado_venta_id'  => factory(App\EstadoVenta::class)->create()->id,
    ];
});
