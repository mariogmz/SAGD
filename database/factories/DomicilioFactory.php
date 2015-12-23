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

$factory->define(App\Domicilio::class, function ($faker) {
    while(empty($codigo_postal_id = factory(App\CodigoPostal::class)->create()->id));
    return [
        'calle'            => $faker->text(45),
        'localidad'        => $faker->word,
        'codigo_postal_id' => $codigo_postal_id,
    ];
});
