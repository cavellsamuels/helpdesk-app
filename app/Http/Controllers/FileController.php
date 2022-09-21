<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Services\FileService;
use App\Interfaces\FileInterface;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FileController extends Controller implements FileInterface
{
    public function download(Ticket $ticket): StreamedResponse
    {
        return Storage::download($ticket->file->path, $ticket->file->name);
    }

    public function store(StoreTicketRequest $request, Ticket $ticket,  FileService $fileService) : void
    {
        $fileService->createFile($ticket, $request);
    }   

    public function update(UpdateTicketRequest $request, Ticket $ticket, FileService $fileService): void
    {
        $fileService->updateFile($ticket, $request);
    }
}