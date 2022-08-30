<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateFileRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Models\Comment;
use App\Models\File;
use App\Models\LinkedTicket;
use App\Models\Ticket;
use App\Models\User;
use App\Notifications\UpdatedTicketNotification;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class TicketController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $users = User::all()->where('role_id', 2);
        $urgencies = Ticket::$urgencies;
        $categories = Ticket::$categories;

        return view('tickets.create', compact('users', 'urgencies', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTicketRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTicketRequest $request, Ticket $ticket): RedirectResponse
    {
        try {
            $ticket = Ticket::query()->create($request->only(['title', 'details', 'urgency', 'category', 'open', 'logged_by', 'assigned_to']));
            $file = $request->hasfile('file');

            if ($file) {
                File::query()->create([
                    'name' => $request->file('file')->getClientOriginalName(),
                    'path' => $request->file('file')->store('public/files'),
                    'file_size' => $request->file('file')->getSize(),
                    'ticket_id' => $ticket->id,
                ]);
            } else {
                $file = null;
            }
        } catch (QueryException $error) {
            return back()->with('error', 'Ticket Unsuccessfully Added');
        }
        if (Auth::check()) {
            return redirect()->route('show.global.dashboard')->with('success', 'Ticket Added Successfully');
        } else {
            return redirect()->route('show.index')->with('success', 'Ticket Added Successfully');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket, File $file): View
    {
        $urgencies = Ticket::$urgencies;
        $categories = Ticket::$categories;
        $comments = Comment::where('ticket_id', $ticket->id)->get();
        $users = User::all()->where('role_id', 2);

        return view('tickets.show', compact('ticket', 'file', 'urgencies', 'categories', 'comments', 'users'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket): View
    {
        $urgencies = Ticket::$urgencies;
        $categories = Ticket::$categories;
        $users = User::all()->where('role_id', 2);

        return view('tickets.edit', compact('ticket', 'users', 'urgencies', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTicketRequest  $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTicketRequest $request, Ticket $ticket, User $user): RedirectResponse
    {
        $ticketFile = $ticket->file;
        $users = User::all()->where('role_id', 2);
        try {
            if (Auth::check()) {
                $ticket->update($request->only(['title', 'details', 'urgency', 'category', 'open', 'assigned_to']) + (['reporting_email' => now()]));

                if ($request->hasfile('file')) {
                    if ($ticketFile) {
                        Storage::delete($ticketFile);
                        $ticketFile->update([
                            'name' => $request->file('file')->getClientOriginalName(),
                            'path' => $request->file('file')->store('public/files'),
                            'file_size' => $request->file('file')->getSize(),
                        ]);
                    } else {
                        File::query()->create([
                            'name' => $request->file('file')->getClientOriginalName(),
                            'path' => $request->file('file')->store('public/files'),
                            'file_size' => $request->file('file')->getSize(),
                            'ticket_id' => $ticket->id,
                        ]);
                    }
                }
            } else {
                $ticket->update($request->only(['open']));

                return redirect()->route('show.index')->with('success', 'Ticket Updated Successfully');
            }
        } catch (QueryException $error) {
            return back()->with('error', 'Couldn\'t Update Ticket');
        }
        Notification::send($users, new UpdatedTicketNotification($ticket));

        return redirect()->route('show.global.dashboard')->with('success', 'Ticket Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function delete(Ticket $ticket): RedirectResponse
    {
        try {
            $ticket->delete();
            if (file_exists($ticket->file)) {
                Storage::delete($ticket->file);
            }
        } catch (QueryException $error) {
            return back()->with('error', 'Ticket Not Deleted');
        }

        return back()->with('success', 'Ticket Deleted Successfully');
    }

    public function search(SearchRequest $request)
    {
        $urgencies = Ticket::$urgencies;
        $categories = Ticket::$categories;
        $search = $request->get('search');
        $ticketsId = Ticket::all()->where('id', $search);
        $ticketsTitle = Ticket::all()->where('title', $search);

        if (count($ticketsId) > 0 || count($ticketsTitle) > 0) {
            return view('search', compact('ticketsId', 'ticketsTitle', 'urgencies', 'categories'));
        } else {
            return back()->with('error', 'No Results Found');
        }
    }

    public function linktickets(Request $request): View
    {
        $urgencies = Ticket::$urgencies;
        $categories = Ticket::$categories;
        $tickets = Ticket::find($request->linkedtickets); //Getting the Models Passed Selected By the Checkbox
        $users = User::all()->where('role_id', 2);

        $ticketIds = $tickets->pluck('id'); // Getting only the IDs of the Models

        try {
            foreach ($ticketIds as $ticketId) {
                if ($request->has('linkedtickets')) {
                    LinkedTicket::create([
                        'ticket_id' => $ticketId,
                        // 'linked_ticket_id' =>
                    ]);
                    // if (!$request->has('linkedticket')) {
                    //     $linkedTicket->delete();
                    // }
                }
            }
        } catch (QueryException $error) {
            return back()->with('Failed To Insert Data');
        }

        if ($request->has('viewtickets')) {
            if ($ticketIds) {
                return view('tickets.linked', compact('tickets', 'urgencies', 'categories'));
            } else {
                return back()->with('error', 'You Must Select At Least One Ticket');
            }
        } elseif ($request->has('edittickets')) {
            return view('tickets.edit-linked', compact('tickets', 'urgencies', 'users', 'categories'));
            dd($tickets);
        }
    }

    public function updatelinked(Request $request, string $tickets): RedirectResponse // NOT FULLY IMPLEMENTED
    {
        $ticketIds = Ticket::all()->where('id', $tickets);
        dd($ticketIds);
        foreach ($ticketIds as $ticket) {
            try {
                $users = User::all()->where('role_id', 2);
                $ticket->update($request->only(['title', 'details', 'assigned_to', 'logged_by', 'urgency', 'category', 'open']));

                if ($request->hasfile('file')) {
                    Storage::delete($ticket->file);
                    $ticket->file->update([
                        'name' => $request->file('file')->getClientOriginalName(),
                        'path' => $request->file('file')->store('public/files'),
                        'file_size' => $request->file('file')->getSize(),
                    ]);
                }

                Notification::send($users, new UpdatedTicketNotification($ticket), compact('ticket'));
            } catch (Exception $error) {
                return back()->with('error', 'Failed To Update Tickets');
            }
        }

        return redirect()->route('show.global.dashboard')->with('success', 'Tickets Updated Successfully');
    }
}
