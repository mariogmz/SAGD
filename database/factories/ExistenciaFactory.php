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

$factory->define(App\Existencia::class, function ($faker) {
    return [
        'cantidad' => $faker->randomDigit,
        'cantidad_apartado' => $faker->randomDigit,
        'cantidad_pretransferencia' => $faker->randomDigit,
        'cantidad_transferencia' => $faker->randomDigit,
        'cantidad_garantia_cliente' => $faker->randomDigit,
        'cantidad_garantia_zegucom' => $faker->randomDigit,
        'productos_sucursales_id' => $faker->randomDigit
    ];
});

$factory->defineAs(App\Existencia::class, 'negativeamount', function($faker) use($factory){
   return [
        'cantidad' => -1,
        'cantidad_apartado' => -1,
        'cantidad_pretransferencia' => -1,
        'cantidad_transferencia' => -1,
        'cantidad_garantia_cliente' => -1,
        'cantidad_garantia_zegucom' => -1,
    ];
});

$factory->defineAs(App\Existencia::class, 'nullamount', function($faker) use($factory){
   return [
        'cantidad' => null,
        'cantidad_apartado' => null,
        'cantidad_pretransferencia' => null,
        'cantidad_transferencia' => null,
        'cantidad_garantia_cliente' => null,
        'cantidad_garantia_zegucom' => null,
    ];
});
