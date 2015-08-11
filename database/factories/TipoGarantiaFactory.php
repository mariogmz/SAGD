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

$factory->define(App\TipoGarantia::class, function ($faker) {
    return [
        'seriado' => $faker->boolean(),
        'descripcion' => $faker->text(45),
        'dias' => $faker->randomDigitNotNull()
    ];
});

$factory->defineAs(App\TipoGarantia::class, 'longdesc', function($faker) use ($factory) {
    return [
        'seriado' => $faker->boolean(),
        'descripcion' => $faker->regexify('a{100}'),
        'dias' => $faker->randomDigitNotNull()
    ];
});
