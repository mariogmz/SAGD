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

$factory->define(App\Marca::class, function ($faker) {
    return [
        'clave' => App\Caker::realUnique(App\Marca::class, 'clave', 'regexify', '[A-Z]{3}'),
        'nombre' => $faker->word(),
    ];
});

$factory->defineAs(App\Marca::class, 'longname', function ($faker) use ($factory) {
    return [
        'clave' => App\Caker::realUnique(App\Marca::class, 'clave', 'regexify', '[A-Z]{3}'),
        'nombre' => $faker->regexify('\w{100}'),
    ];
});

$factory->defineAs(App\Marca::class, 'lowercase', function ($faker) use ($factory) {
    return [
        'clave' => App\Caker::realUnique(App\Marca::class, 'clave', 'regexify', '[a-z]{3}'),
        'nombre' => $faker->word(),
    ];
});
