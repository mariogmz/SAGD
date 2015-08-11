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

$factory->define(App\Garantia::class, function ($faker)
{
    return [
        'serie' => $faker->text(45),
        'venta_detalle_id' => factory(App\VentaDetalle::class, 'producto')->create()->id
    ];
});

$factory->defineAs(App\Garantia::class, 'serielargo', function ($faker) use ($factory) {
    $garantia = $factory->raw(App\Garantia::class);

    return array_merge($garantia, [
        'serie' => $faker->text(100),
    ]);
});
