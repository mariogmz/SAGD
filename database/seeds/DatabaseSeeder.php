<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Model::unguard();

        $this->call(EstatusActivoTableSeeder::class);
        $this->call(EstadoVentaTableSeeder::class);
        $this->call(EstatusVentaTableSeeder::class);
        $this->call(MetodoPagoTableSeeder::class);
        $this->call(MetodoPagoRangoTableSeeder::class);
        $this->call(TipoPartidaTableSeeder::class);
        $this->call(TipoVentaTableSeeder::class);
        $this->call(CodigoPostalTableSeeder::class);
        $this->call(ProveedorTableSeeder::class);
        $this->call(SucursalTableSeeder::class);
        $this->call(TelefonoTableSeeder::class);
        $this->call(EstadoSoporteTableSeeder::class);
        $this->call(EstadoRmaTableSeeder::class);
        $this->call(RmaTiempoTableSeeder::class);
        $this->call(EstadoApartadoTableSeeder::class);
        $this->call(EstadoEntradaTableSeeder::class);
        $this->call(EstadoSalidaTableSeeder::class);
        $this->call(EstadoTransferenciaTableSeeder::class);
        $this->call(ClienteEstatusTableSeeder::class);
        $this->call(ClienteReferenciaTableSeeder::class);
        $this->call(PaqueteriaTableSeeder::class);
        $this->call(PaqueteriaCoberturaTableSeeder::class);
        $this->call(ZonaTableSeeder::class);
        $this->call(GuiaTableSeeder::class);
        $this->call(GuiaZonaTableSeeder::class);
        $this->call(PaqueteriaRangoTableSeeder::class);
        $this->call(MarcaTableSeeder::class);
        $this->call(TipoGarantiaTableSeeder::class);
        $this->call(UnidadTableSeeder::class);
        $this->call(MargenTableSeeder::class);
        $this->call(FamiliaTableSeeder::class);
        $this->call(SubfamiliaTableSeeder::class);

        Model::reguard();
    }
}
