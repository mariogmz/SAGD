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

$factory->define(App\EstadoEntrada::class, function ($faker)
{
    return [
        'nombre' => $faker->unique->word
    ];
});

$factory->defineAs(App\EstadoEntrada::class, 'longnombre', function($faker) use ($factory){
    $ee = $factory->raw(App\EstadoEntrada::class);
    $ee['nombre'] = $faker->regexify('[a]{46}');
    return $ee;
});
