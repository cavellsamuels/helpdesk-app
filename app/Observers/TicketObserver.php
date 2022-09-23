<?php

namespace App\Observers;

use App\Models\Ticket;
use App\Models\User;
use App\Notifications\CreatedTicketNotification;
use App\Notifications\DeletedTicketNotification;
use App\Notifications\UpdatedTicketNotification;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Notification;

class TicketObserver
{
    protected Collection $itSupportUsers;

    public function __construct()
    {
        $this->itSupportUsers = User::where('role_id', 2)->get();
    }

    /**
     * Handle the Ticket "created" event.
     *
     * @param \App\Models\Ticket $ticket
     *
     * @return void
     */
    public function created(Ticket $ticket)
    {
        Notification::send($this->itSupportUsers, new CreatedTicketNotification($ticket));
    }

    /**
     * Handle the Ticket "updated" event.
     *
     * @param \App\Models\Ticket $ticket
     *
     * @return void
     */
    public function updated(Ticket $ticket)
    {
        Notification::send($this->itSupportUsers, new UpdatedTicketNotification($ticket));
    }

    /**
     * Handle the Ticket "deleted" event.
     *
     * @param \App\Models\Ticket $ticket
     *
     * @return void
     */
    public function deleted(Ticket $ticket)
    {
        Notification::send($this->itSupportUsers, new DeletedTicketNotification($ticket));
    }

    /**
     * Handle the Ticket "restored" event.
     *
     * @param \App\Models\Ticket $ticket
     *
     * @return void
     */
    public function restored(Ticket $ticket)
    {
        //
    }

    /**
     * Handle the Ticket "force deleted" event.
     *
     * @param \App\Models\Ticket $ticket
     *
     * @return void
     */
    public function forceDeleted(Ticket $ticket)
    {
        //
    }
}
