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
                'individual' => false
            ], [
                'clave'  => 'GERSUC',
                'nombre' => 'GERENTE DE SUCURSAL',
                'individual' => false
            ], [
                'clave'  => 'ALMACE',
                'nombre' => 'ALMACENISTA',
                'individual' => false
            ], [
                'clave'  => 'VENTAS',
                'nombre' => 'PERSONAL DE VENTAS',
                'individual' => false
            ], [
                'clave'  => 'SOPORT',
                'nombre' => 'SOPORTE TECNICO',
                'individual' => false
            ], [
                'clave'  => 'SISTEM',
                'nombre' => 'PERSONAL DE SISTEMAS',
                'individual' => false
            ], [
                'clave'  => 'FINANZ',
                'nombre' => 'PERSONAL DE FINANZAS',
                'individual' => false
            ], [
                'clave'  => 'UFINAL',
                'nombre' => 'USUARIO FINAL',
                'individual' => false
            ], [
                'clave'  => 'DISTRI',
                'nombre' => 'DISTRIBUIDOR',
                'individual' => false
            ],
        ];
    }
}
