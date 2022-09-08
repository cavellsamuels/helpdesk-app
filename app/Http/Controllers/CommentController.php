<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Comment;
use Illuminate\View\View;
use App\Services\CommentService;
use App\Interfaces\CommentInterface;
use App\Http\Requests\CommentRequest;
use Illuminate\Http\RedirectResponse;

class CommentController extends Controller implements CommentInterface
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CommentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommentService $commentService, CommentRequest $request, Ticket $ticket): RedirectResponse
    {
        $commentService->createComment($request, $ticket);

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
     * @param  \App\Http\Requests\CommentRequest  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(CommentRequest $request, Ticket $ticket, Comment $comment): RedirectResponse
    {
        $comment->update(['details' => $request->details]);

        return redirect()->route('show.ticket', $ticket->id)->with('updatesuccess', 'Comment Sucessfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket, Comment $comment): RedirectResponse
    {
        $comment->delete();

        return back()->with('success', 'Comment Successfully Deleted');
    }
}
