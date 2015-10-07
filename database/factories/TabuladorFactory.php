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

$factory->define(App\Tabulador::class, function ($faker)
{
    $cliente = factory(App\Cliente::class, "full")->create();

    return [
        'tabulador' => $faker->numberBetween($min = 1, $max = 10),
        'tabulador_original' => $faker->numberBetween($min = 1, $max = 10),
        'habilitada' => $faker->numberBetween(0, 1),
        'venta_especial' => $faker->numberBetween(0, 1),
        'cliente_id' => $cliente->id,
        'sucursal_id' => $cliente->sucursal_id
    ];
});
