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
     * Create a new event instance.
     *
     * @param Sucursal $sucursal
     * @param bool $jobStatus
     * @return void
     */
    public function __construct(Sucursal $sucursal, $jobStatus)
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
        $level = ($this->jobStatus) ? 'info' : 'warn' ;
        $this->payload = [
            'user' => $this->user,
            'message' => "Se terminó de crear la sucursal: ".$this->sucursal->clave,
            'timestamp' => \Carbon\Carbon::now()->toDateTimeString(),
            'channel' => $level,
            'level' => "ws-".$level
        ];
        return [$level];
    }
}
