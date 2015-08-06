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

$factory->define(App\PaqueteriaRango::class, function ($faker)
{
    return [
        'desde' => $faker->randomFloat(2, 0.0, 0.5),
        'hasta' => $faker->randomFloat(2, 0.51, 1.0),
        'valor' => $faker->randomFloat(2, 0.0, 1.0),
        'distribuidor' => $faker->boolean,
        'paqueteria_id' => $faker->randomDigit,
    ];
});

$factory->defineAs(App\PaqueteriaRango::class, 'full', function($faker) use ($factory){
    $pr = $factory->raw(App\PaqueteriaRango::class);
    $pr['paqueteria_id'] = factory(App\Paqueteria::class)->create()->id;
    return $pr;
});
