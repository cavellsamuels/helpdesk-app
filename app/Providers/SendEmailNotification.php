<?php

namespace App\Providers;

use App\Models\User;
use App\Providers\TicketUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Notification;
use App\Notifications\CreatedTicketNotification;
use App\Notifications\UpdatedTicketNotification;

class SendEmailNotification implements ShouldQueue
{
    public Collection $itSupportUsers;
    
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->itSupportUsers = User::all()->where('role_id', 2);
    }

    /**
     * Handle the event.
     *
     * @param  \App\Providers\TicketUpdated  $event
     * @return void
     */
    public function handle(TicketCreated $createEvent, TicketUpdated $updateEvent)
    {
        $createTicket = $createEvent->ticket;
        Notification::send($this->itSupportUsers, new CreatedTicketNotification($createTicket));

        $updateTicket = $updateEvent->ticket;
        Notification::send($this->itSupportUsers, new UpdatedTicketNotification($updateTicket));
    }
}
