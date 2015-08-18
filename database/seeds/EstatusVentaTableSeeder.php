<?php

use Illuminate\Database\Seeder;

class EstatusVentaTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $estatus = [
            'Agregar productos.',
            'Escanear productos.',
            'Agregar productos desde el carrito',
            'Seleccionar sucursal',
            'Establecer dirección de envío.',
            'Seleccionar flete.',
            'Agregar monto del seguro para flete',
            'Cálculo final de flete más costo de transferencia de productos desde filial.',
            'Elegir tipo de pago.',
            'Tipo de pago no procede.',
            'Cobrar.',
            'Pedir transferencia de productos desde otras sucursales.',
            'Surtir.',
            'Entregar productos en mostrador.',
            'Verificar datos.',
            'Surtir pedido.',
            'Enviar pedido por paquetería.',
            'Finalizar venta',
            'Venta finalizada'
        ];
        foreach ($estatus as $st) {
            App\EstatusVenta::create(['nombre' => $st]);
        }
    }
}
