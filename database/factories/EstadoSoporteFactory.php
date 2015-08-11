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

$factory->define(App\EstadoSoporte::class, function ($faker)
{
    return [
        'clave'  => App\Caker::realUnique(App\EstadoSoporte::class, 'clave', 'regexify', '[A-Z0-9]{6}'),
        'nombre' => $faker->text(50)
    ];
});

$factory->defineAs(App\EstadoSoporte::class, 'clavelarga', function ($faker) use ($factory)
{
    $estado_soporte = $factory->raw(App\EstadoSoporte::class);

    return array_merge($estado_soporte, [
        'clave' => App\Caker::realUnique(App\EstadoSoporte::class, 'clave', 'regexify', '[A-Z0-9]{10}')
    ]);
});

$factory->defineAs(App\EstadoSoporte::class, 'nombrelargo', function ($faker) use ($factory)
{
    $estado_soporte = $factory->raw(App\EstadoSoporte::class);

    return array_merge($estado_soporte, [
        'nombre' => $faker->text(100)
    ]);
});
