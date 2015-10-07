<?php

namespace App\Events;

use App\Sucursal;
use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SucursalVista extends Event implements ShouldBroadcast
{
    use SerializesModels;

    protected $sucursal;
    protected $user;
    public $data;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Sucursal $sucursal)
    {
        $this->sucursal = $sucursal;
        $this->user = \JWTAuth::parseToken()->authenticate()->morphable;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        $this->data = [
            'usuario' => $this->user->usuario,
            'mensaje' => "Vio una sucursal"
        ];
        return ['sucursales'];
    }
}
