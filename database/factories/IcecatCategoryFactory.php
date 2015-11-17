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

$factory->define(App\IcecatCategory::class, function ($faker) {
    return [
        'icecat_id'   => $faker->randomNumber(8),
        'name'        => $faker->text(100),
        'description' => $faker->optional()->text(300),
        'keyword'     => $faker->optional()->text(100)
    ];
});

$factory->defineAs(App\IcecatCategory::class, 'withParent', function ($faker) use ($factory) {
    return array_merge(
        $factory->raw(App\IcecatCategory::class),
        ['icecat_parent_category_id' => factory(App\IcecatCategory::class)->create()->id]
    );
});

$factory->defineAs(App\IcecatCategory::class, 'longname', function ($faker) use ($factory) {
    return array_merge(
        $factory->raw(App\IcecatCategory::class),
        ['name' => $faker->text(200)]
    );
});

$factory->defineAs(App\IcecatCategory::class, 'longdescription', function ($faker) use ($factory) {
    return array_merge(
        $factory->raw(App\IcecatCategory::class),
        ['description' => $faker->text(400)]
    );
});

$factory->defineAs(App\IcecatCategory::class, 'longkeyword', function ($faker) use ($factory) {
    return array_merge(
        $factory->raw(App\IcecatCategory::class),
        ['keyword' => $faker->text(200)]
    );
});
