<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\View\View;

class UnassignedTicketContrroller extends Controller
{
    public function __invoke(): View
    {
        $tickets = Ticket::all()->where('assigned_to', null);

        return view('unassigned-dashboard', compact('tickets'));
    }
}
