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

$factory->define(App\TipoPartida::class, function ($faker) {
    return [
        'clave'       => App\Caker::realUnique(App\TipoPartida::class, 'clave', 'regexify', '[a-zA-Z0-9]{25}'),
        'nombre'      => $faker->text(50),
        'ticket'      => $faker->numberBetween(0, 1),
        'ticket_suma' => $faker->numberBetween(0, 1),
        'pago'        => $faker->numberBetween(0, 1),
    ];
});

$factory->defineAs(App\TipoPartida::class, 'clavelarga', function ($faker) use ($factory) {
    $tipo_partida = $factory->raw(App\TipoPartida::class);

    return array_merge($tipo_partida, [
        'clave' => App\Caker::realUnique(App\TipoPartida::class, 'clave', 'regexify', '[a-zA-Z0-9]{50}'),
    ]);
});

$factory->defineAs(App\TipoPartida::class, 'nombrelargo', function ($faker) use ($factory) {
    $tipo_partida = $factory->raw(App\TipoPartida::class);

    return array_merge($tipo_partida, [
        'nombre' => $faker->regexify('\w{100}'),
    ]);
});

$factory->defineAs(App\TipoPartida::class, 'producto', function ($faker) use ($factory) {
    $tipo_partida = $factory->raw(App\TipoPartida::class);

    return array_merge($tipo_partida, [
        'nombre'      => 'Producto',
        'ticket'      => 1,
        'ticket_suma' => 1,
        'pago'        => 0,
    ]);
});

$factory->defineAs(App\TipoPartida::class, 'pago', function ($faker) use ($factory) {
    $tipo_partida = $factory->raw(App\TipoPartida::class);

    return array_merge($tipo_partida, [
        'nombre'      => 'Pago',
        'ticket'      => 1,
        'ticket_suma' => 0,
        'pago'        => 1
    ]);
});
