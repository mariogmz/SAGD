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

$factory->define(App\MetodoPagoRango::class, function ($faker) {
    return [
        'desde'          => 0.00,
        'hasta'          => 1.00,
        'valor'          => $faker->randomFloat(2, 0.01, 0.99),
//        'metodo_pago_id' => factory(App\MetodoPago::class)->create()->id
        'metodo_pago_id' => 1
    ];
});

$factory->defineAs(App\MetodoPagoRango::class, 'random', function ($faker) use ($factory) {
    return [
        'desde'          => $faker->randomFloat(2, 0.00, 0.50),
        'hasta'          => $faker->randomFloat(2, 0.51, 1.00),
        'valor'          => $faker->randomFloat(2, 0.01, 0.99),
//        'metodo_pago_id' => factory(App\MetodoPago::class)->create()->id
        'metodo_pago_id' => 1
    ];
});
