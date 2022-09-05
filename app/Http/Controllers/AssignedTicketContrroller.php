<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class AssignedTicketContrroller extends Controller
{
    protected $urgencies;
    protected $categories;

    public function __construct()
    {
        $this->urgencies = Ticket::$urgencies;
        $this->categories = Ticket::$categories;
    }

    public function __invoke(): View
    {
        $tickets = Ticket::all()->where('assigned_to', Auth::user()->id);

        return view('assigned-dashboard', compact('tickets'), ['urgencies' => $this->urgencies, 'categories' => $this->categories]);
    }
}
