<?php

use Illuminate\Database\Seeder;

class EstadoFacturaTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $estados_factura = [
            'Borrador',
            'Aprobada',
            'Cobrada',
            'Parcialmente cobrada',
            'Cancelada'
        ];
        foreach ($estados_factura as $estado_factura) {
            $nuevo_estado_factura = new App\EstadoFactura([
                'nombre' => $estado_factura
            ]);
            if (!$nuevo_estado_factura->save()) {
                // Errors
            }
        }
    }
}
