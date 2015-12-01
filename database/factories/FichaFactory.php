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

$factory->define(App\Ficha::class, function ($faker) {
    $calidad = [
        'INTERNO', 'ICECAT', 'SUPPLIER', 'NOEDIT'
    ];

    return [
        'producto_id' => factory(App\Producto::class)->create()->id,
        'calidad'     => array_rand($calidad, 1)[0],
        'titulo'      => $faker->text(50),
        'revisada'    => $faker->boolean()
    ];
});

$factory->defineAs(App\Ficha::class, 'norevisada', function ($faker) use ($factory) {
    $raw = $factory->raw(App\Ficha::class);
    unset($raw['revisada']);

    return $raw;
});

$factory->defineAs(App\Ficha::class, 'calidadlarga', function ($faker) use ($factory) {
    return array_merge($factory->raw(App\Ficha::class),[
        'calidad' => $faker->text(300)
    ]);
});

$factory->defineAs(App\Ficha::class, 'titulolargo', function ($faker) use ($factory) {
    return array_merge($factory->raw(App\Ficha::class),[
        'titulo' => $faker->text(300)
    ]);
});
