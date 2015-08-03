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
        'estatus' => $faker->unique()->text(45)
    ];
});

$factory->defineAs(App\EstatusActivo::class, 'estatuslargo', function ($faker) use ($factory){
    return [
        'estatus' => $faker->unique()->text(100)
    ];
});
