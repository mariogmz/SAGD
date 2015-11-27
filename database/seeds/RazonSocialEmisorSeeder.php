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
            'rfc' => 'DMT0911105L5',
            'razon_social' => 'DICOTECH MAYORISTAS DE TECNOLOGIA S.A. DE C.V.',
            'serie' => 'B',
            'ultimo_folio' => 82757,
            'numero_certificado' => 1,
            'numero_certificado_sat' => 1,
            'domicilio_id' => $domicilio_id
        ]);

        $rseJorge = new App\RazonSocialEmisor([
            'sucursal_id' => $sucursal->id,
            'rfc' => 'ZEGJ790704QK4',
            'razon_social' => 'JORGE HUMBERTO ZERMEÑO GUTIERREZ',
            'serie' => 'AR',
            'ultimo_folio' => 84124,
            'numero_certificado' => 1,
            'numero_certificado_sat' => 1,
            'domicilio_id' => $domicilio_id
        ]);

        $rseDicotech->save();
        $rseJorge->save();
    }
}
