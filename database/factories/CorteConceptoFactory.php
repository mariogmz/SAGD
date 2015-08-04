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

$factory->define(App\CorteConcepto::class, function ($faker) {
    return [
        'nombre'                 => $faker->text(45),
        'tipo_corte_concepto_id' => factory(App\TipoCorteConcepto::class)->create()->id
    ];
});

$factory->defineAs(App\CorteConcepto::class, 'nombrelargo', function ($faker) use ($factory) {
    $corte_concepto = $factory->raw(App\CorteConcepto::class);

    return array_merge($corte_concepto, [
        'nombre' => $faker->text(100)
    ]);
});
