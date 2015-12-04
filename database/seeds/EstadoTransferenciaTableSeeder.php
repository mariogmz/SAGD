<?php

use Illuminate\Database\Seeder;

class EstadoTransferenciaTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        /**
         * Definicion de estados:
         *
         * 1 => Abierta
         * Se generó una pretransferencia y se imprimió la orden.
         * La transferencia es editable en todo excepto sucursales.
         *
         * 2 => Cargando Origen
         * Se empezaron a agregar detalles a la transferencia, es decir, se
         * estan escaneando los productos que van de salida.
         * La transferencia ya tiene quien la origino (el que está cargando
         * productos).
         *
         * 3 => En transferencia
         * Se marcó como cargada la transferencia. El proceso físico de enviar
         * al destino ocurre aquí. La transferencia no es editable en este
         * estado y el producto esta marcado como cantidad_transferencia en la
         * sucursal de origen.
         *
         * 4 => Cargando Destino
         * La mercancía (transferencia) llegó al destino y se encuentran
         * escaneando los productos para verificar que si llegaron todos.
         *
         * 5 => Finalizada
         * Cuando todos los productos de la transferencia esten contados y
         * verificados y las existencias se eliminaron del origen y ahora
         * se encuentran en las existencias del destino.
         * Es inmutable ambos transferencias y sus detalles ya que es el estado
         * final.
         */
        App\EstadoTransferencia::create(['nombre' => 'Abierta']);
        App\EstadoTransferencia::create(['nombre' => 'Cargando Origen']);
        App\EstadoTransferencia::create(['nombre' => 'En transferencia']);
        App\EstadoTransferencia::create(['nombre' => 'Cargando Destino']);
        App\EstadoTransferencia::create(['nombre' => 'Finalizada']);
    }
}
