<?php

$factory->define(App\Empleado::class, function ($faker)
{
    return [
        'nombre'                => $faker->name,
        'usuario'               => $faker->unique()->username,
        'password'              => $faker->password,
        'activo'                => $faker->boolean(),
        'puesto'                => $faker->optional()->text(45),
        'fecha_cambio_password' => $faker->dateTime(),
        'access_token'          => $faker->regexify('[a-zA-Z0-9_%+-]{20}'),
        'sucursal_id'           => factory(App\Sucursal::class)->create()->id
    ];
});

$factory->defineAs(App\Empleado::class, 'inactivo', function ($faker) use ($factory)
{
    return [
        'nombre'                => $faker->name,
        'usuario'               => $faker->unique()->username,
        'password'              => $faker->password,
        'activo'                => $faker->boolean(),
        'puesto'                => false,
        'fecha_cambio_password' => $faker->dateTime(),
        'access_token'          => $faker->regexify('[a-zA-Z0-9_%+-]{20}'),
        'sucursal_id'           => factory(App\Sucursal::class)->create()->id
    ];
});
