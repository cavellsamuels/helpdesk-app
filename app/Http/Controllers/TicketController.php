<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Models\Comment;
use App\Models\File;
use App\Models\Ticket;
use App\Models\User;
use App\Notifications\UpdatedTicketNotification;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Database\Schema\ForeignIdColumnDefinition;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Nette\Utils\Arrays;

class TicketController extends Controller
{
    protected $urgencies;
    protected $categories;
    protected $itSupportUsers;

    public function __construct()
    {
        $this->urgencies = Ticket::$urgencies;
        $this->categories = Ticket::$categories;
        $this->itSupportUsers = User::all()->where('role_id', 2);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $users = $this->itSupportUsers;
        $urgencies = $this->urgencies;
        $categories = $this->categories;

        return view('tickets.create', compact('users', 'urgencies', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTicketRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTicketRequest $request, Ticket $ticket, FileController $fileController): RedirectResponse
    {
        try {
            $ticket = Ticket::query()->create($request->only(['title', 'details', 'urgency', 'category', 'open', 'logged_by', 'assigned_to']));
            $fileController->store($ticket, $request);
        } catch (QueryException $error) {
            return back()->with('error', 'Ticket Unsuccessfully Added');
        }

        return redirect()->route('show.global.dashboard')->with('success', 'Ticket Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket, File $file): View
    {
        $users = $this->itSupportUsers;
        $urgencies = $this->urgencies;
        $categories = $this->categories;
        $comments = Comment::where('ticket_id', $ticket->id)->get();

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
        $users = $this->itSupportUsers;
        $urgencies = $this->urgencies;
        $categories = $this->categories;

        return view('tickets.edit', compact('ticket', 'users', 'urgencies', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTicketRequest  $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTicketRequest $request, Ticket $ticket, File $file, FileController $fileController): RedirectResponse
    {
        $users = $this->itSupportUsers;
        try {
            $ticket->update($request->only(['title', 'details', 'urgency', 'category', 'open', 'assigned_to']) + (['reporting_email' => now()]));

            if ($file == true) {
                $fileController->update($ticket, $request);
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
            if ($ticket->file) {
                Storage::delete($ticket->file->path); //Not Working
            }
        } catch (QueryException $error) {
            return back()->with('error', 'Ticket Not Deleted');
        }

        return back()->with('success', 'Ticket Deleted Successfully');
    }

    public function search(SearchRequest $request)
    {
        $urgencies = $this->urgencies;
        $categories = $this->categories;
        $search = $request->get('search');
        $ticketsId = Ticket::all()->where('id', $search);
        $ticketsTitle = Ticket::all()->where('title', $search);

        if (count($ticketsId) > 0 || count($ticketsTitle) > 0) {
            return view('search', compact('ticketsId', 'ticketsTitle', 'urgencies', 'categories'));
        } else {
            return back()->with('error', 'No Results Found');
        }
    }

    public function linktickets(Request $request)
    {
        $users = $this->itSupportUsers;
        $tickets = Ticket::find($request->linkedtickets);
        $urgencies = $this->urgencies;
        $categories = $this->categories;

        if ($tickets == true) {
            if ($request->has('viewtickets')) {
                redirect()->route('show.linked');
            } elseif ($request->has('edittickets')) {
                redirect()->route('edit.linked')->compact('tickets',);
            }
        } else {
            return back()->with('error', 'You Must Select At Least One Ticket');
        }
    }

    public function showLinked()
    {
        return view('tickets.linked', compact('tickets', 'urgencies', 'categories'));
    }

    public function showEditLinked()
    {
        return view('tickets.edit-linked', compact('users', 'tickets', 'urgencies', 'categories'));
    }

    public function updatelinked(Request $request, FileController $fileController, $tickets): RedirectResponse // NOT FULLY IMPLEMENTED
    {
        $users = $this->itSupportUsers;
        $tId = explode(',', $tickets);
        dd($tId);
        $ticketIds = Ticket::all()->where('id', $tickets);

        foreach ($ticketIds as $ticket) {
            try {
                $ticket->update($request->only(['title', 'details', 'assigned_to', 'logged_by', 'urgency', 'category', 'open']));
                $fileController->update($ticket, $request);

                Notification::send($users, new UpdatedTicketNotification($ticket), compact('ticket')); //Not Working
            } catch (Exception $error) {
                return back()->with('error', 'Failed To Update Tickets');
            }
        }

        return redirect()->route('show.global.dashboard')->with('success', 'Tickets Updated Successfully');
    }
}
