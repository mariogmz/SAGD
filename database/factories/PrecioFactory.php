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

$factory->define(App\Precio::class, function ($faker) {
    return [
        'costo' => $faker->randomFloat(2, 0.0, 9999.99),
        'precio_1' => $faker->randomFloat(2, 0.0, 9999.99),
        'precio_2' => $faker->randomFloat(2, 0.0, 9999.99),
        'precio_3' => $faker->randomFloat(2, 0.0, 9999.99),
        'precio_4' => $faker->randomFloat(2, 0.0, 9999.99),
        'precio_5' => $faker->randomFloat(2, 0.0, 9999.99),
        'precio_6' => $faker->randomFloat(2, 0.0, 9999.99),
        'precio_7' => $faker->randomFloat(2, 0.0, 9999.99),
        'precio_8' => $faker->randomFloat(2, 0.0, 9999.99),
        'precio_9' => $faker->randomFloat(2, 0.0, 9999.99),
        'precio_10' => $faker->randomFloat(2, 0.0, 9999.99),

    ];
});

$factory->defineAs(App\Precio::class, 'nullcosto', function($faker) use ($factory){
    $precio = $factory->raw(App\Precio::class);
    $precio['costo'] = null;
    return $precio;
});

$factory->defineAs(App\Precio::class, 'negcosto', function($faker) use ($factory){
    $precio = $factory->raw(App\Precio::class);
    $precio['costo'] = -1.0;
    return $precio;
});

$factory->defineAs(App\Precio::class, 'nullprecios', function($faker) use ($factory){
    $precio = $factory->raw(App\Precio::class);
    $precio['precio_1'] = null;
    $precio['precio_2'] = null;
    $precio['precio_3'] = null;
    $precio['precio_4'] = null;
    $precio['precio_5'] = null;
    $precio['precio_6'] = null;
    $precio['precio_7'] = null;
    $precio['precio_8'] = null;
    $precio['precio_9'] = null;
    $precio['precio_10'] = null;
    return $precio;
});

$factory->defineAs(App\Precio::class, 'negprecios', function($faker) use ($factory){
    $precio = $factory->raw(App\Precio::class);
    $precio['precio_1'] = -1.0;
    $precio['precio_2'] = -1.0;
    $precio['precio_3'] = -1.0;
    $precio['precio_4'] = -1.0;
    $precio['precio_5'] = -1.0;
    $precio['precio_6'] = -1.0;
    $precio['precio_7'] = -1.0;
    $precio['precio_8'] = -1.0;
    $precio['precio_9'] = -1.0;
    $precio['precio_10'] = -1.0;
    return $precio;
});
