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

$factory->define(App\Rol::class, function ($faker)
{
    return [
        'clave' => App\Caker::realUnique(App\Rol::class, 'clave', 'regexify', '[A-Z]{6}'),
        'nombre' => $faker->text(45)
    ];
});

$factory->defineAs(App\Rol::class, 'longname', function($faker) use ($factory){
    $rol = $factory->raw(App\Rol::class);
    $rol['nombre'] = $faker->regexify('[a]{46}');
    return $rol;
});

$factory->defineAs(App\Rol::class, 'minclave', function($faker) use ($factory){
    $rol = $factory->raw(App\Rol::class);
    $rol['clave'] = App\Caker::realUnique(App\Rol::class, 'clave', 'regexify', '[a-z]{6}');
    return $rol;
});
