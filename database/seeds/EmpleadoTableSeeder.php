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
        $data = [
            'nombre' => 'Administrador',
            'usuario' => 'admin',
            'activo' => 1,
            'puesto' => 'Administrador',
            'fecha_cambio_password' => \Carbon\Carbon::now('America/Mexico_City'),
            'sucursal_id' => App\Sucursal::where('clave', 'DICOTAGS')->first()->id
        ];
        $empleado = new App\Empleado($data);
        $empleado->save();


        $data = [
            'email' => 'sistemas@zegucom.com.mx',
            'password' => Hash::make('test123'),
            'morphable_id' => $empleado->id,
            'morphable_type' => get_class($empleado)
        ];
        $user = new App\User($data);
        $user->save();
    }
}
