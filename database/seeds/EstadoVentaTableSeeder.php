<?php

use Illuminate\Database\Seeder;

class EstadoVentaTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $estados = [
            [
                'clave'  => 'A',
                'nombre' => 'Requiere transferencia de productos desde otras sucursales.'
            ], [
                'clave'  => 'B',
                'nombre' => 'No requiere transferencia de productos desde otras sucursales, venta de mostrador.'
            ], [
                'clave'  => 'C',
                'nombre' => 'Requiere transferencia de productos desde otras sucursales, envío a domicilio.'
            ], [
                'clave'  => 'D',
                'nombre' => 'No requiere transferencia de productos desde otras sucursales, envío a domicilio.'
            ],
        ];
        foreach ($estados as $estado) {
            $st = new App\EstadoVenta($estado);
            if (!$st->save()) {
                print_r($st->errors);
            }
        }
    }
}
