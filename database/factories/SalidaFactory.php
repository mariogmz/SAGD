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

$factory->define(App\Salida::class, function ($faker)
{
    return [
        'fecha_salida' => $faker->dateTime,
        'motivo' => $faker->text(255),
    ];
});

$factory->defineAs(App\Salida::class, 'longmotivo', function($faker) use ($factory){
    $salida = $factory->raw(App\Salida::class);
    $salida['motivo'] = $faker->regexify('[a]{256}');
    return $salida;
});

$factory->defineAs(App\Salida::class, 'full', function($faker) use ($factory){
    $salida = $factory->raw(App\Salida::class);
    $salida['empleado_id'] = factory(App\Empleado::class)->create()->id;
    $salida['sucursal_id'] = factory(App\Sucursal::class)->create()->id;
    $salida['estado_salida_id'] = factory(App\EstadoSalida::class)->create()->id;
    return $salida;
});
