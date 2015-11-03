<?php

use Illuminate\Database\Seeder;

class PermisosInicialesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->setInitialPermisions();
    }

    /**
     * Pone permisos por default al rol del empleado
     */
    private function setInitialPermisions()
    {
        $roles = App\Rol::all();
        $auth = App\Permiso::where('controlador', 'like', 'Authenticate%')->get()->pluck('id')->toArray();
        $passwords = App\Permiso::where('controlador', 'like', 'Password%')->get()->pluck('id')->toArray();

        foreach ($roles as $rol) {
            $rol->permisos()->attach($auth);
            $rol->permisos()->attach($passwords);
        }
    }
}
