<?php

use Illuminate\Database\Seeder;

class UnidadTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        //
        DB::table('unidades')->insert(['clave' => 'PZA', 'nombre' => 'Pieza']);
    }
}
