<?php

use Illuminate\Database\Seeder;

class EstadoSalidaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(App\EstadoSalida::class)->create(['nombre' => 'Creando']);
        factory(App\EstadoSalida::class)->create(['nombre' => 'Cargando']);
        factory(App\EstadoSalida::class)->create(['nombre' => 'Cargado']);
    }
}
