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

$factory->define(App\Guia::class, function ($faker)
{
    return [
        'nombre' => $faker->text(80),
        'volumen_maximo' => $faker->randomFloat(2, 0.0, 9999.9),
        'ampara_hasta' => $faker->randomFloat(2, 0.0, 9999.9),
        'paqueteria_id' => $faker->randomDigit,
        'estatus_activo_id' => $faker->randomDigit,
    ];
});

$factory->defineAs(App\Guia::class, 'full', function($faker) use ($factory){
    $guia = $factory->raw(App\Guia::class);
    $guia['paqueteria_id'] = factory(App\Paqueteria::class)->create()->id;
    $guia['estatus_activo_id'] = factory(App\EstatusActivo::class)->create()->id;
    return $guia;
});

$factory->defineAs(App\Guia::class, 'longnombre', function($faker) use ($factory){
    $guia = $factory->raw(App\Guia::class);
    $guia['nombre'] = $faker->regexify('[a]{81}');
    return $guia;
});
