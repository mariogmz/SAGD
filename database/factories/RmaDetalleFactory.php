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

$factory->define(App\RmaDetalle::class, function ($faker) {
    return [
        'descripcion_falla'      => $faker->text(80),
        'rma_id'                 => factory(App\Rma::class)->create()->id,
        'garantia_id'            => factory(App\Garantia::class)->create()->id,
        'producto_movimiento_id' => factory(App\ProductoMovimiento::class, 'withproductosucursal')->create()->id
    ];
});

$factory->defineAs(App\RmaDetalle::class, 'descripcionfallalarga', function ($faker) use ($factory) {
    $rma_detalle = $factory->raw(App\RmaDetalle::class);

    return array_merge($rma_detalle, [
        'descripcion_falla' => $faker->text(200),
    ]);
});

