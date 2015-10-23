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

$factory->define(App\Producto::class, function ($faker) {
    $marca = App\Marca::first();
    $marca = empty($marca) ? factory(App\Marca::class)->create() : $marca;

    return [
        'activo'           => $faker->boolean,
        'clave'            => App\Caker::realUnique(App\Producto::class, 'clave', 'regexify', '\w{60}'),
        'descripcion'      => $faker->text(300),
        'fecha_entrada'    => $faker->dateTime,
        'numero_parte'     => App\Caker::realUnique(App\Producto::class, 'numero_parte', 'regexify', '\w{20}'),
        'remate'           => $faker->boolean,
        'spiff'            => $faker->randomFloat(2, 0.0, 999999.9),
        'subclave'         => $faker->text(45),
        'upc'              => App\Caker::realUnique(App\Producto::class, 'upc', 'regexify', '\d{8}'),
        'tipo_garantia_id' => factory(App\TipoGarantia::class)->create()->id,
        'marca_id'         => $marca->id,
        'unidad_id'        => factory(App\Unidad::class)->create()->id,
        'subfamilia_id'    => factory(App\Subfamilia::class)->create()->id
    ];
});

$factory->defineAs(App\Producto::class, 'withmargen', function ($faker) use ($factory) {
    $producto = $factory->raw(App\Producto::class);

    return array_merge($producto, ['margen_id' => factory(App\Margen::class)->create()->id]);
});

$factory->defineAs(App\Producto::class, 'withshortdescription', function ($faker) use ($factory) {
    $producto = $factory->raw(App\Producto::class);

    return array_merge($producto, ['descripcion_corta' => $faker->text(50),]);
});

$factory->defineAs(App\Producto::class, 'longclave', function ($faker) use ($factory) {
    $producto = $factory->raw(App\Producto::class);
    $producto['clave'] = $faker->text . $faker->text;

    return $producto;
});

$factory->defineAs(App\Producto::class, 'longdescription', function ($faker) use ($factory) {
    $producto = $factory->raw(App\Producto::class);
    $producto['descripcion'] = $faker->regexify('a{301}');

    return $producto;
});

$factory->defineAs(App\Producto::class, 'longshortdesc', function ($faker) use ($factory) {
    $producto = $factory->raw(App\Producto::class);
    $producto['descripcion_corta'] = $faker->regexify('a{51}');

    return $producto;
});

$factory->defineAs(App\Producto::class, 'longnumpart', function ($faker) use ($factory) {
    $producto = $factory->raw(App\Producto::class);
    $producto['numero_parte'] = $faker->regexify('\w{50}');

    return $producto;
});
