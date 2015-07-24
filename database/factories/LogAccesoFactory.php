<?php

$factory->define(App\LogAcceso::class, function ($faker)
{
    return [
        'empleado_id' => factory(\App\Empleado::class)->create()->id,
        'fecha'       => $faker->dateTime(),
        'exitoso'     => $faker->boolean()
    ];
});

$factory->defineAs(\App\LogAcceso::class, 'successful', function ($faker) use ($factory)
{
    return [
        'empleado_id' => factory(\App\Empleado::class)->create()->id,
        'fecha'       => $faker->dateTime(),
        'exitoso'     => true
    ];
});

$factory->defineAs(\App\LogAcceso::class, 'unsuccessful', function ($faker) use ($factory)
{
    return [
        'empleado_id' => factory(\App\Empleado::class)->create()->id,
        'fecha'       => $faker->dateTime(),
        'exitoso'     => true
    ];
});
