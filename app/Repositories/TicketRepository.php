<?php

namespace App\Repositories;

use App\Interfaces\TicketRepositoryInterface;
use App\Models\Comment;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Collection;

class TicketRepository implements TicketRepositoryInterface
{
    public function getTickets(): Collection
    {
        return Ticket::all();
    }

    public function getComments(Ticket $ticket): Collection
    {
        return Comment::where('ticket_id', $ticket->id)->get();
    }
}
