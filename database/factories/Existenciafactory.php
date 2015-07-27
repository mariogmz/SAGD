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
        'cantidad' =>  $faker->randomDigit,
        'cantidad_apartado' =>  $faker->randomDigit,
        'cantidad_pretransferencia' =>  $faker->randomDigit,
        'cantidad_transferencia' =>  $faker->randomDigit,
        'cantidad_garantia_cliente' =>  $faker->randomDigit,
        'cantidad_garantia_zegucom' =>  $faker->randomDigit,
    ];
});

$factory->defineAs(App\Existencia::class, 'associated', function($faker) use ($factory){
    $existencia = $factory->raw(App\Existencia::class);
    return array_merge($existencia, ['productos_sucursales_producto_id' => '',
        'productos_sucursales_sucursal_id' => '' ]);
});

$factory->defineAs(App\Existencia::class, 'negativeamount', function($faker) use ($factory){
    $existencia = $factory->raw(App\Existencia::class);
    $existencia['cantidad'] = -1;
    $existencia['cantidad_apartado'] = -1;
    $existencia['cantidad_pretransferencia'] = -1;
    $existencia['cantidad_transferencia'] = -1;
    $existencia['cantidad_garantia_cliente'] = -1;
    $existencia['cantidad_garantia_zegucom'] = -1;
    return $existencia;
});

$factory->defineAs(App\Existencia::class, 'nullamount', function($faker) use ($factory){
    $existencia = $factory->raw(App\Existencia::class);
    $existencia['cantidad'] = null;
    $existencia['cantidad_apartado'] = null;
    $existencia['cantidad_pretransferencia'] = null;
    $existencia['cantidad_transferencia'] = null;
    $existencia['cantidad_garantia_cliente'] = null;
    $existencia['cantidad_garantia_zegucom'] = null;
    return $existencia;
});
