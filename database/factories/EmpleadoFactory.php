<?php

$factory->define(App\Empleado::class, function ($faker)
{
    return [
        'nombre'                => $faker->name,
        'usuario'               => App\Caker::realUnique(App\Empleado::class, 'usuario', 'userName'),
        'password'              => $faker->password,
        'activo'                => $faker->numberBetween(0,1),
        'puesto'                => $faker->optional()->text(45),
        'fecha_cambio_password' => $faker->dateTime(),
        'access_token'          => $faker->regexify('[a-zA-Z0-9_%+-]{20}'),
        'sucursal_id'           => App\Caker::getSucursal()->id
    ];
});

$factory->defineAs(App\Empleado::class, 'inactivo', function ($faker) use ($factory) {
    $empleado = $factory->raw(App\Empleado::class);

    return array_merge($empleado, [
        'activo' => 0,
    ]);
});
