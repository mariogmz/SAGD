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
        'mac_addr'    => App\Caker::realUnique(App\Caja::class, 'mac_addr', 'regexify', '[A-F]{2}:[A-F]{2}:[A-F]{2}:[A-F]{2}:[A-F]{2}:[A-F]{2}'),
        'token'       => App\Caker::realUnique(App\Caja::class, 'token', 'regexify', '[a-zA-Z0-9]{6}'),
        'iteracion'   => $faker->randomNumber(),
        'sucursal_id' => App\Caker::getSucursal()->id
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
        'mac_addr' => $faker->regexify('\w{100}'),
    ]);
});

$factory->defineAs(App\Caja::class, 'tokenlargo', function($faker) use ($factory){
    $caja = $factory->raw(App\Caja::class);
    return array_merge($caja, [
        'nombre' => $faker->text(100),
    ]);
});
