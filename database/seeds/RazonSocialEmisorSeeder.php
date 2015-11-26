<?php

use Illuminate\Database\Seeder;

class RazonSocialEmisorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sucursal = App\Sucursal::where('clave', 'DICOTAGS')->first();
        $domicilio_id = $sucursal->domicilio_id;

        $rseDicotech = new App\RazonSocialEmisor([
            'sucursal_id' => $sucursal->id,
            'rfc' => 'ABCD123456X00',
            'razon_social' => 'Dicotech',
            'serie' => 'AAA',
            'ultimo_folio' => 0,
            'numero_certificado' => 1,
            'numero_certificado_sat' => 1,
            'domicilio_id' => $domicilio_id
        ]);

        $rseJorge = new App\RazonSocialEmisor([
            'sucursal_id' => $sucursal->id,
            'rfc' => 'ABCD123456X00',
            'razon_social' => 'Jorge',
            'serie' => 'AAA',
            'ultimo_folio' => 0,
            'numero_certificado' => 1,
            'numero_certificado_sat' => 1,
            'domicilio_id' => $domicilio_id
        ]);

        $rseDicotech->save();
        $rseJorge->save();
    }
}
