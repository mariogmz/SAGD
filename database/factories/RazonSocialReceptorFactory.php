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

$factory->define(App\RazonSocialReceptor::class, function ($faker)
{
    return [
        'rfc' => $faker->regexify('[A-Z]{4}\d{6}[A-Z]\d{2}'),
        'regimen' => $faker->text(60),
        'domicilio_id' => $faker->randomDigit,
        'cliente_id' => $faker->randomDigit
    ];
});

$factory->defineAs(App\RazonSocialReceptor::class, 'full', function($faker) use ($factory){
    $rsr = $factory->raw(App\RazonSocialReceptor::class);
    $rsr['domicilio_id'] = factory(App\Domicilio::class)->create()->id;
    $rsr['cliente_id'] = factory(App\Cliente::class, 'full')->create()->id;
    return $rsr;
});

$factory->defineAs(App\RazonSocialReceptor::class, 'longregimen', function($faker) use ($factory){
    $rsr = $factory->raw(App\RazonSocialReceptor::class);
    $rsr['regimen'] = $faker->regexify('[a]{61}');
    return $rsr;
});
