<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Comment;
use Illuminate\View\View;
use App\Services\FileService;
use App\Services\TicketService;
use App\Interfaces\TicketInterface;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;

class TicketController extends Controller implements TicketInterface
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        return view('tickets.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTicketRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTicketRequest $request, TicketService $ticketService, Ticket $ticket, FileController $fileController, FileService $fileService): RedirectResponse
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
    public function show(Ticket $ticket): View
    {
        // $comments = Comment::where('ticket_id', $ticket->id)->get();

        return view('tickets.show', compact('ticket', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket): View
    {
        return view('tickets.edit', compact('ticket'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTicketRequest  $request
     * @param  \App\Models\Ticket  $ticketlinked.
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTicketRequest $request, TicketService $ticketService, Ticket $ticket, FileController $fileController, FileService $fileService): RedirectResponse
    {
        $ticketService->updateTicket($request, $ticket, $fileController, $fileService);

        return redirect()->route('show.global.dashboard')->with('success', 'Ticket Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(TicketService $ticketService, Ticket $ticket): RedirectResponse
    {
        $ticketService->deleteTicket($ticket);

        return back()->with('success', 'Ticket Deleted Successfully');
    }
}
