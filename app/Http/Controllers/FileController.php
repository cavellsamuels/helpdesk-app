<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Services\FileService;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;

class FileController extends Controller
{
    public function download(Ticket $ticket)
    {
        return Storage::download($ticket->file->path, $ticket->file->name);
    }

    public function store(Ticket $ticket, StoreTicketRequest $request, FileService $fileService)
    {
        $fileService->createFile($ticket, $request);
    }   

    public function update(Ticket $ticket, UpdateTicketRequest $request, FileService $fileService)
    {
        $fileService->updateFile($ticket, $request);
    }
}
