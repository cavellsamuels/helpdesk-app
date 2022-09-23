<?php

namespace App\Providers;

use App\Models\User;
use App\Notifications\CreatedTicketNotification;
use App\Notifications\DeletedTicketNotification;
use App\Notifications\UpdatedTicketNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Notification;

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
     * @param \App\Providers\TicketUpdated $event
     *
     * @return void
     */
    public function handle(TicketCreated $createEvent, TicketUpdated $updateEvent, TicketDeleted $deleteEvent)
    {
        $createTicket = $createEvent->ticket;
        Notification::send($this->itSupportUsers, new CreatedTicketNotification($createTicket));

        $updateTicket = $updateEvent->ticket;
        Notification::send($this->itSupportUsers, new UpdatedTicketNotification($updateTicket));

        $deleteTicket = $deleteEvent->ticket;
        Notification::send($this->itSupportUsers, new DeletedTicketNotification($deleteTicket));
    }
}
