<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Comment;
use App\Services\FileService;
use App\Services\TicketService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use Illuminate\Database\Eloquent\Collection;

class TicketController extends Controller
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        return view('tickets.create', ['users' => $this->itSupportUsers, 'urgencies' => $this->urgencies, 'categories' => $this->categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTicketRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TicketService $ticketService, StoreTicketRequest $request, Ticket $ticket, FileController $fileController, FileService $fileService): RedirectResponse
    {
        $ticketService->createTicket($request, $ticket, $fileController, $fileService);

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
        $comments = Comment::where('ticket_id', $ticket->id)->get();

        return view('tickets.show', compact('ticket', 'file', 'comments'), ['users' => $this->itSupportUsers, 'urgencies' => $this->urgencies, 'categories' => $this->categories]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket): View
    {
        return view('tickets.edit', compact('ticket'), ['users' => $this->itSupportUsers, 'urgencies' => $this->urgencies, 'categories' => $this->categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTicketRequest  $request
     * @param  \App\Models\Ticket  $ticketlinked.
     * @return \Illuminate\Http\Response
     */
    public function update(TicketService $ticketService, FileService $fileService, UpdateTicketRequest $request, Ticket $ticket, File $file, FileController $fileController): RedirectResponse
    {
        $ticketService->updateTicket($request, $ticket, $file, $fileController, $fileService);

        return redirect()->route('show.global.dashboard')->with('success', 'Ticket Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function delete(TicketService $ticketService, Ticket $ticket): RedirectResponse
    {
        $ticketService->deleteTicket($ticket);

        return back()->with('success', 'Ticket Deleted Successfully');
    }
}
