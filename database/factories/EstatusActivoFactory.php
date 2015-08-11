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

$factory->define(App\EstatusActivo::class, function ($faker)
{
    return [
        'estatus' => App\Caker::realUnique(App\EstatusActivo::class, 'estatus', 'regexify', '[a-zA-Z0-9\s]{0,45}')
    ];
});

$factory->defineAs(App\EstatusActivo::class, 'estatuslargo', function ($faker) use ($factory){
    return [
        'estatus' => App\Caker::realUnique(App\EstatusActivo::class, 'estatus', 'regexify', '\w{100}')
    ];
});
