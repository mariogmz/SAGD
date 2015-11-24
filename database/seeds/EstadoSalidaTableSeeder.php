<?php

use Illuminate\Database\Seeder;

class EstadoSalidaTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $estadoSalidaCreando = new App\EstadoSalida(['nombre' => 'Creando']);
        $estadoSalidaCargando = new App\EstadoSalida(['nombre' => 'Cargando']);
        $estadoSalidaCargado = new App\EstadoSalida(['nombre' => 'Cargado']);

        $estadoSalidaCreando->save();
        $estadoSalidaCargando->save();
        $estadoSalidaCargado->save();
    }
}
