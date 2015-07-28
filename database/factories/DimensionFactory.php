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

$factory->define(App\Dimension::class, function ($faker) {
	return [
		'largo' => $faker->randomFloat(2, 0.0, 999.99),
		'ancho' => $faker->randomFloat(2, 0.0, 999.99),
		'alto' => $faker->randomFloat(2, 0.0, 999.99),
		'peso' => $faker->randomFloat(2, 0.0, 999.99),
		'producto_id' => factory(App\Producto::class)->create()->id
	];
});

$factory->defineAs(App\Dimension::class, 'emptyattr', function($faker) use ($factory){
	$dimension = $factory->raw(App\Dimension::class);
	$dimension['largo'] = '';
	$dimension['ancho'] = '';
	$dimension['alto'] = '';
	$dimension['peso'] = '';
	return $dimension;
});

$factory->defineAs(App\Dimension::class, 'negativeattr', function($faker) use ($factory){
	$dimension = $factory->raw(App\Dimension::class);
	$dimension['largo'] = -1.0;
	$dimension['ancho'] = -1.0;
	$dimension['alto'] = -1.0;
	$dimension['peso'] = -1.0;
	return $dimension;
});
