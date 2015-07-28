<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\PaginaWebDistribuidor::class, function ($faker)
{
    return [
        'activo' => $faker->boolean,
        'fecha_vencimiento' => $faker->dateTime,
        'url' => $faker->url
    ];
});

$factory->defineAs(App\PaginaWebDistribuidor::class, 'longurl', function($faker) use ($factory){
    $pwd = $factory->raw(App\PaginaWebDistribuidor::class);
    $pwd['url'] = $faker->regexify('[a]{101}');
    return $pwd;
});
