<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\EditLinkedRequest;

class PageController extends Controller
{
    protected $urgencies;
    protected $categories;

    public function __construct()
    {
        $this->urgencies = Ticket::$urgencies;
        $this->categories = Ticket::$categories;
    }

    public function showGlobalDashboard(Ticket $ticket): View
    {
        $tickets = Ticket::all();
        $urgencies = $this->urgencies;
        $categories = $this->categories;

        return view('global-dashboard', compact('tickets', 'urgencies', 'categories'));
    }

    public function showAssignedDashboard(): View
    {
        $tickets = Ticket::all()->where('assigned_to', Auth::user()->id);
        $urgencies = $this->urgencies;
        $categories = $this->categories;

        return view('assigned-dashboard', compact('tickets', 'urgencies', 'categories'));
    }

    public function showUnassignedDashboard(): View
    {
        $tickets = Ticket::all()->where('assigned_to', null);
        $urgencies = $this->urgencies;
        $categories = $this->categories;

        return view('unassigned-dashboard', compact('tickets', 'urgencies', 'categories'));
    }

    public function showEditLinkedTickets(EditLinkedRequest $request): View
    {
        $users = User::all()->where('role_id', 2);
        $tickets = Ticket::find($request->linkedtickets);
        $id = $tickets->pluck('id');
        $urgencies = $this->urgencies;
        $categories = $this->categories;

        return view('tickets.edit-linked', compact('users', 'tickets', 'urgencies', 'categories'));
    }
}
