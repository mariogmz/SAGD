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

$factory->define(App\ClienteSucursal::class, function ($faker)
{
    return [
        'tabulador' => $faker->numberBetween($min = 1, $max = 10),
        'tabulador_original' => $faker->numberBetween($min = 1, $max = 10),
        'habilitada' => $faker->numberBetween(0, 1),
        'venta_especial' => $faker->numberBetween(0, 1),
        'cliente_id' => 1,
        'sucursal_id' => 1
    ];
});

$factory->defineAs(App\ClienteSucursal::class, 'longname', function($faker) use ($factory){
    $clienteSucursal = $factory->raw(App\ClienteSucursal::class);
    $clienteSucursal['tabulador'] = $faker->numberBetween($min = 1, $max = 10);
    return $clienteSucursal;
});
