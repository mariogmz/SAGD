<?php

$factory->define(App\Telefono::class, function ($faker)
{
    return [
        'numero' => $faker->unique()->regexify('[0-9]{11}'),
        'tipo'   => $faker->word,
    ];
});
