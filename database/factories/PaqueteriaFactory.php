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

$factory->define(App\Paqueteria::class, function ($faker)
{
    return [
        'clave' => App\Caker::realUnique(App\Paqueteria::class, 'clave', 'regexify', '[A-Z]{6}'),
        'nombre' => $faker->text(45),
        'url' => $faker->url,
        'horario' => 'Lun-Vie 9 a 5, Sabado 10 a 3',
        'condicion_entrega' => $faker->text(100),
        'seguro' => $faker->randomFloat(2, 0.0, 1.0),
    ];
});

$factory->defineAs(App\Paqueteria::class, 'lowerclave', function($faker) use ($factory){
    $paq = $factory->raw(App\Paqueteria::class);
    $paq['clave'] = strtolower($paq['clave']);
    return $paq;
});

$factory->defineAs(App\Paqueteria::class, 'longnombre', function($faker) use ($factory){
    $paq = $factory->raw(App\Paqueteria::class);
    $paq['nombre'] = $faker->regexify('[a]{46}');
    return $paq;
});

$factory->defineAs(App\Paqueteria::class, 'longurl', function($faker) use ($factory){
    $paq = $factory->raw(App\Paqueteria::class);
    $paq['url'] = $faker->regexify('http:\/\/www\.[a]{100}\.com');
    return $paq;
});

$factory->defineAs(App\Paqueteria::class, 'longhorario', function($faker) use ($factory){
    $paq = $factory->raw(App\Paqueteria::class);
    $paq['horario'] = $faker->regexify('[a]{61}');
    return $paq;
});

$factory->defineAs(App\Paqueteria::class, 'longcondicion', function($faker) use ($factory){
    $paq = $factory->raw(App\Paqueteria::class);
    $paq['condicion_entrega'] = $faker->regexify('[a]{101}');
    return $paq;
});

