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
        $fileController->store($ticket, $request, $fileService);
    }

    public function updateTicket(UpdateTicketRequest $request, Ticket $ticket, FileController $fileController, FileService $fileService): void
    {
        $ticket->update($request->only(['title', 'details', 'urgency', 'category', 'open', 'assigned_to']) + (['reporting_email' => now()]));
        $fileController->update($ticket, $request, $fileService);

        $getLinkedTicket = $request->get('linkticket'); // Get The Selected Ticket

        if ($getLinkedTicket) { //If a Ticket is Selected
            if (count(Linked::where('parent_ticket', $ticket->id)->where('child_ticket', $getLinkedTicket)->get()) == 0) { // Check if Datavase already contains the link
                $parentTicket = Linked::where('parent_ticket', $ticket->id)->value('id');
                if ($parentTicket) {
                    Linked::find($parentTicket)->delete();
                }
                Linked::create(['parent_ticket' => $ticket->id, 'child_ticket' => $getLinkedTicket]);  // if the link doesnt exist already create the link in the database
            }
            $childTicket = Ticket::find($getLinkedTicket); //find the Ticket which is equal to the selected ticket in the dropdown
            $childTicket->update($request->only(['title', 'details', 'urgency', 'category', 'open', 'assigned_to']) + (['reporting_email' => now()]));
            $fileController->update($childTicket, $request, $fileService);
        } elseif ($getLinkedTicket == null) {
            $parentTicket = Linked::where('parent_ticket', $ticket->id)->value('id');
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
