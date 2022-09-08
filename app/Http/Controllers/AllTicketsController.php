<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Contracts\View\View;

class AllTicketsController extends Controller
{
    public function __invoke(): View
    {
        $tickets = Ticket::all();

        return view('global-dashboard', compact('tickets'));
    }
}
