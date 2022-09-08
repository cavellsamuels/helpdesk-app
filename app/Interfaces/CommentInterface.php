<?php

namespace App\Interfaces;

use App\Models\Ticket;
use App\Models\Comment;
use Illuminate\View\View;
use App\Services\CommentService;
use App\Http\Requests\CommentRequest;
use Illuminate\Http\RedirectResponse;

interface CommentInterface
{
    public function store(CommentService $commentService, CommentRequest $request, Ticket $ticket): RedirectResponse;
    public function edit(Ticket $ticket, Comment $comment): View;
    public function update(CommentRequest $request, Ticket $ticket, Comment $comment): RedirectResponse;
    public function destroy(Ticket $ticket, Comment $comment): RedirectResponse;
}