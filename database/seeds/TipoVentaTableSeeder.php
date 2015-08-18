<?php

use Illuminate\Database\Seeder;

class TipoVentaTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        App\TipoVenta::create([
            'nombre' => 'Venta por página web'
        ]);
        App\TipoVenta::create([
            'nombre' => 'Venta de mostrador'
        ]);
    }
}
