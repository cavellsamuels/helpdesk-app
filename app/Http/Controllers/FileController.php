<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;

class FileController extends Controller
{   
    // protected $fileName;
    // protected $filePath;
    // protected $fileSize;

    // public function __construct(Request $request)
    // {
    //     $this->fileName = $request->file('file')->getClientOriginalName();
    //     $this->filePath = $request->file('file')->store('public/files');
    //     $this->fileSize = $request->file('file')->getSize();
    // }

    public function download(Ticket $ticket, File $file)
    {
        return Storage::download($file->path, $file->name);
    }

    public function store(Ticket $ticket, StoreTicketRequest $request)
    {
        $file = $request->hasfile('file');

        if ($file == true) {
            File::query()->create([
                'name' => $request->file('file')->getClientOriginalName(),
                'path' => $request->file('file')->store('public/files'),
                'file_size' => $request->file('file')->getSize(),
                'ticket_id' => $ticket->id,
            ]);
        }
        compact('ticket');
    }

    public function update(Ticket $ticket, UpdateTicketRequest $request)
    {
        $ticketFile = $ticket->file;

        if ($request->hasfile('file')) {
            if ($ticketFile == true) {
                Storage::delete($ticketFile); // Not Working
                $ticketFile->update([
                    'name' => $request->file('file')->getClientOriginalName(),
                    'path' => $request->file('file')->store('public/files'),
                    'file_size' => $request->file('file')->getSize(),
                ]);
            } else {
                File::query()->create([
                    'name' => $request->file('file')->getClientOriginalName(),
                    'path' => $request->file('file')->store('public/files'),
                    'file_size' => $request->file('file')->getSize(),
                    'ticket_id' => $ticket->id,
                ]);
            }
        }
    }
}
