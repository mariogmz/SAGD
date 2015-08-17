<?php

use Illuminate\Database\Seeder;

class TipoPartidaTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        foreach ($this->prepararDatos() as $tipo_partida) {
            $nuevo_tipo_partida = new App\TipoPartida($tipo_partida);
            if (!$nuevo_tipo_partida->save()) {
                // Errors
            }
        }
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
                'clave'       => 'PAGO',
                'nombre'      => 'PAGO',
                'ticket'      => 0,
                'ticket_suma' => 0,
                'pago'        => 1
            ], [
                'clave'       => 'VALERMA',
                'nombre'      => 'CANJE DE VALE POR UN RMA',
                'ticket'      => 1,
                'ticket_suma' => 0,
                'pago'        => 1
            ], [
                'clave'       => 'TDEBITO',
                'nombre'      => 'PAGO CON TARJETA DE DEBITO',
                'ticket'      => 0,
                'ticket_suma' => 0,
                'pago'        => 1
            ], [
                'clave'       => 'TCREDITO',
                'nombre'      => 'PAGO CON TARJETA DE CREDITO',
                'ticket'      => 0,
                'ticket_suma' => 0,
                'pago'        => 1
            ], [
                'clave'       => 'COMISION',
                'nombre'      => 'COMISION GENERADA POR METODO DE PAGO',
                'ticket'      => 1,
                'ticket_suma' => 1,
                'pago'        => 0
            ], [
                'clave'       => 'COMISIONABSORCION',
                'nombre'      => 'ABSORCION DE COMISION GENERADA POR METODO DE PAGO',
                'ticket'      => 1,
                'ticket_suma' => 0,
                'pago'        => 1
            ], [
                'clave'       => 'SOPORTE',
                'nombre'      => 'SERVICIO DE SOPORTE TECNICO',
                'ticket'      => 1,
                'ticket_suma' => 1,
                'pago'        => 0
            ], [
                'clave'       => 'ANTICIPO',
                'nombre'      => 'COBRO DE ANTICIPO',
                'ticket'      => 1,
                'ticket_suma' => 1,
                'pago'        => 0
            ], [
                'clave'       => 'ANTICIPOPAGO',
                'nombre'      => 'PAGO CON ANTICIPO',
                'ticket'      => 1,
                'ticket_suma' => 0,
                'pago'        => 1
            ], [
                'clave'       => 'NOTACREDITO',
                'nombre'      => 'PAGO CON NOTA DE CREDITO',
                'ticket'      => 0,
                'ticket_suma' => 0,
                'pago'        => 1
            ], [
                'clave'       => 'FLETE',
                'nombre'      => 'FLETE',
                'ticket'      => 1,
                'ticket_suma' => 1,
                'pago'        => 0
            ], [
                'clave'       => 'FLETESEGURO',
                'nombre'      => 'COSTO GENERADO POR SEGURO DE FLETE',
                'ticket'      => 1,
                'ticket_suma' => 1,
                'pago'        => 0
            ], [
                'clave'       => 'ANTICIPOPAGO',
                'nombre'      => 'PAGO CON ANTICIPO',
                'ticket'      => 1,
                'ticket_suma' => 0,
                'pago'        => 1
            ],
        ];

        return $tipos_partidas;
    }
}
