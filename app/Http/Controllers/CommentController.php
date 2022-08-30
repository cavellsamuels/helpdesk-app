<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Comment;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCommentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCommentRequest $request, Ticket $ticket, Comment $comment, User $user): RedirectResponse
    {
        try {
            if (Auth::user() == true) {
                Comment::query()->create([
                    'ticket_id' => $ticket->id,
                    'details' => $request->details,
                    'created_by' => Auth::user()->id,
                ]);
            } else {
                Comment::query()->create([
                    'ticket_id' => $ticket->id,
                    'details' => $request->details,
                ]);
            }
        } catch (QueryException $error) {
            return back()->with('error', 'Please Write A Comment');
        }

        return back()->with('success', 'Comment Added Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket, Comment $comment): View
    {
        return view('comments.edit', compact('ticket', 'comment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCommentRequest  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCommentRequest $request, Ticket $ticket, Comment $comment): RedirectResponse
    {
        try {
            $comment->update([
                'details' => $request->details,
            ]);
        } catch (QueryException $error) {
            return back()->with('error', 'Comment Could\'nt Update');
        }

        return redirect()->route('show.ticket', $ticket->id)->with('updatesuccess', 'Comment Sucessfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function delete(Ticket $ticket, Comment $comment): RedirectResponse
    {
        try {
            $comment->delete();
        } catch (QueryException $error) {
            return back()->with('error', 'Failed To Delete Comment');
        }

        return back()->with('success', 'Comment Successfully Deleted');
    }
}
