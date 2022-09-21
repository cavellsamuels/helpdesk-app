<?php

namespace App\Interfaces;

use App\Models\Ticket;
use App\Services\FileService;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use Symfony\Component\HttpFoundation\StreamedResponse;

interface FileInterface
{
    public function download(Ticket $ticket): StreamedResponse;
    public function store(StoreTicketRequest $request, Ticket $ticket, FileService $fileService) : void;
    public function update(UpdateTicketRequest $request, Ticket $ticket, FileService $fileService): void;
}