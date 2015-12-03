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

$factory->define(App\Pretransferencia::class, function ($faker) {
    $sucursal_origen = factory(App\Sucursal::class)->create();
    $sucursal_destino = factory(App\Sucursal::class)->create();
    $producto = factory(App\Producto::class)->create();

    return [
        'cantidad' => $faker->randomNumber,
        'producto_id' => $producto->id,
        'sucursal_origen_id' => $sucursal_origen->id,
        'sucursal_destino_id' => $sucursal_destino->id
    ];
});
