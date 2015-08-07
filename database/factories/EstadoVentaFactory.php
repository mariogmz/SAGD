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

$factory->define(App\EstadoVenta::class, function ($faker) {
    DB::statement("SET foreign_key_checks=0");
    App\EstadoVenta::truncate();
    DB::statement("SET foreign_key_checks=1");

    return [
        'clave'  => $faker->unique()->randomLetter,
        'nombre' => $faker->text(50)
    ];
});

$factory->defineAs(App\EstadoVenta::class, 'withouttruncate', function ($faker) use ($factory) {
    return [
        'clave'  => $faker->unique()->randomLetter,
        'nombre' => $faker->text(50)
    ];
});


$factory->defineAs(App\EstadoVenta::class, 'nombrelargo', function ($faker) use ($factory) {
    $estado_venta = $factory->rawOf(App\EstadoVenta::class, 'withouttruncate');

    return array_merge($estado_venta, [
        'nombre' => $faker->text(100)
    ]);
});

$factory->defineAs(App\EstadoVenta::class, 'clavenumero', function ($faker) use ($factory) {
    $estado_venta = $factory->rawOf(App\EstadoVenta::class, 'withouttruncate');

    return array_merge($estado_venta, [
        'clave' => $faker->unique()->randomDigitNotNull
    ]);
});

