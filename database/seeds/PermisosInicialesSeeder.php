<?php

use Illuminate\Database\Seeder;

use Symfony\Component\Console\Helper\ProgressBar;

class PermisosInicialesSeeder extends Seeder
{

    protected $progressBar;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->setInitialPermisions();
        $this->setDevelopmentPermisions();
    }

    /**
     * Pone permisos por default al rol del empleado
     */
    private function setInitialPermisions()
    {
        $roles = App\Rol::all();
        $auth = App\Permiso::where('controlador', 'like', 'Authenticate%')->get()->pluck('id')->toArray();
        $passwords = App\Permiso::where('controlador', 'like', 'Password%')->get()->pluck('id')->toArray();
        $this->setUpProgressBar(count($roles));

        foreach ($roles as $rol) {
            $rol->permisos()->attach($auth);
            $rol->permisos()->attach($passwords);
            $this->progressBar->advance();
        }
        $this->progressBar->finish();
        $this->command->getOutput()->writeln("");
    }

    /**
     * Establece permisos globales a personal de sistemas
     */
    private function setDevelopmentPermisions()
    {
        $this->setSistemasPermisions();
        $this->setEmpleadosDeSistemas();
    }

    private function setSistemasPermisions()
    {
        $rol = App\Rol::where('clave','SISTEM')->first();
        $permisos = App\Permiso::all();
        $this->setUpProgressBar(count($permisos));

        foreach ($permisos as $permiso) {
            $rol->permisos()->attach($permiso->id);
            $this->progressBar->advance();
        }
        $this->progressBar->finish();
        $this->command->getOutput()->writeln("");
    }

    private function setEmpleadosDeSistemas() {
        $rol = App\Rol::where('clave', 'SISTEM')->first();
        $empleados = App\Empleado::whereIn('usuario', ['admin', 'jlopez', 'mgomez', 'ogarcia'])->get();
        $this->setUpProgressBar(count($empleados));

        foreach ($empleados as $empleado) {
            $empleado->roles()->attach($rol->id);
            $this->progressBar->advance();
        }
        $this->progressBar->finish();
        $this->command->getOutput()->writeln("");
    }

    private function setUpProgressBar($numberOfElements)
    {
        $elements = $numberOfElements;
        $this->progressBar = new ProgressBar($this->command->getOutput(), $elements);
        $this->progressBar->setFormat("<info>Setting:</info> Permisos : [%bar%] %percent:3s%% %elapsed:6s%/%estimated:-6s%");
        $this->progressBar->start();
    }
}
