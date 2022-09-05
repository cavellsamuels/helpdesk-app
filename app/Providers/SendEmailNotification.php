<?php

namespace App\Providers;

use App\Models\User;
use App\Providers\TicketUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UpdatedTicketNotification;

class SendEmailNotification implements ShouldQueue
{
    public $itSupportUsers;
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
    public function handle(TicketUpdated $event)
    {
        $ticket = $event->ticket;
        Notification::send($this->itSupportUsers, new UpdatedTicketNotification($ticket));
    }
}
