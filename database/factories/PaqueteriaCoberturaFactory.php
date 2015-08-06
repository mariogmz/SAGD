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

$factory->define(App\PaqueteriaCobertura::class, function ($faker)
{
    return [
        'ocurre' => $faker->randomFloat(2, 0.0, 9999.9),
        'paqueteria_id' => $faker->randomDigit,
        'codigo_postal_id' => $faker->randomDigit,
    ];
});

$factory->defineAs(App\PaqueteriaCobertura::class, 'full', function($faker) use ($factory){
    $pc = $factory->raw(App\PaqueteriaCobertura::class);
    $pc['paqueteria_id'] = factory(App\Paqueteria::class)->create()->id;
    $pc['codigo_postal_id'] = factory(App\CodigoPostal::class)->create()->id;
    return $pc;
});
