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

$factory->define(App\Margen::class, function ($faker) {
    return [
        'nombre' => $faker->word,
        'valor' => $faker->randomFloat(3, 0.0, 1.0),
        'valor_webservice_p1' => $faker->randomFloat(3, 0.0, 1.0),
        'valor_webservice_p8' => $faker->randomFloat(3, 0.0, 1.0),
    ];
});

$factory->defineAs(App\Margen::class, 'longname', function ($faker) use ($factory) {
    return [
        'nombre' => $faker->text(),
        'valor' => $faker->randomFloat(3, 0.0, 1.0),
        'valor_webservice_p1' => $faker->randomFloat(3, 0.0, 1.0),
        'valor_webservice_p8' => $faker->randomFloat(3, 0.0, 1.0),
    ];
});

$factory->defineAs(App\Margen::class, 'nulldecimals', function ($faker) use ($factory) {
    return [
        'nombre' => $faker->word(),
        'valor' => null,
        'valor_webservice_p1' => null,
        'valor_webservice_p8' => null,
    ];
});

$factory->defineAs(App\Margen::class, 'negativedecimals', function ($faker) use ($factory) {
    return [
        'nombre' => $faker->word(),
        'valor' => -1.0,
        'valor_webservice_p1' => -1.0,
        'valor_webservice_p8' => -1.0,
    ];
});

$factory->defineAs(App\Margen::class, 'overonedecimal', function ($faker) use ($factory) {
    return [
        'nombre' => $faker->text(),
        'valor' => $faker->randomFloat(3, 2.0),
        'valor_webservice_p1' => $faker->randomFloat(3, 2.0),
        'valor_webservice_p8' => $faker->randomFloat(3, 2.0),
    ];
});
