<?php

namespace App\Interfaces;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Collection;

interface TicketRepositoryInterface 
{
    public function getComments(Ticket $ticket): Collection;
}