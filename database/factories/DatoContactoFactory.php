<?php

$factory->define(App\DatoContacto::class, function ($faker)
{
    return [
        'direccion'      => $faker->optional()->text(100),
        'telefono'       => $faker->optional()->regexify('/[0-9]{20}/'),
        'email'          => $faker->unique()->email,
        'skype'          => $faker->optional()->userName,
        'fotografia_url' => $faker->optional()->imageUrl(),
        'empleado_id'    => factory(App\Empleado::class)->create()->id
    ];
});
