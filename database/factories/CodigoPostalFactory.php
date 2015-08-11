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
        'estado'        => $faker->word,
        'municipio'     => $faker->word,
        'codigo_postal' => App\Caker::realUnique(App\CodigoPostal::class, 'codigo_postal', 'regexify', '\d{5}'),
    ];
});
