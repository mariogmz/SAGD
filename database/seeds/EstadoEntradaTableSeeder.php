<?php

use Illuminate\Database\Seeder;

class EstadoEntradaTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        //
        factory(App\EstadoEntrada::class)->create(['nombre' => 'Creando']);
        factory(App\EstadoEntrada::class)->create(['nombre' => 'Cargando']);
        factory(App\EstadoEntrada::class)->create(['nombre' => 'Cargado']);
    }
}
