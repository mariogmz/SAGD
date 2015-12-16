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

$factory->define(App\IcecatCategoryFeature::class, function ($faker) {
    return [
        'icecat_id'                        => $faker->randomNumber(8),
        'icecat_category_feature_group_id' => factory(App\IcecatCategoryFeatureGroup::class)->create()->icecat_id,
        'icecat_category_id'               => factory(App\IcecatCategory::class)->create()->icecat_id,
        'icecat_feature_id'                => factory(App\IcecatFeature::class)->create()->icecat_id
    ];
});
