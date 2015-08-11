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

$factory->define(App\GastoExtra::class, function ($faker) {
    return [
        'monto'    => $faker->randomFloat(2, 1.00, 1000.00),
        'concepto' => $faker->text(45),
        'caja_id'  => factory(App\Caja::class)->create()->id,
        'corte_id' => factory(App\Corte::class)->create()->id,
    ];
});

$factory->defineas(App\GastoExtra::class, 'conceptolargo', function ($faker) use ($factory) {
    $gasto_extra = $factory->raw(App\GastoExtra::class);
    return array_merge($gasto_extra, [
        'concepto' => $faker->text(100)
    ]);
});
