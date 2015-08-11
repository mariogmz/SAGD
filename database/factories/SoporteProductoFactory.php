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

$factory->define(App\SoporteProducto::class, function ($faker) {
    return [
        'cantidad'    => $faker->numberBetween(1, 20),
        'precio'      => $faker->randomFloat(2, 0.20, 99999999.99),
        'servicio_soporte_id'  => factory(App\ServicioSoporte::class)->create()->id,
        'producto_id' => factory(App\Producto::class)->create()->id || 1
    ];
});
