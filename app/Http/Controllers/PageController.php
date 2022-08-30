<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditLinkedRequest;
use App\Models\Ticket;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function showIndex(): View
    {
        $tickets = Ticket::all();
        $urgencies = Ticket::$urgencies;
        $categories = Ticket::$categories;

        return view('index', compact('tickets', 'urgencies', 'categories'));
    }

    public function showGlobalDashboard(Ticket $ticket): View
    {
        $tickets = Ticket::all();
        $urgencies = Ticket::$urgencies;
        $categories = Ticket::$categories;

        return view('global-dashboard', compact('tickets', 'urgencies', 'categories'));
    }

    public function showAssignedDashboard(): View
    {
        $tickets = Ticket::all()->where('assigned_to', Auth::user()->id);
        $urgencies = Ticket::$urgencies;
        $categories = Ticket::$categories;

        return view('assigned-dashboard', compact('tickets', 'urgencies', 'categories'));
    }

    public function showUnassignedDashboard(): View
    {
        $tickets = Ticket::all()->where('assigned_to', null);
        $urgencies = Ticket::$urgencies;
        $categories = Ticket::$categories;

        return view('unassigned-dashboard', compact('tickets', 'urgencies', 'categories'));
    }

    public function showEditLinkedTickets(EditLinkedRequest $request): View
    {
        $tickets = Ticket::find($request->linkedtickets);
        $id = $tickets->pluck('id');
        $users = User::all()->where('role_id', 2);
        $urgencies = Ticket::$urgencies;
        $categories = Ticket::$categories;

        return view('tickets.edit-linked', compact('tickets', 'urgencies', 'users', 'categories'));
    }
}
