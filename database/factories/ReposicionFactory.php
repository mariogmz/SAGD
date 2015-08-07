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

$factory->define(App\Reposicion::class, function ($faker) {
    return [
        'serie'        => $faker->text(45),
        'producto_id'  => factory(App\Producto::class)->create()->id,
        'garantia_id'  => factory(App\Garantia::class)->create()->id,
        'proveedor_id' => factory(App\Proveedor::class)->create()->id
    ];
});

$factory->defineAs(App\Reposicion::class, 'serielargo', function ($faker) use ($factory) {
    $reposicion = $factory->raw(App\Reposicion::class);

    return array_merge($reposicion, [
        'serie' => $faker->text(100),
    ]);
});
