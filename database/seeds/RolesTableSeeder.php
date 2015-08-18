<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        foreach ($this->prepararDatos() as $rol) {
            $nuevo_rol = new App\Rol($rol);
            if (!$nuevo_rol->save()) {
                // Errors
            }
        }
    }

    private function prepararDatos() {
        return [
            [
                'clave'  => 'GERGEN',
                'nombre' => 'GERENTE GENERAL',
            ], [
                'clave'  => 'GERSUC',
                'nombre' => 'GERENTE DE SUCURSAL',
            ], [
                'clave'  => 'ALMACE',
                'nombre' => 'ALMACENISTA',
            ], [
                'clave'  => 'VENTAS',
                'nombre' => 'PERSONAL DE VENTAS',
            ], [
                'clave'  => 'SOPORT',
                'nombre' => 'SOPORTE TECNICO',
            ], [
                'clave'  => 'SISTEM',
                'nombre' => 'PERSONAL DE SISTEMAS',
            ], [
                'clave'  => 'FINANZ',
                'nombre' => 'PERSONAL DE FINANZAS',
            ],
        ];
    }
}
