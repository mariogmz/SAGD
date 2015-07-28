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

$factory->define(App\SucursalConfiguracion::class, function ($faker)
{
    return [
        'valor_numero'     => null,
        'valor_texto'      => null,
        'sucursal_id'      => factory(App\Sucursal::class)->create()->id,
        'configuracion_id' => factory(App\Configuracion::class)->create()->id
    ];
});

$factory->defineAs(App\SucursalConfiguracion::class, 'valornumero', function ($faker) use ($factory)
{
    $sucursal_configuracion = $factory->raw(App\SucursalConfiguracion::class);

    return array_merge($sucursal_configuracion, [
        'valor_numero' => $faker->randomFloat(2,0,99999999)
    ]);
});

$factory->defineAs(App\SucursalConfiguracion::class, 'valortexto', function ($faker) use ($factory)
{
    $sucursal_configuracion = $factory->raw(App\SucursalConfiguracion::class);

    return array_merge($sucursal_configuracion, [
        'valor_texto' => $faker->text(),
    ]);
});

$factory->defineAs(App\SucursalConfiguracion::class, 'ambosvalores', function ($faker) use ($factory)
{
    $sucursal_configuracion = $factory->raw(App\SucursalConfiguracion::class);

    return array_merge($sucursal_configuracion, [
        'valor_numero' => $faker->randomFloat(2,0,99999999),
        'valor_texto'  => $faker->text()
    ]);
});
