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

$factory->define(App\Cliente::class, function ($faker)
{
    return [
        'email' => $faker->email,
        'usuario' => $faker->userName,
        'password' => $faker->regexify('[a-fA-F0-9]{64}'),
        'nombre' => $faker->name,
        'fecha_nacimiento' => $faker->dateTime,
        'sexo' => $faker->regexify('(HOMBRE|MUJER)'),
        'ocupacion' => $faker->bs,
        'fecha_verificacion_correo' => $faker->dateTime,
        'fecha_expira_club_zegucom' => $faker->dateTime,
        'referencia_otro' => $faker->text(50),
        'rol_id' => factory(App\Rol::class)->create()->id,
        'access_token' => $faker->regexify('[a-fA-F0-9]{20}')
    ];
});

$factory->defineAs(App\Cliente::class, 'longemail', function($faker) use ($factory){
    $cliente = $factory->raw(App\Cliente::class);
    $cliente['email'] = $faker->regexify('[a]{40}\@gmail\.com');
    return $cliente;
});

$factory->defineAs(App\Cliente::class, 'longusername', function($faker) use ($factory){
    $cliente = $factory->raw(App\Cliente::class);
    $cliente['usuario'] = $faker->regexify('[a]{21}');
    return $cliente;
});

$factory->defineAs(App\Cliente::class, 'longpassword', function($faker) use ($factory){
    $cliente = $factory->raw(App\Cliente::class);
    $cliente['password'] = $faker->regexify('[a]{61}');
    return $cliente;
});

$factory->defineAs(App\Cliente::class, 'shortpassword', function($faker) use ($factory){
    $cliente = $factory->raw(App\Cliente::class);
    $cliente['password'] = $faker->regexify('[a]{1}');
    return $cliente;
});

$factory->defineAs(App\Cliente::class, 'longname', function($faker) use ($factory){
    $cliente = $factory->raw(App\Cliente::class);
    $cliente['nombre'] = $faker->regexify('[a]{201}');
    return $cliente;
});

$factory->defineAs(App\Cliente::class, 'longocc', function($faker) use ($factory){
    $cliente = $factory->raw(App\Cliente::class);
    $cliente['ocupacion'] = $faker->regexify('[a]{50}');
    return $cliente;
});

$factory->defineAs(App\Cliente::class, 'longref', function($faker) use ($factory){
    $cliente = $factory->raw(App\Cliente::class);
    $cliente['referencia_otro'] = $faker->regexify('[a]{51}');
    return $cliente;
});

$factory->defineAs(App\Cliente::class, 'full', function($faker) use ($factory){
    $cliente = $factory->raw(App\Cliente::class);
    $cliente = array_merge($cliente, [
        'cliente_estatus_id' => factory(App\ClienteEstatus::class)->create()->id,
        'cliente_referencia_id' => factory(App\ClienteReferencia::class)->create()->id,
        'sucursal_id' => factory(App\Sucursal::class)->create()->id,
    ]);
    return $cliente;
});
