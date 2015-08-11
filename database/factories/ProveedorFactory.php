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

$factory->define(App\Proveedor::class, function ($faker)
{
    return [
        'clave'        => $faker->regexify('[a-z]{4}'),
        'razon_social' => $faker->text(),
        'externo'      => $faker->numberBetween(0,1),
        'pagina_web'   => $faker->url()
    ];
});

$factory->defineAs(\App\Proveedor::class, 'uppercaseKey', function ($faker) use ($factory)
{
    $proveedor = $factory->raw(\App\Proveedor::class);

    return array_merge($proveedor, ['clave' => strtoupper($proveedor['clave'])]);
});
