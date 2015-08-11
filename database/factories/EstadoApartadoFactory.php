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

$factory->define(App\EstadoApartado::class, function ($faker)
{
    return [
        'nombre' => App\Caker::realUnique(App\EstadoApartado::class, 'nombre', 'regexify', '\w{1,45}'),
    ];
});

$factory->defineAs(App\EstadoApartado::class, 'longname', function($faker) use ($factory){
    $ea = $factory->raw(App\EstadoApartado::class);
    $ea['nombre'] = $faker->regexify('[a]{46}');
    return $ea;
});
