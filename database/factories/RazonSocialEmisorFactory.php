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

$factory->define(App\RazonSocialEmisor::class, function ($faker)
{
    return [
        'rfc' => $faker->regexify('[A-Z]{4}\d{6}[A-Z]\d{2}'),
        'regimen' => $faker->text(60),
        'serie' => $faker->regexify('[A-Z]{3}'),
        'ultimo_folio' => $faker->unique()->randomNumber(4),
        'numero_certificado' => $faker->unique()->randomNumber(8),
        'numero_certificado_sat' => $faker->unique()->randomNumber(8),
    ];
});

$factory->defineAs(App\RazonSocialEmisor::class, 'full', function($faker) use ($factory){
    $rse = $factory->raw(App\RazonSocialEmisor::class);
    $rse['sucursal_id'] = factory(App\Sucursal::class)->create()->id;
    $rse['domicilio_id'] = factory(App\Domicilio::class)->create()->id;
    return $rse;
});

$factory->defineAs(App\RazonSocialEmisor::class, 'longregimen', function($faker) use ($factory){
    $rse = $factory->raw(App\RazonSocialEmisor::class);
    $rse['regimen'] = $faker->regexify('[a]{61}');
    return $rse;
});
