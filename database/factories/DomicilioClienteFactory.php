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

$factory->define(App\DomicilioCliente::class, function ($faker) {
    while(empty($id = factory(App\Domicilio::class)->create()->id));
    return [
        'domicilio_id' => $id,
        'cliente_id'   => factory(App\Cliente::class, 'full')->create()->id
    ];
});
