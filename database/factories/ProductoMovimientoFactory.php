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

$factory->define(App\ProductoMovimiento::class, function ($faker) {
    return [
        'movimiento' => $faker->text(100),
        'entraron' => $faker->randomDigit,
        'salieron' => $faker->randomDigit,
        'existencias_antes' => $faker->randomDigit,
        'existencias_despues' => $faker->randomDigit,
    ];
});

$factory->defineAs(App\ProductoMovimiento::class, 'withproductosucursal', function($faker) use ($factory){
    $pm = $factory->raw(App\ProductoMovimiento::class);
    return array_merge($pm, ['producto_sucursal_id' => factory(App\ProductoSucursal::class)->create()->id]);
});

$factory->defineAs(App\ProductoMovimiento::class, 'longmovimiento', function($faker) use ($factory){
    $pm = $factory->raw(App\ProductoMovimiento::class);
    $pm['movimiento'] = $faker->text . $faker->text;
    return $pm;
});

$factory->defineAs(App\ProductoMovimiento::class, 'nullES', function($faker) use ($factory){
    $pm = $factory->raw(App\ProductoMovimiento::class);
    $pm['entraron'] = null;
    $pm['salieron'] = null;
    return $pm;
});

$factory->defineAs(App\ProductoMovimiento::class, 'nullEX', function($faker) use ($factory){
    $pm = $factory->raw(App\ProductoMovimiento::class);
    $pm['existencias_antes'] = null;
    $pm['existencias_despues'] = null;
    return $pm;
});

$factory->defineAs(App\ProductoMovimiento::class, 'negative', function($faker) use ($factory){
    $pm = $factory->raw(App\ProductoMovimiento::class);
    $pm['entraron'] = -1;
    $pm['salieron'] = -1;
    $pm['existencias_antes'] = -1;
    $pm['existencias_despues'] = -1;
    return $pm;
});
