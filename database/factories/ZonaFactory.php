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

$factory->define(App\Zona::class, function ($faker)
{
    return [
        'clave' => $faker->unique()->text(6),
        'km_maximos' => $faker->randomFloat(2, 0.0, 9999.99),
    ];
});
