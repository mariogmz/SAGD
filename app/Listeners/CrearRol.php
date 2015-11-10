<?php

namespace App\Listeners;

use App\Empleado;
use App\Rol;
use App\Events\EmpleadoRolCreado;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CrearRol
{
    protected $empleado;
    protected $rol;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Empleado $empleado, Rol $rol)
    {
        $this->empleado = $empleado;
        $this->rol = $rol;
    }

    /**
     * Handle the event.
     *
     * @param  EmpleadoRolCreado  $event
     * @return void
     */
    public function handle(EmpleadoRolCreado $event)
    {
        $this->empleado = $event->empleado;

        $this->rol = new $this->rol([
            'clave' => $this->empleado->usuario,
            'nombre' => "Rol individual de ".$this->empleado->nombre,
            'individual' => true
        ]);

        if ($this->rol->save()) {
            $this->empleado->roles()->attach($this->rol->id);
        }
    }
}
