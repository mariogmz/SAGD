<?php

$factory->define(App\LogAcceso::class, function ($faker)
{
    return [
        'empleado_id' => 'required|numeric',
        'exitoso'     => 'required|boolean'
    ];
});
