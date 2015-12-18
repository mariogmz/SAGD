<?php

namespace App\Events;

use App\Events\Event;
use App\Sucursal;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SucursalCreada extends Event implements ShouldBroadcast
{
    use SerializesModels;
    protected $sucursal;
    protected $user;
    protected $jobStatus;
    public $payload;

    /**
     * Create a new event instance
     * @param string $sucursal
     * @param bool $jobStatus
     */
    public function __construct($sucursal, $jobStatus)
    {
        $this->sucursal = $sucursal;
        $this->user = "cli";
        $this->jobStatus = $jobStatus;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        $message = ($this->jobStatus) ? "Se terminó de crear la sucursal $this->sucursal" :
            "No se pudo crear la sucursal $this->sucursal";
        $level = ($this->jobStatus) ? 'info' : 'warn' ;
        $this->payload = [
            'user' => $this->user,
            'message' => $message,
            'timestamp' => \Carbon\Carbon::now()->toDateTimeString(),
            'channel' => $level,
            'level' => "ws-".$level
        ];
        return [$level];
    }
}
