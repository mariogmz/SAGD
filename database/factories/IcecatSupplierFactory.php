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

$factory->define(App\Anticipo::class, function ($faker) {
    return [
        'venta_id'         => factory(App\Venta::class)->create()->id,
        'venta_entrega_id' => null,
        'concepto'         => $faker->text(45),
        'monto'            => $faker->randomFloat(2, 1.00, 10000.99),
        'cobrado'          => 0
    ];
});

$factory->defineAs(App\Anticipo::class, 'cobrado', function ($faker) use ($factory) {
    $anticipo = $factory->raw(App\Anticipo::class);

    return array_merge($anticipo, [
        'cobrado'          => 1,
        'venta_entraga_id' => $anticipo->venta_entrega_id
    ]);
});

$factory->defineAs(App\Anticipo::class, 'conceptolargo', function ($faker) use ($factory) {
    $anticipo = $factory->raw(App\Anticipo::class);

    return array_merge($anticipo, [
        'concepto' => $faker->text(200),
    ]);
});
