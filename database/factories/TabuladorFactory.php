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

$factory->define(App\Tabulador::class, function ($faker) {
    $tabulador_inicial = $faker->numberBetween(1, 10);
    while(empty($sucursal_id = factory(App\Sucursal::class, 'interna')->create()->id));
    return [
        'valor'          => $tabulador_inicial,
        'valor_original' => $tabulador_inicial,
        'especial'       => $faker->boolean(),
        'cliente_id'     => factory(App\Cliente::class, 'full')->create()->id,
        'sucursal_id'    => $sucursal_id
    ];
});

$factory->defineAs(App\Tabulador::class, 'default', function($faker) use ($factory){
    while(empty($sucursal_id = factory(App\Sucursal::class, 'interna')->create()->id));
    return [
        'cliente_id'     => factory(App\Cliente::class, 'full')->create()->id,
        'sucursal_id'    => $sucursal_id
    ];
});
