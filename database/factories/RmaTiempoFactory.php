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

$factory->define(App\RmaTiempo::class, function ($faker) {
    return [
        'nombre' => App\Caker::realUnique(App\RmaTiempo::class, 'nombre', 'regexify', '[a-zA-Z0-9]{45}')
    ];
});

$factory->defineAs(App\RmaTiempo::class, 'nombrelargo', function ($faker) use ($factory) {
    return [
        'nombre' => App\Caker::realUnique(App\RmaTiempo::class, 'nombre', 'regexify', '\w{100}')
    ];
});
