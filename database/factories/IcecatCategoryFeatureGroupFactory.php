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

$factory->define(App\IcecatCategoryFeatureGroup::class, function ($faker) {
    $icecat_category_id = factory(App\IcecatCategory::class)->create()->icecat_id;
    $icecat_feature_group_id = factory(App\IcecatFeatureGroup::class)->create()->icecat_id;

    return [
        'icecat_id'               => $faker->randomNumber(8),
        'icecat_category_id'      => $icecat_category_id,
        'icecat_feature_group_id' => $icecat_feature_group_id
    ];
});
