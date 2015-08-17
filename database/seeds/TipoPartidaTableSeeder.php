<?php

use Illuminate\Database\Seeder;

class TipoPartidaTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $this->prepararDatos();
    }

    private function prepararDatos() {
        $tipos_partidas = [
            [
                'clave'       => 'PRODUCTO',
                'nombre'      => 'PRODUCTO',
                'ticket'      => 1,
                'ticket_suma' => 1,
                'pago'        => 0
            ], [
                'clave'       => 'VALERMA',
                'nombre'      => 'CANJE DE VALE POR UN RMA',
                'ticket'      => 1,
                'ticket_suma' => 1,
                'pago'        => 0
            ],
        ];
    }
}
