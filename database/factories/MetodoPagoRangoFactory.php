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
        'metodo_pago_id' => factory(App\MetodoPago::class)->create()->id
    ];
});

$factory->defineAs(App\MetodoPagoRango::class, 'truncate', function ($faker) use ($factory) {
    DB::statement("SET foreign_key_checks=0");
    App\MetodoPagoRango::truncate();
    DB::statement("SET foreign_key_checks=1");
    $metodo_pago_rango = $factory->raw(App\MetodoPagoRango::class);

    return $metodo_pago_rango;
});

$factory->defineAs(App\MetodoPagoRango::class, 'random', function ($faker) use ($factory) {
    $metodo_pago_rango = $factory->rawOf(App\MetodoPagoRango::class, 'truncate');

    return array_merge($metodo_pago_rango, [
        'desde' => $faker->randomFloat(2, 0.00, 0.50),
        'hasta' => $faker->randomFloat(2, 0.51, 1.00),
    ]);
});
