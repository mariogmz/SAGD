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
         * Definicion de status:
         * 1 => Abierta.                    Puede editarse y cargarse
         * 2 => Cargando Local.             En proceso de carga, no puede editarse
         * 3 => Cargada Local.              La carga se realizo con exito, no puede editarse
         * 4 => Iniciando Transferencia.
         * 5 => Transferencia Terminada.    Lista Para Cargarse Sucursal Destino
         * 6 => Cargando Otra Sucursal.     En proceso de carga en otra sucursal
         * 7 => Cargada Otra Sucursal.      Indica que se realizo la carga exitosamente
         */
        App\EstadoTransferencia::create(['nombre' => 'Abierta']);
        App\EstadoTransferencia::create(['nombre' => 'Cargando Local']);
        App\EstadoTransferencia::create(['nombre' => 'Cargada Local']);
        App\EstadoTransferencia::create(['nombre' => 'Iniciando Transferencia']);
        App\EstadoTransferencia::create(['nombre' => 'Transferencia Terminada']);
        App\EstadoTransferencia::create(['nombre' => 'Cargando Otra Sucursal']);
        App\EstadoTransferencia::create(['nombre' => 'Cargada Otra Sucursal']);
    }
}
