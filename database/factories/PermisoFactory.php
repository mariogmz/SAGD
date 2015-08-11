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
        'clave' => App\Caker::realUnique(App\Permiso::class, 'clave', 'regexify', '[A-Z]{10}'),
        'nombre' => $faker->text(45),
    ];
});

$factory->defineAs(App\Permiso::class, 'longnombre', function ($faker) use ($factory){
    $permiso = $factory->raw(App\Permiso::class);
    $permiso['nombre'] = $faker->regexify('[a]{46}');
    return $permiso;
});
