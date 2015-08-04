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

$factory->define(App\ApartadoDetalle::class, function ($faker)
{
    return [
        'cantidad' => $faker->randomNumber(6),
        'existencia_antes' => $faker->randomNumber(3),
        'existencia_despues' => $faker->randomNumber(3),
        'apartado_id' => $faker->randomDigit,
        'producto_id' => $faker->randomDigit,
        'producto_movimiento_id' => $faker->randomDigit,
    ];
});

$factory->defineAs(App\ApartadoDetalle::class, 'full', function($faker) use ($factory){
    $ad = $factory->raw(App\ApartadoDetalle::class);
    $ad['apartado_id'] = factory(App\Apartado::class, 'full')->create()->id;
    $ad['producto_id'] = factory(App\Producto::class)->create()->id;
    $ad['producto_movimiento_id'] = factory(App\ProductoMovimiento::class)->create([
        'producto_id' => $ad['producto_id']])->id;
    return $ad;
});
