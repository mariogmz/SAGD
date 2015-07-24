<?php

$factory->define(App\Telefono::class, function ($faker)
{
    return [
        'numero' => $faker->unique()->phoneNumber,
        'tipo'   => $faker->word,
    ];
});

$factory->defineAs(App\Telefono::class, 'mismonum', function ($faker) use ($factory)
{
    return [
        'numero' => '132-149-0269x3767',
        'tipo'   => $faker->word,
    ];
});
