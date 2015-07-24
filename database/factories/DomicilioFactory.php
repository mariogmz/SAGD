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

$factory->define(App\CodigoPostal::class, function ($faker)
{
    return [
        'calle'            => $faker->word,
        'localidad'        => $faker->word,
        'codigo_postal_id' => $faker->numerify('#####'),
        'telefono_id'
    ];
});
