<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class LinkedTicketsController extends Controller
{
    public function show(Request $request)
    {
        $tickets = Ticket::find($request->linkedtickets);
        
        if ($tickets == true) {
            if ($request->has('viewtickets')) {
                return view('tickets.linked.show', compact('tickets'));
            } elseif ($request->has('edittickets')) {
                return view('tickets.linked.edit', compact('tickets'));
            }
        } else {
            return back()->with('error', 'You Must Select At Least One Ticket');
        }
        $this->update($tickets);
    }

    public function update($tickets)
    {
        dd($tickets);
    }

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
