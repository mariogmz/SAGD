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

$factory->define(App\Sucursal::class, function ($faker) {
    while (empty($proveedor_id = factory(App\Proveedor::class)->create()->id)) ;
    while (empty($domicilio_id = factory(App\Domicilio::class)->create()->id)) ;

    return [
        'clave'        => App\Caker::realUnique(App\Sucursal::class, 'clave', 'regexify', '[A-Z]{8}'),
        'nombre'       => $faker->regexify('\w{1,45}'),
        'horarios'     => $faker->regexify('\w{1,100}'),
        'ubicacion'    => $faker->regexify('\w{1,45}'),
        'proveedor_id' => $proveedor_id,
        'domicilio_id' => $domicilio_id
    ];
});

$factory->defineAs(App\Sucursal::class, 'mismaclave', function ($faker) use ($factory) {
    $sucursal = $factory->raw(App\Sucursal::class);

    return array_merge($sucursal, [
        'clave' => 'DICOTECH',
    ]);
});

$factory->defineAs(App\Sucursal::class, 'noprov', function ($faker) use ($factory) {
    return [
        'clave'        => App\Caker::realUnique(App\Sucursal::class, 'clave', 'regexify', '[A-Z]{8}'),
        'nombre'       => $faker->regexify('\w{1,45}'),
        'horarios'     => $faker->regexify('\w{1,100}'),
        'ubicacion'    => $faker->regexify('\w{1,45}'),
        'domicilio_id' => factory(App\Domicilio::class)->create()->id
    ];
});

$factory->defineAs(App\Sucursal::class, 'interna', function ($faker) use ($factory) {
    $sucursal = $factory->raw(App\Sucursal::class);

    return array_merge($sucursal, [
        'proveedor_id' => factory(App\Proveedor::class, 'interno')->create()->id
    ]);
});

$factory->defineAs(App\Sucursal::class, 'externa', function ($faker) use ($factory) {
    $sucursal = $factory->raw(App\Sucursal::class);

    return array_merge($sucursal, [
        'proveedor_id' => factory(App\Proveedor::class, 'externo')->create()->id
    ]);
});
