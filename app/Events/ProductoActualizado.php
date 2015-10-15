<?php

namespace App\Events;

use App\Producto;
use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ProductoActualizado extends Event implements ShouldBroadcast
{
    use SerializesModels;

    protected $producto;
    protected $usuario;
    public $payload;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Producto $producto)
    {
        $this->producto = $producto;
        try {
            $this->usuario = \JWTAuth::parseToken()->authenticate()->morphable;
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            $this->usuario = "cli";
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
            'user' => $this->usuario->usuario,
            'message' => "Se actualizó el producto: ".$this->producto->upc,
            'timestamp' => \Carbon\Carbon::now()->toDateTimeString(),
            'channel' => 'info',
            'level' => 'ws-info'
        ];
        return ['info'];
    }
}
