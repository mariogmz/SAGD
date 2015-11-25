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

$factory->define(App\Entrada::class, function ($faker)
{
    return [
        'factura_externa_numero' => $faker->regexify('[A-Z]{3}\d{10}'),
        'factura_fecha' => $faker->dateTime,
        'moneda' => $faker->regexify('(DOLAR|PESOS)'),
        'tipo_cambio' => $faker->randomFloat(2, 0.0, 99.99),
        'estado_entrada_id' => $faker->randomDigit,
        'proveedor_id' => $faker->randomDigit,
        'razon_social_id' => $faker->randomDigit,
        'empleado_id' => $faker->randomDigit,
        'sucursal_id' => $faker->randomDigit,
    ];
});

$factory->defineAs(App\Entrada::class, 'full', function($faker) use ($factory){
    $entrada = $factory->raw(App\Entrada::class);
    $entrada['estado_entrada_id'] = factory(App\EstadoEntrada::class)->create()->id;
    $entrada['proveedor_id'] = factory(App\Proveedor::class)->create()->id;
    $entrada['razon_social_id'] = factory(App\RazonSocialEmisor::class, 'full')->create()->id;
    $entrada['empleado_id'] = factory(App\Empleado::class)->create()->id;
    $entrada['sucursal_id'] = App\Caker::getSucursal()->id;
    return $entrada;
});

$factory->defineAs(App\Entrada::class, 'noestado', function($faker) use ($factory){
    $entrada = $factory->raw(App\Entrada::class);
    $entrada['proveedor_id'] = factory(App\Proveedor::class)->create()->id;
    $entrada['razon_social_id'] = factory(App\RazonSocialEmisor::class, 'full')->create()->id;
    $entrada['empleado_id'] = factory(App\Empleado::class)->create()->id;
    $entrada['sucursal_id'] = App\Caker::getSucursal()->id;
    return $entrada;
});

$factory->defineAs(App\Entrada::class, 'noproveedor', function($faker) use ($factory){
    $entrada = $factory->raw(App\Entrada::class);
    $entrada['estado_entrada_id'] = factory(App\EstadoEntrada::class)->create()->id;
    $entrada['razon_social_id'] = factory(App\RazonSocialEmisor::class, 'full')->create()->id;
    $entrada['empleado_id'] = factory(App\Empleado::class)->create()->id;
    $entrada['sucursal_id'] = App\Caker::getSucursal()->id;
    return $entrada;
});

$factory->defineAs(App\Entrada::class, 'norazonsocial', function($faker) use ($factory){
    $entrada = $factory->raw(App\Entrada::class);
    $entrada['estado_entrada_id'] = factory(App\EstadoEntrada::class)->create()->id;
    $entrada['proveedor_id'] = factory(App\Proveedor::class)->create()->id;
    $entrada['empleado_id'] = factory(App\Empleado::class)->create()->id;
    $entrada['sucursal_id'] = App\Caker::getSucursal()->id;
    return $entrada;
});

$factory->defineAs(App\Entrada::class, 'noempleado', function($faker) use ($factory){
    $entrada = $factory->raw(App\Entrada::class);
    $entrada['estado_entrada_id'] = factory(App\EstadoEntrada::class)->create()->id;
    $entrada['proveedor_id'] = factory(App\Proveedor::class)->create()->id;
    $entrada['razon_social_id'] = factory(App\RazonSocialEmisor::class, 'full')->create()->id;
    $entrada['sucursal_id'] = App\Caker::getSucursal()->id;
    return $entrada;
});

$factory->defineAs(App\Entrada::class, 'longfen', function($faker) use ($factory){
    $entrada = $factory->raw(App\Entrada::class);
    $entrada['factura_externa_numero'] = $faker->regexify('[a]{50}');
    return $entrada;
});

$factory->defineAs(App\Entrada::class, 'longmoneda', function($faker) use ($factory){
    $entrada = $factory->raw(App\Entrada::class);
    $entrada['moneda'] = $faker->regexify('[a]{50}');
    return $entrada;
});
