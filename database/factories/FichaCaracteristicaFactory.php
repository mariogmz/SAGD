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

$factory->define(App\FichaCaracteristica::class, function ($faker) {
    return [
        'ficha_id'        => factory(App\Ficha::class)->create()->id,
        'category_feature_id'   => factory(App\IcecatCategoryFeature::class)->create()->id,
        'valor'              => $faker->text(60),
        'valor_presentacion' => $faker->text(60)
    ];
});

$factory->defineAs(App\FichaCaracteristica::class, 'valorLargo', function ($faker) use ($factory) {
    return array_merge($factory->raw(App\FichaCaracteristica::class),[
        'valor' => $faker->text(300)
    ]);
});

$factory->defineAs(App\FichaCaracteristica::class, 'valorPresentacionLargo', function ($faker) use ($factory) {
    return array_merge($factory->raw(App\Ficha::class),[
        'valor_presentacion' => $faker->text(300)
    ]);
});
