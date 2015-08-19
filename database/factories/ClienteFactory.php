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

$factory->define(App\Cliente::class, function ($faker) {
    return [
        'usuario'                   => App\Caker::realUnique(App\Cliente::class, 'usuario', 'userName'),
        'nombre'                    => $faker->name,
        'fecha_nacimiento'          => $faker->dateTime,
        'sexo'                      => $faker->regexify('(HOMBRE|MUJER)'),
        'ocupacion'                 => $faker->bs,
        'fecha_verificacion_correo' => $faker->dateTime,
        'fecha_expira_club_zegucom' => $faker->dateTime,
        'referencia_otro'           => $faker->text(50),
        'rol_id'                    => factory(App\Rol::class)->create()->id,
        'cliente_estatus_id'        => $faker->randomDigit,
        'sucursal_id'               => $faker->randomDigit,
        'cliente_referencia_id'     => $faker->randomDigit,
    ];
});

$factory->defineAs(App\Cliente::class, 'longusername', function ($faker) use ($factory) {
    $cliente = $factory->raw(App\Cliente::class);
    $cliente['usuario'] = App\Caker::realUnique(App\Cliente::class, 'usuario', 'regexify', '[a]{21}');

    return $cliente;
});

$factory->defineAs(App\Cliente::class, 'longname', function ($faker) use ($factory) {
    $cliente = $factory->raw(App\Cliente::class);
    $cliente['nombre'] = $faker->regexify('[a]{201}');

    return $cliente;
});

$factory->defineAs(App\Cliente::class, 'longocc', function ($faker) use ($factory) {
    $cliente = $factory->raw(App\Cliente::class);
    $cliente['ocupacion'] = $faker->regexify('[a]{50}');

    return $cliente;
});

$factory->defineAs(App\Cliente::class, 'longref', function ($faker) use ($factory) {
    $cliente = $factory->raw(App\Cliente::class);
    $cliente['referencia_otro'] = $faker->regexify('[a]{51}');

    return $cliente;
});

$factory->defineAs(App\Cliente::class, 'full', function ($faker) use ($factory) {
    $cliente = $factory->raw(App\Cliente::class);
    $cliente = array_merge($cliente, [
        'cliente_estatus_id'    => factory(App\ClienteEstatus::class)->create()->id,
        'cliente_referencia_id' => factory(App\ClienteReferencia::class)->create()->id,
        'sucursal_id'           => App\Caker::getSucursal()->id,
    ]);

    return $cliente;
});
