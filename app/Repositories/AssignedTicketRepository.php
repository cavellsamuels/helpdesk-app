<?php

namespace App\Repositories;

use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;
use App\Interfaces\AssignedTicketRepositoryInterface;

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
