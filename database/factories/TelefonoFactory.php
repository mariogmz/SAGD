<?php

$factory->define(App\Telefono::class, function ($faker) {
    while(empty($domicilio_id = factory(App\Domicilio::class)->create()->id));
    return [
        'numero'       => App\Caker::realUnique(App\Telefono::class, 'numero', 'regexify', '\d{7,12}'),
        'tipo'         => $faker->word,
        'domicilio_id' => $domicilio_id
    ];
});
