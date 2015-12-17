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

$factory->define(App\Galeria::class, function ($faker) {
    $producto = factory(App\Producto::class)->create();
    return [
        'ficha_id' => $producto->ficha->id,
        'imagen'   => 'http://biodiv.org.ar/wp-content/themes/fearless/images/missing-image-640x360.png'
    ];
});

$factory->defineAs(App\Galeria::class, 'principal', function ($faker) use ($factory) {
    return array_merge($factory->raw(App\Galeria::class), [
        'principal' => true
    ]);
});
