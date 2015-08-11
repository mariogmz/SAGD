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

$factory->define(App\Corte::class, function ($faker) {
    return [
        'fondo'           => $faker->randomFloat(2, 1.00, 1000.00),
        'fondo_reportado' => $faker->optional()->randomFloat(2, 1.00, 1000.00),
        'caja_id'         => factory(App\Caja::class)->create()->id,
        'empleado_id'     => factory(App\Empleado::class)->create()->id,
        'corte_global_id' => factory(App\Corte::class, 'global')->create()->id
    ];
});

$factory->defineAs(App\Corte::class, 'global', function ($faker) use ($factory) {
    return [
        'fondo'           => $faker->randomFloat(2, 1.00, 1000.00),
        'fondo_reportado' => $faker->optional()->randomFloat(2, 1.00, 1000.00),
        'caja_id'         => null,
        'empleado_id'     => factory(App\Empleado::class)->create()->id,
        'corte_global_id' => null
    ];
});
