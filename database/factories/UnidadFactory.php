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
  $clave = $faker->regexify('[A-Z]{4}');
    return [
        'clave' => $clave,
        'nombre' => $clave . $faker->word(),
    ];
});

$factory->defineAs(App\Unidad::class, 'longname', function ($faker) use ($factory) {
  $clave = $faker->regexify('[A-Z]{4}');
    return [
        'clave' => $clave,
        'nombre' => $clave . $faker->text(),
    ];
});

$factory->defineAs(App\Unidad::class, 'lowercase', function ($faker) use ($factory) {
  $clave = $faker->regexify('[a-z]{4}');
    return [
        'clave' => $clave,
        'nombre' => $clave . $faker->word(),
    ];
});

