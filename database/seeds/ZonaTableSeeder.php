<?php

use Illuminate\Database\Seeder;

class ZonaTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        //
        DB::table('zonas')->insert(['clave' => 'ZONA1', 'km_maximos' => 0.0]);
        DB::table('zonas')->insert(['clave' => 'ZONA2', 'km_maximos' => 0.0]);
        DB::table('zonas')->insert(['clave' => 'ZONA3', 'km_maximos' => 0.0]);
        DB::table('zonas')->insert(['clave' => 'ZONA4', 'km_maximos' => 0.0]);
        DB::table('zonas')->insert(['clave' => 'ZONA5', 'km_maximos' => 0.0]);
        DB::table('zonas')->insert(['clave' => 'ZONA6', 'km_maximos' => 0.0]);
        DB::table('zonas')->insert(['clave' => 'ZONA7', 'km_maximos' => 0.0]);
    }
}
