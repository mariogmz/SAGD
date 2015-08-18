<?php

use Illuminate\Database\Seeder;

class PermisoTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        foreach($this->prepararDatos() as $permiso){
            $nuevo_permiso = new App\Permiso($permiso);
            if(!$nuevo_permiso->save()){
                // Errors
            }
        }
    }

    private function prepararDatos() {
        return [
            [
                'clave'  => 'ANTADMIN',
                'nombre' => 'Administrar anticipos.',
            ], [
                'clave'  => 'ANTREGIS',
                'nombre' => 'Administrar anticipos.',
            ], [
                'clave'  => 'CLILISTA',
                'nombre' => 'Listar clientes',
            ], [
                'clave'  => 'CLIMODIF',
                'nombre' => 'Modificar cliente',
            ], [
                'clave'  => 'CLIAGREG',
                'nombre' => 'Agregar cliente nuevo.',
            ], [
                'clave'  => 'CLIELIMI',
                'nombre' => 'Eliminar clientes.',
            ], [
                'clave'  => 'CLITABUL',
                'nombre' => 'Modificar tabulador a clientes.',
            ], [
                'clave'  => 'CLIATRIB',
                'nombre' => 'Modificar atributos especiales a clientes.',
            ], [
                'clave'  => 'CLICAMPAN',
                'nombre' => 'Enviar campaña de correo a clientes.',
            ], [
                'clave'  => 'EMPLISTA',
                'nombre' => 'Listar empleados.',
            ], [
                'clave'  => 'EMPMODIF',
                'nombre' => 'Modificar empleados.',
            ], [
                'clave'  => 'EMPPERMI',
                'nombre' => 'Modificar permisos de empleados.',
            ], [
                'clave'  => 'EMPAGREG',
                'nombre' => 'Agregar nuevos empleados.',
            ], [
                'clave'  => 'EMPELIMI',
                'nombre' => 'Eliminar empleados.',
            ], [
                'clave'  => 'EMPROLES',
                'nombre' => 'Modificar roles de los empleados.',
            ], [
                'clave'  => 'ROLAGREG',
                'nombre' => 'Agregar roles.',
            ], [
                'clave'  => 'ROLMODIF',
                'nombre' => 'Modificar roles.',
            ], [
                'clave'  => 'ROLELIMI',
                'nombre' => 'Eliminar roles.',
            ], [
                'clave'  => 'ROLLISTA',
                'nombre' => 'Listar roles.',
            ], [
                'clave'  => 'FACVENTA',
                'nombre' => 'Generar facturas al momento de vender.',
            ], [
                'clave'  => 'FACREFAC',
                'nombre' => 'Generar nuevamente una factura que ya había sido generada.',
            ], [
                'clave'  => 'FACCANCE',
                'nombre' => 'Cancelar factura.',
            ], [
                'clave'  => 'INVCONTA',
                'nombre' => 'Contar inventarios.',
            ], [
                'clave'  => 'INVCORRE',
                'nombre' => 'Corregir inventario.',
            ], [
                'clave'  => 'INVENTRA',
                'nombre' => 'Gestionar entradas al inventario.',
            ], [
                'clave'  => 'INVSALID',
                'nombre' => 'Gestionar salidas del inventario.',
            ], [
                'clave'  => 'INVAPART',
                'nombre' => 'Apartar y desapartar productos.',
            ], [
                'clave'  => 'INVTRANS',
                'nombre' => 'Gestionar transferencias de productos en el inventario.',
            ], [
                'clave'  => 'PAQLISTA',
                'nombre' => 'Listar y ver detalles de paqueterías.',
            ], [
                'clave'  => 'PAQAGREG',
                'nombre' => 'Agregar nuevas paqueterías.',
            ], [
                'clave'  => 'PAQMODIF',
                'nombre' => 'Modificar las paqueterías.',
            ], [
                'clave'  => 'PAQELIMI',
                'nombre' => 'Eliminar paqueterías.',
            ], [
                'clave'  => 'PROLISTA',
                'nombre' => 'Ver listado de productos y sus características.',
            ], [
                'clave'  => 'PROAGREG',
                'nombre' => 'Agregar nuevos productos.',
            ], [
                'clave'  => 'PROMODIF',
                'nombre' => 'Modificar productos y sus características.',
            ], [
                'clave'  => 'PROELIMI',
                'nombre' => 'Eliminar productos.',
            ], [
                'clave'  => 'PROPRECI',
                'nombre' => 'Modificar precios de productos.',
            ], [
                'clave'  => 'PROMARGE',
                'nombre' => 'Gestionar los márgenes de ganancia para productos.',
            ],
        ];
    }
}
