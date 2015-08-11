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

$factory->define(App\ClienteEstatus::class, function ($faker)
{
    return [
        'nombre' => $faker->text(45)
    ];
});

$factory->defineAs(App\ClienteEstatus::class, 'longname', function($faker) use ($factory){
    $clienteestatus = $factory->raw(App\ClienteEstatus::class);
    $clienteestatus['nombre'] = $faker->regexify('[a]{46}');
    return $clienteestatus;
});
