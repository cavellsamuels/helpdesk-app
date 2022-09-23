<?php

namespace Tests\Feature;

use App\Models\Ticket;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TicketTest extends TestCase
{
    use RefreshDatabase;

    protected AuthUser $user;

    protected Ticket $ticket;

    public function setUp(): void
    {
        parent::setup();

        $this->user = AuthUser::create(['first_name' => 'john', 'last_name' => 'doe', 'email' => 'test@test.com', 'password' => 'password', 'role_id' => 2]);
    }

    /** @test  */
    public function create_ticket_view_can_be_loaded()
    {
        $this->get(route('create.ticket'))
            ->assertOk()
            ->assertSee('Create Ticket');
    }

    /** @test  */
    public function check_if_a_ticket_has_a_title()
    {
        $this->ticket = new Ticket(['title' => 'Problem With Router']);
        $this->assertEquals('Problem With Router', $this->ticket->title);
    }

    /** @test  */
    public function a_ticket_can_be_added_through_the_form_by_a_guest_without_a_file()
    {
        $ticket = Ticket::factory()->create();

        $this->post(
            'tickets/store',
            [
                'title'     => $ticket->title,
                'details'   => $ticket->details,
                'logged_by' => $ticket->logged_by,
                'urgency'   => $ticket->urgency,
                'category'  => $ticket->category,
                'open'      => $ticket->open,
            ]
        )->assertValid();

        $this->assertDatabaseHas('tickets', ['details' => $ticket->details]);
    }

    /** @test  */
    public function a_ticket_can_be_added_through_the_form_by_an_authenticated_user_without_a_file()
    {
        $ticket = Ticket::factory()->create();

        $this->actingAs($this->user)->post(
            'tickets/store',
            [
                'title'       => $ticket->title,
                'details'     => $ticket->details,
                'logged_by'   => $ticket->logged_by,
                'urgency'     => $ticket->urgency,
                'category'    => $ticket->category,
                'open'        => $ticket->open,
                'assigned_to' => $ticket->open,
            ]
        )->assertValid();
    }

    /** @test  */
    public function ticket_details_can_be_displayed_from_the_show_page()
    {
        $ticket = Ticket::factory()->create();

        $this->get("tickets/{$ticket->id}/show")
            ->assertStatus(200)
            ->assertSee($ticket->name);
    }

    /** @test  */
    public function a_ticket_can_be_updated_through_the_form_without_a_file()
    {
        $ticket = Ticket::factory()->create(['title' => 'world', 'urgency' => 1]);

        $this->put(
            "tickets/{$ticket->id}/update",
            [
                'title'   => 'hello',
                'urgency' => 2,
            ]
        );
        $this->get(route('show.global.dashboard'))
            ->assertOk()
            ->assertSee('hello');
    }

    /** @test  */
    public function a_ticket_can_be_deleted()
    {
        $ticket = Ticket::factory()->create(['title' => 'Hello']);

        $this->delete("/tickets/{$ticket->id}/delete")->assertValid()
            ->assertDontSee($ticket);

        $this->assertDatabaseHas('tickets', ['title' => $ticket->title]);
    }

    //NOT WORKING
    /** @test  */
    // public function see_if_correct_search_results_are_displayed()
    // {
    //     $this->actingAs($this->user);

    //     $ticket = Ticket::factory()->create(['id' => 1, 'title' => 'Login Issue']);
    //     $search = 1;

    //     //get the model inputted in search

    //     $$this->get(route('search.ticket'))->assertStatus(302)
    //         ->assertSee('Login Issue');
    // }
}
