<?php

namespace App\Repositories;

use App\Models\Ticket;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Collection;
use App\Interfaces\TicketRepositoryInterface;

class TicketRepository implements TicketRepositoryInterface
{
    public function getComments(Ticket $ticket): Collection
    {
        return Comment::where('ticket_id', $ticket->id)->get();
    }
}
