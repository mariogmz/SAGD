<?php

namespace App\Events;

use App\Transferencia;
use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class Transferir extends Event
{
    use SerializesModels;
    public $transferencia;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Transferencia $transferencia)
    {
        $this->transferencia = $transferencia;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
