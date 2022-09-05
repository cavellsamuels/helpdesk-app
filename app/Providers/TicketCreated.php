<?php

namespace App\Providers;

use App\Models\Ticket;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class TicketCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $ticket;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    // /**
    //  * Get the channels the event should broadcast on.
    //  *
    //  * @return \Illuminate\Broadcasting\Channel|array
    //  */
    // public function broadcastOn()
    // {
    //     return new PrivateChannel('channel-name');
    // }
}
