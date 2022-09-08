<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class AssignedTicketContrroller extends Controller
{
    public function __invoke(): View
    {
        $tickets = Ticket::all()->where('assigned_to', Auth::user()->id);

        return view('assigned-dashboard', compact('tickets'));
    }
}
