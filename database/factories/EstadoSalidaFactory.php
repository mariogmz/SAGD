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

$factory->define(App\EstadoSalida::class, function ($faker)
{
    return [
        'nombre' => $faker->unique()->word,
    ];
});

$factory->defineAs(App\EstadoSalida::class, 'longname', function($faker) use ($factory){
    $es = $factory->raw(App\EstadoSalida::class);
    $es['nombre'] = $faker->regexify('[a]{46}');
    return $es;
});
