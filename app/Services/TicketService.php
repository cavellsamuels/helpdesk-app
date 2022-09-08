<?php

namespace App\Services;

use App\Models\Ticket;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\FileController;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;

class TicketService
{
    public function createTicket(StoreTicketRequest $request, Ticket $ticket, FileController $fileController, FileService $fileService): void
    {
        $ticket = Ticket::query()->create($request->only(['title', 'details', 'urgency', 'category', 'open', 'logged_by', 'assigned_to']));
        $fileController->store($ticket, $request, $fileService);
    }

    public function updateTicket(UpdateTicketRequest $request, Ticket $ticket, FileController $fileController, FileService $fileService): void
    {
        $ticket->update($request->only(['title', 'details', 'urgency', 'category', 'open', 'assigned_to']) + (['reporting_email' => now()]));
        $fileController->update($ticket, $request, $fileService);
    }

    public function deleteTicket(Ticket $ticket): void
    {
        $ticket->delete();
        if ($ticket->file) {
            $ticket->file->delete();
            Storage::delete($ticket->file);
        }
    }
}
