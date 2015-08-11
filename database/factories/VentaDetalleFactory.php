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

$factory->define(App\VentaDetalle::class, function ($faker) {
    $cantidad = $faker->randomNumber(3);
    $precio = $faker->randomFloat(2, 1.00, 10000.99);

    return [
        'cantidad'                  => $cantidad,
        'descripcion'               => $faker->optional()->text(45),
        'precio'                    => $precio,
        'total'                     => $cantidad * $precio,
        'utilidad'                  => ($cantidad * $precio) * $faker->randomFloat(2, 0.01, 0.90),
        'fecha_expiracion_garantia' => $faker->optional()->dateTime('+ 30 days'),
        'tiempo_garantia'           => 0,
        'venta_id'                  => factory(App\Venta::class)->create()->id,
        'tipo_partida_id'           => null,
        'producto_id'               => null,
        'metodo_pago_id'            => null,
        'factura_id'                => null,
        'nota_credito_id'           => null
    ];
});

$factory->defineAs(App\VentaDetalle::class, 'descripcionlarga', function ($faker) use ($factory) {
    $venta_detalle = $factory->rawOf(App\VentaDetalle::class, 'producto');

    return array_merge($venta_detalle, [
        'descripcion' => $faker->text(100),
    ]);
});

$factory->defineAs(App\VentaDetalle::class, 'producto', function ($faker) use ($factory) {
    $venta_detalle = $factory->raw(App\VentaDetalle::class);

    return array_merge($venta_detalle, [
        'tipo_partida_id' => factory(App\TipoPartida::class, 'producto')->create()->id,
        'producto_id'     => factory(App\Producto::class)->create()->id,
        'metodo_pago_id'  => factory(App\MetodoPago::class)->create()->id,
    ]);
});

$factory->defineAs(App\VentaDetalle::class, 'pago', function ($faker) use ($factory) {
    $venta_detalle = $factory->raw(App\VentaDetalle::class);

    return array_merge($venta_detalle, [
        'tipo_partida_id' => factory(App\TipoPartida::class, 'pago')->create()->id,
        'metodo_pago_id'  => factory(App\MetodoPago::class)->create()->id
    ]);
});

$factory->defineAs(App\VentaDetalle::class, 'facturada', function ($faker) use ($factory) {
    $venta_detalle = $factory->rawOf(App\VentaDetalle::class, 'producto');

    return array_merge($venta_detalle, [
        'factura_id' => factory(App\Factura::class, 'full')->create()->id
    ]);
});

$factory->defineAs(App\VentaDetalle::class, 'notacredito', function ($faker) use ($factory) {
    $venta_detalle = $factory->raw(App\VentaDetalle::class);

    return array_merge($venta_detalle, [
        'nota_credito_id' => factory(App\NotaCredito::class, 'full')->create()->id,
    ]);
});
