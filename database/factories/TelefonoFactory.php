<?php

$factory->define(App\Telefono::class, function ($faker)
{
    return [
        'numero' => App\Caker::realUnique(App\Telefono::class, 'numero', 'regexify', '\d{11}'),
        'tipo'   => $faker->word,
    ];
});
