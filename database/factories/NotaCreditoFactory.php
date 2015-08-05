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

$factory->define(App\NotaCredito::class, function ($faker)
{
    return [
        'folio' => $faker->regexify('[A-Z]{2}\d{10}-\d{3}'),
        'fecha_expedicion' => $faker->dateTime,
        'fecha_timbrado' => $faker->dateTime,
        'cadena_original_emisor' => $faker->regexify('\|\|[a-zA-Z0-9\-\|]{0,25}[a-zA-Z0-9\-\|]{0,25}[a-zA-Z0-9\-\|]{0,25}[a-zA-Z0-9\-\|]{0,25}[a-zA-Z0-9\-\|]{0,25}[a-zA-Z0-9\-\|]{0,25}[a-zA-Z0-9\-\|]{0,25}[a-zA-Z0-9\-\|]{0,25}[a-zA-Z0-9\-\|]{0,25}[a-zA-Z0-9\-]\|\|'),
        'cadena_original_receptor' => $faker->regexify('\|\|[a-zA-Z0-9\-\|]{0,25}[a-zA-Z0-9\-\|]{0,25}[a-zA-Z0-9\-\|]{0,25}[a-zA-Z0-9\-\|]{0,25}[a-zA-Z0-9\-\|]{0,25}[a-zA-Z0-9\-\|]{0,25}[a-zA-Z0-9\-\|]{0,25}[a-zA-Z0-9\-\|]{0,25}[a-zA-Z0-9\-\|]{0,25}[a-zA-Z0-9\-]\|\|'),
        'error_sat' => $faker->boolean,
        'forma_pago' => 'PAGO EN UNA SOLA EXHIBICION',
        'metodo_pago' => 'PAGO EN EFECTIVO',
        'numero_cuenta_pago' => $faker->regexify('\d{10}'),
        'sello_digital_emisor' => $faker->regexify('[a-zA-Z0-9\/\+]{40,255}==?'),
        'sello_digital_sat' => $faker->regexify('[a-zA-Z0-9\/\+]{40,255}==?'),
        'xml' => $faker->regexify('\<cfdi:sat [.]{255,650}\>'),
        'lugar_expedicion' => 'Aguascalientes, Aguascaliente. Mexico.',
        'razon_social_emisor_id' => $faker->randomDigit,
        'razon_social_receptor_id' => $faker->randomDigit,
        'factura_status_id' => $faker->randomDigit,
    ];
});

$factory->defineAs(App\NotaCredito::class, 'full', function($faker) use ($factory){
    $nc = $factory->raw(App\NotaCredito::class);
    $nc['razon_social_emisor_id'] = factory(App\RazonSocialEmisor::class, 'full')
        ->create()->id;
    $nc['razon_social_receptor_id'] = factory(App\RazonSocialReceptor::class, 'full')
        ->create()->id;
    $nc['factura_status_id'] = factory(App\EstadoFactura::class)->create()->id;
    return $nc;
});

$factory->defineAs(App\NotaCredito::class, 'longfolio', function($faker) use ($factory){
    $nc = $factory->raw(App\NotaCredito::class);
    $nc['folio'] = $faker->regexify('[a]{46}');
    return $nc;
});

$factory->defineAs(App\NotaCredito::class, 'longformadepago', function($faker) use ($factory){
    $nc = $factory->raw(App\NotaCredito::class);
    $nc['forma_pago'] = $faker->regexify('[a]{61}');
    return $nc;
});

$factory->defineAs(App\NotaCredito::class, 'longmetododepago', function($faker) use ($factory){
    $nc = $factory->raw(App\NotaCredito::class);
    $nc['metodo_pago'] = $faker->regexify('[a]{61}');
    return $nc;
});

$factory->defineAs(App\NotaCredito::class, 'longnumerocuenta', function($faker) use ($factory){
    $nc = $factory->raw(App\NotaCredito::class);
    $nc['numero_cuenta_pago'] = $faker->regexify('[a]{61}');
    return $nc;
});

$factory->defineAs(App\NotaCredito::class, 'longlugarexp', function($faker) use ($factory){
    $nc = $factory->raw(App\NotaCredito::class);
    $nc['lugar_expedicion'] = $faker->regexify('[a]{61}');
    return $nc;
});
