<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /** @test  */
    public function check_if_a_comment_can_be_added_by_a_guest()
    {
        $ticket = Ticket::factory()->create(['id' => 1]);

        $response = $this->get("tickets/show/{$ticket->id}")
            ->assertOk();

        $this->post(
            "comments/{$ticket->id}/store",
            [
                Comment::factory()->create(),
            ]
        );
    }

    /** @test  */
    public function check_if_a_comment_can_be_added_by_a_logged_in_user()
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();

        $ticket = Ticket::factory()->create(['id' => 1]);

        $response = $this->get("tickets/show/{$ticket->id}")
            ->assertOk();

        $this->post(
            "comments/{$ticket->id}/store",
            [
                Comment::factory()->create(),
            ]
        );
    }

    /** @test  */
    public function check_if_a_comment_edit_view_can_be_loaded()
    {
        $ticket = Ticket::factory()->create(['id' => 1]);
        $comment = Comment::factory()->create(['details' => 'test', 'ticket_id' => 1]);

        $this->get("tickets/show/{$ticket->id}")
            ->assertOk();

        $this->get("/comments/{$ticket->id}/edit/{$comment->id}")
            ->assertOk()
            ->assertSee('Test');
    }

    /** @test  */
    public function check_if_a_comment_can_be_updated()
    {
        $ticket = Ticket::factory()->create(['id' => 1]);
        $comment = Comment::factory()->create(['details' => 'test', 'ticket_id' => 1]);

        $response = $this->get("tickets/show/{$ticket->id}");

        $response = $this->get("/comments/{$ticket->id}/edit/{$comment->id}");

        $response = $this->put(
            "comments/{$ticket->id}/update/{$comment->id}",
            ['details' => 'test2']
        )->assertRedirect("tickets/show/{$ticket->id}");
    }

    /** @test  */
    public function check_if_a_comment_can_be_deleted()
    {
        $ticket = Ticket::factory()->create(['id' => 1]);
        $comment = Comment::factory()->create(['ticket_id' => 1]);

        $response = $this->get("tickets/show/{$ticket->id}")
            ->assertOk();

        $this->delete("/comments/{$ticket->id}/delete/{$comment->id}");

        $this->get("tickets/show/{$ticket->id}")
            ->assertOk();
    }
}
