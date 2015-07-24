<?php

$factory->define(App\DatoContacto::class, function ($faker)
{
    return [
        'empleado_id'    => factory(\App\Empleado::class)->create()->id,
        'telefono'       => $faker->phoneNumber,
        'email'          => $faker->email,
        'fotografia_url' => $faker->imageUrl()
    ];
});
