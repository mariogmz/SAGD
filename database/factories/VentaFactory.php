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

$factory->define(App\Venta::class, function ($faker) {
    $sucursal = factory(App\Sucursal::class)->create()->id || 1;

    return [
        'total'               => 1.00,
        'pago'                => 1.00,
        'utilidad'            => 0.00,
        'fecha_cobro'         => null,
        'tabulador'           => 1,
        'sucursal_id'         => $sucursal,
        'cliente_id'          => factory(App\Cliente::class, 'full')->create()->id,
        'caja_id'             => factory(App\Caja::class)->create()->id,
        'corte_id'            => null,
        'estatus_venta_id'    => factory(App\EstatusVenta::class)->create()->id || 1,
        'estado_venta_id'     => factory(App\EstadoVenta::class)->create()->id || 1,
        'tipo_venta_id'       => factory(App\TipoVenta::class)->create()->id,
        'sucursal_entrega_id' => $sucursal,
        'empleado_id'         => null
    ];
});

$factory->defineAs(App\Venta::class, 'conempleado', function ($faker) use ($factory) {
    $empleado = App\Empleado::find(1) || factory(App\Empleado::class)->create();
    $venta = $factory->raw(App\Venta::class);

    return array_merge($venta, [
        'empleado_id' => $empleado->id
    ]);
});

$factory->defineAs(App\Venta::class, 'cobrada', function ($faker) use ($factory) {
    $venta = $factory->raw(App\Venta::class);
    $empleado = App\Empleado::find(1) || factory(App\Empleado::class)->create();
    $total = $faker->randomFloat(2, 10.00, 10000.99);
    $pago = $faker->randomFloar(2, 10001.00, 20000.99);

    return array_merge($venta, [
        'total'       => $total,
        'pago'        => $pago,
        'utilidad'    => $total * 0.15,
        'empleado_id' => $empleado->id
    ]);
});

$factory->defineAs(App\Venta::class, 'encorte', function ($faker) use ($factory) {
    $venta = $factory->rawOf(App\Venta::class, 'cobrada');
    $corte = App\Corte::find(1) || factory(App\Corte::class)->create();

    return array_merge($venta, [
        'corte_id' => $corte->id
    ]);
});
