<?php

use Illuminate\Database\Seeder;

class EmpleadoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sucursalId = App\Sucursal::where('clave', 'DICOTAGS')->first()->id;

        $empleados = [
            [
                'empleado' => [
                    'nombre' => 'Administrador',
                    'usuario' => 'admin',
                    'activo' => 1,
                    'puesto' => 'Administrador',
                    'sucursal_id' => $sucursalId
                ],
                'dato_contacto' => [
                    'email' => 'sistemas@zegucom.com.mx'
                ]
            ],
            [
                'empleado' => [
                    'nombre' => 'Juan Carlos Lopez',
                    'usuario' => 'jclopez',
                    'activo' => 1,
                    'puesto' => 'Administrador',
                    'sucursal_id' => $sucursalId
                ],
                'dato_contacto' => [
                    'email' => 'jlopez@zegucom.com.mx'
                ]
            ],
            [
                'empleado' => [
                    'nombre' => 'Omar Garcia',
                    'usuario' => 'ogarcia',
                    'activo' => 1,
                    'puesto' => 'Administrador',
                    'sucursal_id' => $sucursalId
                ],
                'dato_contacto' => [
                    'email' => 'ogarcia@zegucom.com.mx'
                ]
            ],
            [
                'empleado' => [
                    'nombre' => 'Mario Gomez',
                    'usuario' => 'mgomez',
                    'activo' => 1,
                    'puesto' => 'Administrador',
                    'sucursal_id' => $sucursalId
                ],
                'dato_contacto' => [
                    'email' => 'mgomez@zegucom.com.mx'
                ]
            ],
        ];

        foreach ($empleados as $empleado) {
            $e = new App\Empleado($empleado['empleado']);
            $e->fecha_cambio_password = \Carbon\Carbon::now('America/Mexico_City');
            $e->guardar($empleado['dato_contacto']);
        }
    }
}
