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

$factory->define(App\Transferencia::class, function ($faker)
{
    return [
        'fecha_transferencia' => $faker->dateTime,
        'fecha_recepcion' => $faker->dateTime
    ];
});

$factory->defineAs(App\Transferencia::class, 'full', function($faker) use ($factory){
    $transferencia = $factory->raw(App\Transferencia::class);
    $transferencia['estado_transferencia_id'] = factory(App\EstadoTransferencia::class)->create()->id;
    $transferencia['sucursal_origen_id'] = factory(App\Sucursal::class)->create()->id;
    $transferencia['sucursal_destino_id'] = factory(App\Sucursal::class)->create()->id;
    $transferencia['empleado_origen_id'] = factory(App\Empleado::class)->create()->id;
    $transferencia['empleado_destino_id'] = factory(App\Empleado::class)->create()->id;
    $transferencia['empleado_revision_id'] = factory(App\Empleado::class)->create()->id;
    return $transferencia;
});
