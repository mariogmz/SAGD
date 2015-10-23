<?php

namespace App\Listeners;

use App\Empleado;
use App\Events\PostEmpleadoCreado;
use App\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CrearUser
{
    protected $empleado;
    protected $user;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PostEmpleadoCreado  $event
     * @return void
     */
    public function handle(PostEmpleadoCreado $event)
    {
        $this->empleado = $event->empleado;

        $user = new User();
        $user->email = $this->empleado->datoContacto->email;
        $user->password = \Hash::make($this->empleado->nombre . "2015");
        $user->morphable_id = $this->empleado->id;
        $user->morphable_type = get_class($this->empleado);

        $user->save();
    }
}
