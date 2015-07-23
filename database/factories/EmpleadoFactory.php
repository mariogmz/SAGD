<?php

$factory->define(App\Empleado::class, function ($faker)
{
    return [
        'nombre'       => $faker->name,
        'usuario'      => $faker->username,
        'password'     => $faker->password,
        'activo'       => $faker->boolean(),
        'access_token' => $faker->regexify('[a-zA-Z0-9_%+-]+{20}')
    ];
});

$factory->defineAs(App\Empleado::class, 'inactivo', function ($faker) use ($factory)
{
    $empleado = $factory->raw(App\Empleado::class);

    return array_merge($empleado, ['activo' => false]);
});
