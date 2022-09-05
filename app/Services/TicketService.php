<?php

namespace App\Services;

use App\Models\File;
use App\Models\User;
use App\Models\Ticket;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\FileController;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use Illuminate\Database\Eloquent\Collection;

class TicketService
{
    protected array $urgencies;

    protected array $categories;

    protected Collection $itSupportUsers;

    public function __construct()
    {
        $this->urgencies = Ticket::$urgencies;
        $this->categories = Ticket::$categories;
        $this->itSupportUsers = User::all()->where('role_id', 2);
    }

    public function createTicket(StoreTicketRequest $request, Ticket $ticket, FileController $fileController, FileService $fileService)
    {
        $ticket = Ticket::query()->create($request->only(['title', 'details', 'urgency', 'category', 'open', 'logged_by', 'assigned_to']));
        $fileController->store($ticket, $request, $fileService);
    }

    public function updateTicket(UpdateTicketRequest $request, Ticket $ticket, File $file, FileController $fileController, FileService $fileService)
    {
        $tickets = $ticket->update($request->only(['title', 'details', 'urgency', 'category', 'open', 'assigned_to']) + (['reporting_email' => now()]));

        if ($file) {
            $fileController->update($ticket, $request, $fileService);
        }

        // event (new TicketCreated($tickets));
    }

    public function deleteTicket(Ticket $ticket)
    {
        $ticket->delete();
        if ($ticket->file) {
            $ticket->file->delete();
            Storage::delete($ticket->file);
        }
    }
}
