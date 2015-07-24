<?php

$factory->define(App\Telefono::class, function ($faker)
{
    return [
        'numero' => $faker->unique()->regexify('[0-9]{11}'),
        'tipo'   => $faker->word,
    ];
});

$factory->defineAs(App\Telefono::class, 'mismonum', function ($faker) use ($factory)
{
    return [
        'numero' => '01236459871',
        'tipo'   => $faker->word,
    ];
});
