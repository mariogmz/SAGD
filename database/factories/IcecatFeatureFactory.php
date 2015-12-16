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

$factory->define(App\IcecatFeature::class, function ($faker) {
    return [
        'icecat_id'   => $faker->randomNumber(8),
        'type'        => $faker->optional()->text(45),
        'name'        => $faker->text(70),
        'description' => $faker->optional()->text(100),
        'measure'     => $faker->optional()->text(10)
    ];
});

$factory->defineAs(App\IcecatFeature::class, 'longtype', function ($faker) use ($factory) {
    return array_merge(
        $factory->raw(App\IcecatFeature::class),
        ['type' => $faker->text(100)]
    );
});

$factory->defineAs(App\IcecatFeature::class, 'longname', function ($faker) use ($factory) {
    return array_merge(
        $factory->raw(App\IcecatFeature::class),
        ['name' => $faker->text(200)]
    );
});

$factory->defineAs(App\IcecatFeature::class, 'longdescription', function ($faker) use ($factory) {
    return array_merge(
        $factory->raw(App\IcecatFeature::class),
        ['description' => $faker->text(200)]
    );
});

$factory->defineAs(App\IcecatFeature::class, 'longmeasure', function ($faker) use ($factory) {
    return array_merge(
        $factory->raw(App\IcecatFeature::class),
        ['measure' => $faker->text(20)]
    );
});

