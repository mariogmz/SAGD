<?php

use Illuminate\Database\Seeder;

class EstadoSoporteTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        foreach($this->prepararDatos() as $estado){
            App\EstadoSoporte::create($estado);
        }
    }

    private function prepararDatos() {
        return  [
            [
                'clave'  => 'RECIBE',
                'nombre' => 'Producto o equipo recibido.'
            ], [
                'clave'  => 'REVISA',
                'nombre' => 'En servicio, revisando.'
            ], [
                'clave'  => 'REPARA',
                'nombre' => 'En servicio, realizando reparaciones.'
            ], [
                'clave'  => 'DEVUEL',
                'nombre' => 'No se puede realizar el servicio, equipo o producto fuera de cobertura de garantía, esperando a cliente para información.'
            ], [
                'clave'  => 'ENTREG',
                'nombre' => 'Equipo o producto reparado, esperando a cliente para entrega.'
            ], [
                'clave'  => 'COBRAD',
                'nombre' => 'Servicio cobrado y entregado a cliente.'
            ],
        ];
    }
}
