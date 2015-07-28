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

$factory->define(App\SucursalEnvio::class, function ($faker)
{
    return [
        'sucursal_origen_id'  => factory(App\Sucursal::class)->create()->id,
        'sucursal_destino_id' => factory(App\Sucursal::class)->create()->id,
        'genera_costo'        => $faker->numberBetween(0, 1),
        'dias_max_envio'      => $faker->randomNumber(2)
    ];
});
