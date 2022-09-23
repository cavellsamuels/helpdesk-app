<?php

namespace App\Interfaces;

use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Models\Ticket;
use App\Services\FileService;
use Symfony\Component\HttpFoundation\StreamedResponse;

interface FileInterface
{
    public function download(Ticket $ticket): StreamedResponse;

    public function store(StoreTicketRequest $request, Ticket $ticket, FileService $fileService): void;

    public function update(UpdateTicketRequest $request, Ticket $ticket, FileService $fileService): void;
}
