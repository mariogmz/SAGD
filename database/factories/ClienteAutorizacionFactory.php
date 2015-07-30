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

$factory->define(App\ClienteAutorizacion::class, function ($faker)
{
    return [
        'cliente_autorizado_id' => null,
        'nombre_autorizado' => $faker->name
    ];
});

$factory->defineAs(App\ClienteAutorizacion::class, 'onlyclient', function($faker) use ($factory){
    $ca = $factory->raw(App\ClienteAutorizacion::class);
    $ca['cliente_autorizado_id'] = $faker->randomDigit;
    $ca['nombre_autorizado'] = null;
    return $ca;
});

$factory->defineAs(App\ClienteAutorizacion::class, 'onlyname', function($faker) use ($factory){
    $ca = $factory->raw(App\ClienteAutorizacion::class);
    $ca['cliente_autorizado_id'] = null;
    $ca['nombre_autorizado'] = $faker->name;
    return $ca;
});

$factory->defineAs(App\ClienteAutorizacion::class, 'both', function($faker) use ($factory){
    $ca = $factory->raw(App\ClienteAutorizacion::class);
    $ca['cliente_autorizado_id'] = $faker->randomDigitNotNull;
    $ca['nombre_autorizado'] = $faker->name;
    return $ca;
});
