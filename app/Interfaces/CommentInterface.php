<?php

namespace App\Interfaces;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\Ticket;
use App\Services\CommentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

interface CommentInterface
{
    public function store(CommentService $commentService, CommentRequest $request, Ticket $ticket): RedirectResponse;

    public function edit(Ticket $ticket, Comment $comment): View;

    public function update(CommentRequest $request, Ticket $ticket, Comment $comment): RedirectResponse;

    public function destroy(Ticket $ticket, Comment $comment): RedirectResponse;
}
