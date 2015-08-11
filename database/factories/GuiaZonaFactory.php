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

$factory->define(App\GuiaZona::class, function ($faker)
{
    return [
        'costo' => $faker->randomFloat(2, 0.0, 9999.9),
        'costo_sobrepeso' => $faker->randomFloat(2, 0.0, 9999.9),
        'guia_id' => $faker->randomDigit,
        'zona_id' => $faker->randomDigit,
    ];
});

$factory->defineAs(App\GuiaZona::class, 'full', function($faker) use ($factory){
    $guia_zona = $factory->raw(App\GuiaZona::class);
    $guia_zona['guia_id'] = factory(App\Guia::class, 'full')->create()->id;
    $guia_zona['zona_id'] = factory(App\Zona::class)->create()->id;
    return $guia_zona;
});
