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
    return [
		'clave' => $faker->unique()->regexify('[A-Z]{8}'),
		'nombre' => $faker->word,
		'horarios' => $faker->text(100),
        'ubicacion' => $faker->text(45),
        'proveedor_id' => factory(App\Proveedor::class)->create()->id,
        'domicilio_id' => factory(App\Domicilio::class)->create()->id
    ];
});

$factory->defineAs(App\Sucursal::class, 'mismaclave', function($faker) use ($factory){
    $clave = 'DICOTECH';
    return [
        'clave' => $clave,
        'nombre' => $faker->word,
        'horarios' => $faker->text(100),
        'ubicacion' => $faker->text(45),
        'proveedor_id' => factory(App\Proveedor::class)->create()->id,
        'domicilio_id' => factory(App\Domicilio::class)->create()->id
    ];
});
