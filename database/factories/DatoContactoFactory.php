<?php

$factory->define(App\DatoContacto::class, function ($faker)
{
    return [
        'telefono'       => $faker->phoneNumber,
        'email'          => $faker->email,
        'fotografia_url' => $faker->imageUrl()
    ];
});
