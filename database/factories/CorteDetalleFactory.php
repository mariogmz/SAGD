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

$factory->define(App\CorteDetalle::class, function ($faker) {
    return [
        'monto'             => $faker->randomFloat(2, 1.00, 1000.00),
        'corte_id'          => factory(App\Corte::class)->create()->id,
        'corte_concepto_id' => factory(App\CorteConcepto::class)->create()->id
    ];
});
