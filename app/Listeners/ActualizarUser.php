<?php

namespace App\Listeners;

use App\Events\DatoContactoActualizado;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ActualizarUser
{
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
     * @param  DatoContactoActualizado  $event
     * @return void
     */
    public function handle(DatoContactoActualizado $event)
    {
        $datoContacto = $event->datoContacto;
        $newEmail = $datoContacto->email;
        $empleado = $datoContacto->empleado;
        $user = $empleado->user;
        $result = $user->update(['email' => $newEmail]);
    }
}
