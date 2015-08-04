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

$factory->define(App\TransferenciaDetalle::class, function ($faker)
{
    return [
        'cantidad' => $faker->randomNumber(8),
        'existencia_origen_antes' => $faker->randomNumber,
        'existencia_origen_despues' => $faker->randomNumber,
        'existencia_destino_antes' => $faker->randomNumber,
        'existencia_destino_despues' => $faker->randomNumber,
        'transferencia_id' => $faker->randomDigit,
        'producto_id' => $faker->randomDigit,
        'producto_movimiento_id' => $faker->randomDigit,
    ];
});

$factory->defineAs(App\TransferenciaDetalle::class, 'full', function($faker) use ($factory){
    $td = $factory->raw(App\TransferenciaDetalle::class);
    $td['transferencia_id'] = factory(App\Transferencia::class, 'full')->create()->id;
    $td['producto_id'] = factory(App\Producto::class)->create()->id;
    $td['producto_movimiento_id'] = factory(App\ProductoMovimiento::class)->create([
        'producto_id' => $td['producto_id']])->id;
    return $td;
});
