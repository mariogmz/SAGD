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

$factory->define(App\Subfamilia::class, function ($faker) {
    return [
        'clave' => $faker->regexify('[A-Z]{4}'),
        'nombre' => $faker->word,
        'familia_id' => factory(App\Familia::class)->create()->id,
        'margen_id' => factory(App\Margen::class)->create()->id,
    ];
});

$factory->defineAs(App\Subfamilia::class, 'lowerclave', function ($faker) use ($factory) {
    return [
        'clave' => $faker->regexify('[a-z]{4}'),
        'nombre' => $faker->word,
        'familia_id' => factory(App\Familia::class)->create()->id,
        'margen_id' => factory(App\Margen::class)->create()->id,
    ];
});

$factory->defineAs(App\Subfamilia::class, 'longname', function ($faker) use ($factory) {
    return [
        'clave' => $faker->regexify('[A-Z]{4}'),
        'nombre' => $faker->text . $faker->text,
        'familia_id' => factory(App\Familia::class)->create()->id,
        'margen_id' => factory(App\Margen::class)->create()->id,
    ];
});
