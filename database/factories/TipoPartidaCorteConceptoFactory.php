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

$factory->define(App\TipoPartidaCorteConcepto::class, function ($faker) {
    return [
        'tipo_partida_id'   => factory(App\TipoPartida::class)->create()->id,
        'corte_concepto_id' => factory(App\CorteConcepto::class)->create()->id
    ];
});
