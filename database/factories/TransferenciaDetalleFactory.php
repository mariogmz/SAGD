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
        'cantidad_escaneada' => $faker->randomNumber(7),
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
    $producto = factory(App\Producto::class)->create();
    $producto->addSucursal( factory(App\Sucursal::class)->create() );

    $td = $factory->raw(App\TransferenciaDetalle::class);
    $td['transferencia_id'] = factory(App\Transferencia::class, 'full')->create()->id;
    $td['producto_id'] = $producto->id;
    $td['producto_movimiento_id'] = factory(App\ProductoMovimiento::class)->create([
        'producto_sucursal_id' => $producto->productosSucursales()->first()->id
    ])->id;
    return $td;
});

$factory->defineAs(App\TransferenciaDetalle::class, 'nopm', function($faker) use ($factory){
    factory(App\Sucursal::class)->create();
    $producto = factory(App\Producto::class)->create();

    $td = $factory->raw(App\TransferenciaDetalle::class);
    $td['transferencia_id'] = factory(App\Transferencia::class, 'full')->create()->id;
    $td['producto_id'] = $producto->id;
    return $td;
});
