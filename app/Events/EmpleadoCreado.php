<?php

namespace App\Events;

use App\Empleado;
use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class EmpleadoCreado extends Event implements ShouldBroadcast
{
    use SerializesModels;
    protected $empleado;
    protected $user;
    public $payload;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Empleado $empleado)
    {
        $this->empleado = $empleado;
        try {
            $this->user = \JWTAuth::parseToken()->authenticate()->morphable;
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            $this->user = "cli";
        }
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        $this->payload = [
            'user' => $this->user,
            'message' => "Se creo el empleado: ".$this->empleado->usuario,
            'timestamp' => \Carbon\Carbon::now()->toDateTimeString(),
            'channel' => 'warn',
            'level' => 'ws-warn',
            'extra' => [
                'user' => $this->empleado->usuario
            ]
        ];
        return ['warn'];
    }
}
