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
  $clave = $faker->lexify('???');
    return [
        'clave' => $clave,
        'nombre' => $clave . $faker->word(),
    ];
});
