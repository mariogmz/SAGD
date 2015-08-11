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

$factory->define(App\Unidad::class, function ($faker) {
    return [
        'clave' => App\Caker::realUnique(App\Unidad::class, 'clave', 'regexify', '[A-Z]{4}'),
        'nombre' => $faker->word(),
    ];
});

$factory->defineAs(App\Unidad::class, 'longname', function ($faker) use ($factory) {
    return [
        'clave' => App\Caker::realUnique(App\Unidad::class, 'clave', 'regexify', '[A-Z]{4}'),
        'nombre' => $faker->regexify('a{100}'),
    ];
});

$factory->defineAs(App\Unidad::class, 'lowercase', function ($faker) use ($factory) {
    return [
        'clave' => App\Caker::realUnique(App\Unidad::class, 'clave', 'regexify', '[a-z]{4}'),
        'nombre' => $faker->word(),
    ];
});

