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

$factory->define(App\IcecatSupplier::class, function ($faker) {
    return [
        'icecat_id' => $faker->randomNumber(8),
        'name'      => $faker->text(50),
        'logo_url'  => $faker->optional()->url
    ];
});

$factory->defineAs(App\IcecatSupplier::class, 'withBrand', function ($faker) use ($factory) {
    $marca = $factory(App\Marca::class)->create();

    return array_merge($factory->raw(App\IcecatSupplier::class),
        [
            'marca_id' => $marca->id
        ]);
});
