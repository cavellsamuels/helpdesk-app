<?php

namespace App\Observers;

use App\Http\Controllers\FileController;
use App\Http\Requests\StoreTicketRequest;
use App\Models\Ticket;
use Illuminate\Database\QueryException;

class TicketObserver
{
    /**
     * Handle the Ticket "created" event.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return void
     */
    public function created(Ticket $ticket, StoreTicketRequest $request, FileController $fileController)
    {
        try {
            $ticket = Ticket::query()->create($request->only(['title', 'details', 'urgency', 'category', 'open', 'logged_by', 'assigned_to']));
            $fileController->store($ticket, $request);
        } catch (QueryException $error) {
            return back()->with('error', 'Ticket Unsuccessfully Added');
        }
    }

    /**
     * Handle the Ticket "updated" event.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return void
     */
    public function updated(Ticket $ticket)
    {
        //
    }

    /**
     * Handle the Ticket "deleted" event.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return void
     */
    public function deleted(Ticket $ticket)
    {
        //
    }

    /**
     * Handle the Ticket "restored" event.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return void
     */
    public function restored(Ticket $ticket)
    {
        //
    }

    /**
     * Handle the Ticket "force deleted" event.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return void
     */
    public function forceDeleted(Ticket $ticket)
    {
        //
    }
}
