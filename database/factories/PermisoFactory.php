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

$factory->define(App\Permiso::class, function ($faker)
{
    return [
        'controlador' => $faker->text(45),
        'accion' => $faker->text(45),
    ];
});

$factory->defineAs(App\Permiso::class, 'longcontrolador', function ($faker) use ($factory){
    $permiso = $factory->raw(App\Permiso::class);
    $permiso['controlador'] = $faker->regexify('[a]{46}');
    return $permiso;
});

$factory->defineAs(App\Permiso::class, 'longaccion', function ($faker) use ($factory){
    $permiso = $factory->raw(App\Permiso::class);
    $permiso['accion'] = $faker->regexify('[a]{46}');
    return $permiso;
});
