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

$factory->define(App\RazonSocialEmisor::class, function ($faker) {
    return [
        'rfc'                    => $faker->regexify('[A-Z]{4}\d{6}[A-Z]\d{2}'),
        'regimen'                => $faker->text(60),
        'serie'                  => $faker->regexify('[A-Z]{3}'),
        'ultimo_folio'           => App\Caker::realUnique(App\RazonSocialEmisor::class, 'ultimo_folio', 'regexify', '[1-9]\d{3}'),
        'numero_certificado'     => App\Caker::realUnique(App\RazonSocialEmisor::class, 'numero_certificado', 'regexify', '[1-9]\d{7}'),
        'numero_certificado_sat' => App\Caker::realUnique(App\RazonSocialEmisor::class, 'numero_certificado_sat', 'regexify', '[1-9]\d{7}'),
    ];
});

$factory->defineAs(App\RazonSocialEmisor::class, 'full', function ($faker) use ($factory) {
    $rse = $factory->raw(App\RazonSocialEmisor::class);
    $rse['sucursal_id'] = App\Caker::getSucursal()->id;
    $rse['domicilio_id'] = factory(App\Domicilio::class)->create()->id;

    return $rse;
});

$factory->defineAs(App\RazonSocialEmisor::class, 'longregimen', function ($faker) use ($factory) {
    $rse = $factory->raw(App\RazonSocialEmisor::class);
    $rse['regimen'] = $faker->regexify('[a]{61}');

    return $rse;
});
