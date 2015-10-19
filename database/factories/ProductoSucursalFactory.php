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

$factory->define(App\ProductoSucursal::class, function ($faker) {
    $sucursal = factory(App\Sucursal::class)->create();

    return [
        'producto_id' => factory(App\Producto::class)->create()->id,
        'sucursal_id' => $sucursal->id
    ];
});
