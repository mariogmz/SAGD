<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades as Facades;

use App\Rol;
use App\Permiso;
use App\Empleado;

class UpdateAcl extends Command
{

    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = 'acl:update
        { --force : Force the update }
        { --mode=1 : Modo a correr. 1. Roles-Permisos, 2. Empleados-Roles }
        { --rol=SISTEM : Rol a actualizar }
        { --empleado=0 : ID de Empleado a actualizar}
        { --permisos=ALL : Permisos que se asignaran }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Actualiza los permisos al rol de Sistemas.\n
    Existen varios modos de usarlo:\n
    \t1 => Roles-Permisos. Asigna todos los permisos a un rol especifico.\n
    \t2 => Empleados-Roles. Asigna un rol a un empleado especifico\n
    Por default el modo es 1, rol es SISTEM, empleado es 0 y permisos es ALL";

    protected $force;
    protected $mode;
    protected $rol;
    protected $empleado;
    protected $permisos;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->force = $this->option('force') ? true : false;
        $this->mode = $this->option('mode');
        $this->rol = $this->option('rol');
        $this->empleado = $this->option('empleado');
        $this->permisos = $this->option('permisos');

        if ($this->force) {
            $this->update();
            return;
        }

        $this->info('Estas a punto de actualizar permisos');

        if ($this->confirm('¿Deseas continuar?')) {
            $this->update();
        }
    }

    private function update()
    {
        switch ($this->mode) {
            case 1:
                $this->modeOne();
                break;
            case 2:
                $this->modeTwo();
                break;
            default:
                return;
                break;
        }
    }

    private function modeOne()
    {
        $rol = Rol::where('clave', $this->rol)->first();
        $permisos = Permiso::all();
        $permisosRol = $rol->permisos;
        foreach ($permisos as $permiso) {
            if ($permisosRol->contains('id', $permiso->id)) {
                $message = sprintf("\r<info>Rol ya contiene el permiso</info> %d", $permiso->id);
                $this->getOutput()->write($message);
            } else {
                $message = sprintf("\n<info>Agregando el permiso</info> %d <info>al rol</info> %s", $permiso->id, $this->rol);
                $this->getOutput()->write($message);
                $rol->permisos()->attach($permiso->id);
            }
        }
        $this->line("");
    }

    private function modeTwo()
    {
        $rol = Rol::where('clave', $this->rol)->first();
        $empleado = Empleado::findOrFail($this->empleado);

        if ($rol->empleados->contains('id', $empleado->id)) {
            $message = sprintf("\r<info>Rol ya contiene al empleado</info> %s", $empleado->usuario);
            $this->getOutput()->write($message);
        } else {
            $message = sprintf("\n<info>Agregando el empleado</info> %s <info>al rol</info> %s", $empleado->usuario, $this->rol);
            $this->getOutput()->write($message);
            $empleado->roles()->attach($rol->id);
        }
        $this->line("");
    }
}
