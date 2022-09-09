<?php

namespace App\Services;

use App\Models\File;
use App\Models\Ticket;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;

class FileService
{

    public function createFile(Ticket $ticket, StoreTicketRequest $request): void
    {
        if ($request->hasfile('file')) {
            $request->file('file')->store('public/files');
            File::query()->create([
                'name' => $request->file('file')->getClientOriginalName(),
                'path' => $request->file('file')->getRealPath(),
                'size' => $request->file('file')->getSize(),
                'ticket_id' => $ticket->id,
            ]);
        }
    }

    public function updateFile(Ticket $ticket, UpdateTicketRequest $request): void
    {
        $ticketFile = $ticket->file;

        if ($request->hasfile('file')) {
            if ($ticketFile) {
                Storage::delete($ticketFile);
                $request->file('file')->store('public/files');
                $ticketFile->update([
                    'name' => $request->file('file')->getClientOriginalName(),
                    'path' => $request->file('file')->store('public/files'),
                    'size' => $request->file('file')->getSize(),
                ]);
            } else {
                $request->file('file')->store('public/files');
                File::query()->create([
                    'name' => $request->file('file')->getClientOriginalName(),
                    'path' => $request->file('file')->store('public/files'),
                    'size' => $request->file('file')->getSize(),
                    'ticket_id' => $ticket->id,
                ]);
            }
        }
    }
}
