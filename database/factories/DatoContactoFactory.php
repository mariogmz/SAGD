<?php

$factory->define(App\DatoContacto::class, function ($faker)
{
    return [
        'direccion'      => $faker->optional()->text(100),
        'telefono'       => $faker->optional()->regexify('/[0-9]{20}/'),
        'email'          => App\Caker::realUnique(App\DatoContacto::class, 'email', 'email'),
        'skype'          => $faker->optional()->userName,
        'fotografia_url' => $faker->optional()->imageUrl(),
        'empleado_id'    => factory(App\Empleado::class)->create()->id
    ];
});

$factory->defineAs(App\DatoContacto::class, 'bare', function($faker) use ($factory){
    return [
        'direccion'      => $faker->optional()->text(100),
        'telefono'       => $faker->optional()->regexify('/[0-9]{20}/'),
        'email'          => App\Caker::realUnique(App\DatoContacto::class, 'email', 'email'),
        'skype'          => $faker->optional()->userName,
        'fotografia_url' => $faker->optional()->imageUrl(),
    ];
});
