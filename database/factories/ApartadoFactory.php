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

$factory->define(App\Apartado::class, function ($faker)
{
    return [
        'fecha_apartado' => $faker->dateTime,
        'fecha_desapartado' => $faker->dateTime,
        'concepto' => $faker->text(255)
    ];
});

$factory->defineAs(App\Apartado::class, 'full', function($faker) use ($factory){
    $apartado = $factory->raw(App\Apartado::class);
    $apartado['estado_apartado_id'] = factory(App\EstadoApartado::class)->create()->id;
    $apartado['sucursal_id'] = factory(App\Sucursal::class)->create()->id;
    $apartado['empleado_apartado_id'] = factory(App\Empleado::class)->create()->id;
    $apartado['empleado_desapartado_id'] = factory(App\Empleado::class)->create()->id;
    return $apartado;
});

$factory->defineAs(App\Apartado::class, 'longconcepto', function($faker) use ($factory){
    $apartado = $factory->raw(App\Apartado::class);
    $apartado['concepto'] = $faker->regexify('[a]{256}');
    return $apartado;
});
