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

$factory->define(App\EntradaDetalle::class, function ($faker)
{
    $costo = $faker->randomFloat(2, 0.0, 9999.99);
    $cantidad = $faker->randomNumber(3);
    return [
        'costo' => $costo,
        'cantidad' => $cantidad,
        'importe' => $costo * $cantidad,
        'entrada_id' => $faker->randomDigit,
        'producto_id' => $faker->randomDigit,
        'producto_movimiento_id' => $faker->randomDigit,
    ];
});

$factory->defineAs(App\EntradaDetalle::class, 'full', function($faker) use ($factory){
    $producto = factory(App\Producto::class)->create();
    $producto->addSucursal( factory(App\Sucursal::class)->create() );
    $ed = $factory->raw(App\EntradaDetalle::class);
    $producto = factory(App\Producto::class)->create();
    $ed['entrada_id'] = factory(App\Entrada::class, 'full')->create()->id;
    $ed['producto_id'] = $producto->id;
    $ed['producto_movimiento_id'] = factory(App\ProductoMovimiento::class, 'withproductosucursal')->create()->id;
    return $ed;
});

$factory->defineAs(App\EntradaDetalle::class, 'noentrada', function($faker) use ($factory){
    $ed = $factory->raw(App\EntradaDetalle::class);
    $producto = factory(App\Producto::class)->create();
    $ed['producto_id'] = $producto->id;
    $ed['producto_movimiento_id'] = factory(App\ProductoMovimiento::class, 'withproductosucursal')->create()->id;
    return $ed;
});

$factory->defineAs(App\EntradaDetalle::class, 'noproducto', function($faker) use ($factory){
    $ed = $factory->raw(App\EntradaDetalle::class);
    $ed['entrada_id'] = factory(App\Entrada::class, 'full')->create()->id;
    $ed['producto_movimiento_id'] = factory(App\ProductoMovimiento::class, 'withproductosucursal')->create()->id;
    return $ed;
});

$factory->defineAs(App\EntradaDetalle::class, 'nosucursal', function($faker) use ($factory){
    $ed = $factory->raw(App\EntradaDetalle::class);
    $producto = factory(App\Producto::class)->create();
    $ed['entrada_id'] = factory(App\Entrada::class, 'full')->create()->id;
    $ed['producto_id'] = $producto->id;
    $ed['producto_movimiento_id'] = factory(App\ProductoMovimiento::class, 'withproductosucursal')->create()->id;
    return $ed;
});

$factory->defineAs(App\EntradaDetalle::class, 'noproductomovimiento', function($faker) use ($factory){
    $ed = $factory->raw(App\EntradaDetalle::class);
    $ed['entrada_id'] = factory(App\Entrada::class, 'full')->create()->id;
    $ed['producto_id'] = factory(App\Producto::class)->create()->id;
    return $ed;
});
