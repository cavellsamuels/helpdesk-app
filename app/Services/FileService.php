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
        $file = $request->hasfile('file');

        if ($file) {
            $request->file('file')->store('public/files');
            File::query()->create($request->validated() + [
                'name' => $request->file('file')->getClientOriginalName(),
                'file_size' => $request->file('file')->getSize(),
                'ticket_id' => $ticket->id,
            ]);
        }
    }

    public function updateFile(Ticket $ticket, UpdateTicketRequest $request): void
    {
        $ticketFile = $ticket->file;

        if ($request->hasfile('file')) {
            Storage::delete($ticketFile);
            if ($ticketFile) {
                $request->file('file')->store('public/files');
                $ticketFile->update([
                    'name' => $request->file('file')->getClientOriginalName(),
                    'file_size' => $request->file('file')->getSize(),
                ]);
            } else {
                $request->file('file')->store('public/files');
                File::query()->create([
                    'name' => $request->file('file')->getClientOriginalName(),
                    'file_size' => $request->file('file')->getSize(),
                    'ticket_id' => $ticket->id,
                ]);
            }
        }
    }
}
