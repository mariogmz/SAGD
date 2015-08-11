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

$factory->define(App\Configuracion::class, function ($faker)
{
    return [
        'nombre' => $faker->regexify('[a-zA-Z0-9_]{15}'),
        'tipo'   => $faker->regexify('[a-zA-Z0-9_]{10}'),
        'modulo' => $faker->regexify('[a-zA-Z0-9_]{10}'),
    ];
});

$factory->defineAs(App\Configuracion::class, 'nombrelargo', function ($faker) use ($factory)
{
    return [
        'nombre' => $faker->regexify('[a-zA-Z0-9_]{50}'),
        'tipo'   => $faker->regexify('[a-zA-Z0-9_]{10}'),
        'modulo' => $faker->regexify('[a-zA-Z0-9_]{10}'),
    ];
});

$factory->defineAs(App\Configuracion::class, 'tipolargo', function ($faker) use ($factory)
{
    return [
        'nombre' => $faker->regexify('[a-zA-Z0-9_]{15}'),
        'tipo'   => $faker->regexify('[a-zA-Z0-9_]{10}'),
        'modulo' => $faker->regexify('[a-zA-Z0-9_]{50}'),
    ];
});

$factory->defineAs(App\Configuracion::class, 'modulolargo', function ($faker) use ($factory)
{
    return [
        'nombre' => $faker->text(15),
        'tipo'   => $faker->text(10),
        'modulo' => $faker->text(50),
    ];
});

