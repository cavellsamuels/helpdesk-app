<?php

namespace App\Services;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class CommentService
{
    public function createComment(CommentRequest $request, Ticket $ticket): void
    {
        if (Auth::user()) {
            Comment::query()->create(['ticket_id' => $ticket->id, 'details' => $request->details, 'created_by' => Auth::user()->id]);
        } else {
            Comment::query()->create(['ticket_id' => $ticket->id, 'details' => $request->details]);
        }
    }
}
