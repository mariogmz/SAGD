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

$factory->define(App\Caja::class, function ($faker) {
    return [
        'nombre'      => $faker->word,
        'mac_addr'    => $faker->unique()->macAddress,
        'token'       => $faker->unique()->regexify('/[a-zA-Z0-9]{6}/'),
        'iteracion'   => $faker->randomNumber(),
        'sucursal_id' => factory(App\Sucursal::class)->create()->id
    ];
});

$factory->defineAs(App\Caja::class, 'nombrelargo', function($faker) use ($factory){
    $caja = $factory->raw(App\Caja::class);
    return array_merge($caja, [
        'nombre' => $faker->text(100),
    ]);
});

$factory->defineAs(App\Caja::class, 'maclarga', function($faker) use ($factory){
    $caja = $factory->raw(App\Caja::class);
    return array_merge($caja, [
        'mac_addr' => $faker->text(100),
    ]);
});

$factory->defineAs(App\Caja::class, 'tokenlargo', function($faker) use ($factory){
    $caja = $factory->raw(App\Caja::class);
    return array_merge($caja, [
        'nombre' => $faker->text(100),
    ]);
});
