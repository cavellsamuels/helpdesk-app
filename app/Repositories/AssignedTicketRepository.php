<?php

namespace App\Repositories;

use App\Interfaces\AssignedTicketRepositoryInterface;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class AssignedTicketRepository implements AssignedTicketRepositoryInterface
{
    public function getAllTickets(): Collection
    {
        return Ticket::all();
    }

    public function getAssignedTickets(): Collection
    {
        return Ticket::where('assigned_to', Auth::user()->id)->get();
    }

    public function getUnassignedTickets(): Collection
    {
        return Ticket::where('assigned_to', null)->get();
    }
}
