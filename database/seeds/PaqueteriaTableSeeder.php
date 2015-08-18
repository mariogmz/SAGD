<?php

use Illuminate\Database\Seeder;

class PaqueteriaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 'clave', 'nombre', 'url', 'horario', 'condicion_entrega', 'seguro'
        $data = [
            ['REDD', 'REDPACK', 'www.redpack.com.mx', '', 'ENTREGA DE 2 A 4 DIAS HABILES EN LAS PRINCIPALES CIUDADES, PUEDE VARIAR PARA POBLADOS LEJANOS.', 2],
            ['CASS', 'CARSSA', 'www.carssa.com.mx', '', '', 2.5],
            ['STFT', 'ESTAFETA', 'www.estafeta.com.mx', '9-100', 'ENTREGA DE 2 A 5 DIAS, EN LAS PRINCIPALES CIUDADES PUEDE VARIAR PARA POBLADOS LEJANOS', 1.5],
            ['SMU', 'Servicio de Mensajería Urgente', 'www.mensajeriaurgente.com.mx', 'HORARIOS SMU', 'PAQUETERIA REGIONAL, NO ASEGURA PRODUCTO, EL RIESGO ES DEL CLIENTE, EFICIENCIA DE 99% DE ACUERDO A NUESTRA EXPERIENCIA', 0],
            ['ESTIM', 'ESTAFETA -IM', 'www.estafeta.com.mx', '', 'ENTREGA DE 2 A 5 DIAS, EN LAS PRINCIPALES CIUDADES PUEDE VARIAR PARA POBLADOS LEJANOS', 1.4],
            ['IM-AR', 'Enviar a sucursal Ags-Arboledas (2 a 4 días hábiles a partir del anticipo)', '', '', 'Se entrega en sucursal Arboledas de (2 a 4 días hábiles a partir del anticipo)', 0],
            ['ESTDIASIG', 'ESTAFETA', '', 'www.estafeta.com.mx', '', 1.5]
        ];
        foreach ($data as $paqueteria) {
            DB::table('paqueterias')->insert([
                'clave' => $paqueteria[0],
                'nombre' => $paqueteria[1],
                'url' => $paqueteria[2],
                'horario' => $paqueteria[3],
                'condicion_entrega' => $paqueteria[4],
                'seguro' => $paqueteria[5],
            ]);
        }
    }
}
