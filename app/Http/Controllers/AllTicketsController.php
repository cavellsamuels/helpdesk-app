<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Contracts\View\View;

class AllTicketsController extends Controller
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
        $tickets = Ticket::all();

        return view('global-dashboard', compact('tickets'), ['urgencies' => $this->urgencies, 'categories' => $this->categories]);
    }

    // public function showEditLinkedTickets(EditLinkedRequest $request): View
    // {
    //     $users = User::all()->where('role_id', 2);
    //     $tickets = Ticket::find($request->linkedtickets);
    //     $id = $tickets->pluck('id');
    //     $urgencies = $this->urgencies;
    //     $categories = $this->categories;

    //     return view('tickets.edit-linked', compact('users', 'tickets', 'urgencies', 'categories'));
    // }
}
