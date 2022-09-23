<?php

namespace App\Interfaces;

use App\Http\Controllers\FileController;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Models\Ticket;
use App\Services\FileService;
use App\Services\TicketService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

interface TicketInterface
{
    public function create(): View;

    public function store(StoreTicketRequest $request, TicketService $ticketService, Ticket $ticket, FileController $fileController, FileService $fileServic): RedirectResponse;

    public function show(Ticket $ticket): View;

    public function edit(Ticket $ticket): View;

    public function update(UpdateTicketRequest $request, TicketService $ticketService, Ticket $ticket, FileController $fileController, FileService $fileService): RedirectResponse;

    public function destroy(TicketService $ticketService, Ticket $ticket): RedirectResponse;
}
