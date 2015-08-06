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

$factory->define(App\NivelPermiso::class, function ($faker)
{
    return [
        'nombre' => $faker->text(45),
        'nivel' => $faker->randomDigit,
    ];
});

$factory->defineAs(App\NivelPermiso::class, 'longnombre', function ($faker) use ($factory){
    $nivel_permiso = $factory->raw(App\NivelPermiso::class);
    $nivel_permiso['nombre'] = $faker->regexify('[a]{46}');
    return $nivel_permiso;
});
