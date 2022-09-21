<?php

namespace App\Services;

use App\Models\Ticket;
use App\Models\Linked;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\FileController;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;

class TicketService
{
    public function createTicket(StoreTicketRequest $request, Ticket $ticket, FileController $fileController, FileService $fileService): void
    {
        $ticket = Ticket::query()->create($request->only(['title', 'details', 'urgency', 'category', 'open', 'logged_by', 'assigned_to']));
        $fileController->store($request, $ticket, $fileService);
    }

    public function updateTicket(UpdateTicketRequest $request, Ticket $ticket, FileController $fileController, FileService $fileService): void
    {
        $ticket->update($request->only(['title', 'details', 'urgency', 'category', 'open', 'assigned_to']) + (['reporting_email' => now()]));
        $fileController->update($request, $ticket, $fileService);

        $getLinkedTicket = $request->get('linkticket');
        $parentTicket = Linked::where('parent_ticket', $ticket->id)->value('id');
        $childTicket = Ticket::find($getLinkedTicket);

        if ($getLinkedTicket) {
            if (count(Linked::where('parent_ticket', $ticket->id)->where('child_ticket', $getLinkedTicket)->get()) == 0) {
                if ($parentTicket) {
                    Linked::find($parentTicket)->delete();
                }
                Linked::create(['parent_ticket' => $ticket->id, 'child_ticket' => $getLinkedTicket]);
            }
            $childTicket->update($request->only(['title', 'details', 'urgency', 'category', 'open', 'assigned_to']) + (['reporting_email' => now()]));
            $fileController->update($request, $childTicket, $fileService);
        } elseif ($getLinkedTicket == null) {
            if ($parentTicket) {
                Linked::find($parentTicket)->delete();
            }
        }
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
