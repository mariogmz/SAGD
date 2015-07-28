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

$factory->define(App\ClienteReferencia::class, function ($faker)
{
    return [
        'nombre' => $faker->text(50)
    ];
});

$factory->defineAs(App\ClienteReferencia::class, 'longname', function($faker) use ($factory){
    $clienteReferencia = $factory->raw(App\ClienteReferencia::class);
    $clienteReferencia['nombre'] = $faker->regexify('[a]{51}');
    return $clienteReferencia;
});
