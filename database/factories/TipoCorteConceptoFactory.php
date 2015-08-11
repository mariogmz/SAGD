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

$factory->define(App\TipoCorteConcepto::class, function ($faker) {
    return [
        'nombre' => $faker->text(45)
    ];
});

$factory->defineAs(App\TipoCorteConcepto::class, 'nombrelargo', function ($faker) use ($factory) {
    return [
        'nombre' => $faker->text(100)
    ];
});
