<?php

use Illuminate\Database\Seeder;

class ClienteEstatusTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        //
        factory(App\ClienteEstatus::class)->create(['nombre' => 'Nuevo']);
        factory(App\ClienteEstatus::class)->create(['nombre' => 'Activo']);
        factory(App\ClienteEstatus::class)->create(['nombre' => 'Inactivo']);
    }
}
