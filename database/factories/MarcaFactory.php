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
    $clave = $faker->unique()->regexify('[A-Z]{3}');
    return [
        'clave' => $clave,
        'nombre' => $clave . $faker->word(),
    ];
});

$factory->defineAs(App\Marca::class, 'longname', function ($faker) use ($factory) {
    $clave = $faker->unique()->regexify('[A-Z]{3}');
    return [
        'clave' => $clave,
        'nombre' => $clave . $faker->text(),
    ];
});

$factory->defineAs(App\Marca::class, 'lowercase', function ($faker) use ($factory) {
    $clave = $faker->unique()->regexify('[a-z]{3}');
    return [
        'clave' => $clave,
        'nombre' => $clave . $faker->word(),
    ];
});
