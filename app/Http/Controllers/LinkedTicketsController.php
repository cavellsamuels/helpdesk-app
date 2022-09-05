<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;

class LinkedTicketsController extends Controller
{
    protected array $urgencies;

    protected array $categories;

    protected Collection $itSupportUsers;

    public function __construct()
    {
        $this->urgencies = Ticket::$urgencies;
        $this->categories = Ticket::$categories;
        $this->itSupportUsers = User::where('role_id', 2)->get();
    }

    public function show(Request $request): View
    {
        $tickets = Ticket::find($request->linkedtickets);

        if ($tickets == true) {
            if ($request->has('viewtickets')) {
                return view('tickets.linked.show', compact('tickets'), ['urgencies' => $this->urgencies, 'categories' => $this->categories]);
            } elseif ($request->has('edittickets')) {
                return view('tickets.linked.edit', compact('tickets'), ['users' => $this->itSupportUsers, 'urgencies' => $this->urgencies, 'categories' => $this->categories]);
            }
        } else {
            return back()->with('error', 'You Must Select At Least One Ticket');
        }
    }

    public function update()
    {
    }

    // public function linked(Request $request)
    // {
    //     if ($tickets == true) {
    //         if ($request->has('viewtickets')) {
    //             return view('tickets.linked', compact('tickets', 'urgencies', 'categories'));
    //         } elseif ($request->has('edittickets')) {
    //             return view('tickets.edit-linked', compact('users', 'tickets', 'urgencies', 'categories'));
    //         }
    //     } else {
    //         return back()->with('error', 'You Must Select At Least One Ticket');
    //     }
    // }

    // public function updatelinked(Request $request, FileController $fileController, FileService $fileService, $tickets): RedirectResponse
    // {
    //     $tId = explode(',', $tickets);
    //     dd($tId);
    //     $ticketIds = Ticket::all()->where('id', $tickets);

    //     foreach ($ticketIds as $ticket) {
    //         $ticket->update($request->only(['title', 'details', 'assigned_to', 'logged_by', 'urgency', 'category', 'open']));
    //         $fileController->update($ticket, $request, $fileService);
    //     }

    //     return redirect()->route('show.global.dashboard')->with('success', 'Tickets Updated Successfully');
    // }
}
