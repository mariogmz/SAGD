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
        'rma_id'                 => factory(App\Rma::class)->create() || 1,
        'garantia_id'            => 1,
        'producto_movimiento_id' => factory(App\ProductoMovimiento::class, 'withproduct')->create()->id
    ];
});

$factory->defineAs(App\RmaDetalle::class, 'descripcionfallalargo', function ($faker) use ($factory) {
    return [
        'descripcion_falla'      => $faker->text(160),
        'rma_id'                 => factory(App\Rma::class)->create() || 1,
        'garantia_id'            => 1,
        'producto_movimiento_id' => factory(App\ProductoMovimiento::class, 'withproduct')->create()->id
    ];
});
