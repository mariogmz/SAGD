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

$factory->define(App\SalidaDetalle::class, function ($faker)
{
    return [
        'cantidad' => $faker->randomNumber(8),
        'producto_id' => $faker->randomDigit,
        'producto_movimiento_id' => $faker->randomDigit,
        'salida_id' => $faker->randomDigit,
    ];
});

$factory->defineAs(App\SalidaDetalle::class, 'full', function($faker) use ($factory){
    $producto = factory(App\Producto::class)->create();
    $producto->addSucursal( factory(App\Sucursal::class)->create() );
    $sd = $factory->raw(App\SalidaDetalle::class);
    $sd['producto_id'] = $producto->id;
    $sd['producto_movimiento_id'] = factory(App\ProductoMovimiento::class)->create([
        'producto_sucursal_id' => $producto->productosSucursales()->first()->id]);
    $sd['salida_id'] = factory(App\Salida::class, 'full')->create()->id;
    return $sd;
});

$factory->defineAs(App\SalidaDetalle::class, 'noproducto', function($faker) use ($factory){
    $sd = $factory->raw(App\SalidaDetalle::class);
    $sd['producto_movimiento_id'] = factory(App\ProductoMovimiento::class, 'withproductosucursal')->create();
    $sd['salida_id'] = factory(App\Salida::class, 'full')->create()->id;
    return $sd;
});

$factory->defineAs(App\SalidaDetalle::class, 'noproductomovimiento', function($faker) use ($factory){
    $sd = $factory->raw(App\SalidaDetalle::class);
    $sd['producto_id'] = factory(App\Producto::class)->create()->id;
    $sd['salida_id'] = factory(App\Salida::class, 'full')->create()->id;
    return $sd;
});

$factory->defineAs(App\SalidaDetalle::class, 'nosalida', function($faker) use ($factory){
    $sd = $factory->raw(App\SalidaDetalle::class);
    $sd['producto_id'] = factory(App\Producto::class)->create()->id;
    $sd['producto_movimiento_id'] = factory(App\ProductoMovimiento::class, 'withproductosucursal')->create();
    return $sd;
});
