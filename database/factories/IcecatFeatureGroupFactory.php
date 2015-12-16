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

$factory->define(App\IcecatFeatureGroup::class, function ($faker) {
    return [
        'icecat_id'   => $faker->randomNumber(8),
        'name'        => $faker->text(70),
    ];
});

$factory->defineAs(App\IcecatFeatureGroup::class, 'longname', function ($faker) use ($factory) {
    return array_merge(
        $factory->raw(App\IcecatFeatureGroup::class),
        ['name' => $faker->text(200)]
    );
});
