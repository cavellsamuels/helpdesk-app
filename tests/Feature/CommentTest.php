<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Ticket;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    protected AuthUser $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = AuthUser::create(['first_name' => 'john', 'last_name' => 'doe', 'email' => 'test@test.com', 'password' => 'password', 'role_id' => 2]);
    }

    /** @test  */
    public function check_if_a_comment_can_be_added_by_a_guest()
    {
        $ticket = Ticket::factory()->create(['id' => 1]);
        $comment = Comment::factory()->create();

        $this->actingAs($this->user)->post(
            "comments/{$ticket->id}/store",
            [
                'details' => $comment->details,
            ]
        )
            ->assertValid()
            ->assertStatus(302);
    }

    /** @test  */
    public function check_if_a_comment_can_be_added_by_a_logged_in_user()
    {
        $ticket = Ticket::factory()->create(['id' => 1]);
        $comment = Comment::factory()->create();

        $this->actingAs($this->user)->post(
            "comments/{$ticket->id}/store",
            [
                'details' => $comment->details,
            ]
        )->assertValid();

        $this->assertDatabaseHas('comments', ['details' => $comment->details]);
    }

    /** @test  */
    public function check_if_a_comment_edit_view_can_be_loaded()
    {
        $ticket = Ticket::factory()->create(['id' => 1]);
        $comment = Comment::factory()->create(['details' => 'test', 'ticket_id' => 1]);

        $this->get("/comments/{$ticket->id}/edit/{$comment->id}")
            ->assertOk()
            ->assertSee('Test');
    }

    /** @test  */
    public function check_if_a_comment_can_be_updated()
    {
        $ticket = Ticket::factory()->create(['id' => 1]);
        $comment = Comment::factory()->create(['details' => 'test', 'ticket_id' => 1]);

        $this->put(
            "comments/{$ticket->id}/update/{$comment->id}",
            ['details' => 'test2']
        )->assertValid();

        $this->assertDatabaseHas('comments', ['details' => 'test2']);
    }

    /** @test  */
    public function check_if_a_comment_can_be_deleted()
    {
        $ticket = Ticket::factory()->create(['id' => 1]);
        $comment = Comment::factory()->create(['ticket_id' => 1]);

        $this->delete("/comments/{$ticket->id}/delete/{$comment->id}")
            ->assertValid()
            ->assertDontSee($comment);
    }
}
