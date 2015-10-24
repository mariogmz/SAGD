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
        $empleado = new App\Empleado([
            'nombre' => 'Administrador',
            'usuario' => 'admin',
            'activo' => 1,
            'puesto' => 'Administrador',
            'fecha_cambio_password' => \Carbon\Carbon::now('America/Mexico_City'),
            'sucursal_id' => App\Sucursal::where('clave', 'DICOTAGS')->first()->id
        ]);
        $empleado->save();

        $user = new App\User([
            'email' => 'sistemas@zegucom.com.mx',
            'password' => Hash::make('test123'),
            'morphable_id' => $empleado->id,
            'morphable_type' => get_class($empleado)
        ]);
        $user->save();

        $empleado = new App\Empleado([
            'nombre' => 'Omar Garcia',
            'usuario' => 'ogarcia',
            'activo' => 1,
            'puesto' => 'Administrador',
            'fecha_cambio_password' => \Carbon\Carbon::now('America/Mexico_City'),
            'sucursal_id' => App\Sucursal::where('clave', 'DICOTAGS')->first()->id
        ]);
        $empleado->save();

        App\DatoContacto::create([
            'email' => 'ogarcia@zegucom.com.mx',
            'empleado_id' => $empleado->id
        ]);
    }
}
