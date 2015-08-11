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

$factory->define(App\ServicioSoporte::class, function ($faker)
{
    return [
        'descripcion_equipo' => $faker->text(100),
        'falla'              => $faker->text(100),
        'solucion'           => $faker->optional()->text(100),
        'costo'              => $faker->randomFloat(2, 1.00, 99999999.99),
        'fecha_recepcion'    => $faker->dateTime('now'),
        'fecha_entrega'      => $faker->optional()->dateTimeInInterval('+ 1 days','+ 30 days'),
        'estado_soporte_id'  => factory(App\EstadoSoporte::class)->create()->id,
        'empleado_id'        => factory(App\Empleado::class)->create()->id,
        'cliente_id'         => factory(App\Cliente::class, 'full')->create()->id
    ];
});

$factory->defineAs(App\ServicioSoporte::class, 'fallalarga', function ($faker) use ($factory)
{
    $servicio_soporte = $factory->raw(App\ServicioSoporte::class);

    return array_merge($servicio_soporte, [
        'solucion' => $faker->regexify('\w{300}')
    ]);
});

$factory->defineAs(App\ServicioSoporte::class, 'solucionlarga', function ($faker) use ($factory)
{
    $servicio_soporte = $factory->raw(App\ServicioSoporte::class);

    return array_merge($servicio_soporte, [
        'solucion' => $faker->regexify('\w{300}')
    ]);
});

$factory->defineAs(App\ServicioSoporte::class, 'descripcionlarga', function ($faker) use ($factory)
{
    $servicio_soporte = $factory->raw(App\ServicioSoporte::class);

    return array_merge($servicio_soporte, [
        'descripcion_equipo' => $faker->regexify('\w{300}')
    ]);
});

$factory->defineAs(App\ServicioSoporte::class, 'fecharecepcionmayor', function ($faker) use ($factory)
{
    $servicio_soporte = $factory->raw(App\ServicioSoporte::class);

    return array_merge($servicio_soporte, [
        'fecha_recepcion' => $faker->dateTimeInInterval(),
        'fecha_entrega'   => $faker->dateTime()
    ]);
});
