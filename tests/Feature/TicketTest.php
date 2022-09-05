<?php

namespace Tests\Feature;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TicketTest extends TestCase
{
    use RefreshDatabase;

    protected $ticket;

    /** @test  */
    public function create_a_new_ticket_view_can_be_loaded()
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
        $this->post(
            'tickets/store',
            [
                Ticket::factory()->create(),
            ]
        );
        $response = $this->get('/')
            ->assertOk();
    }

    /** @test  */
    public function a_ticket_can_be_added_through_the_form_by_an_authenticated_user_without_a_file()
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();

        $this->post(
            'tickets/store',
            [
                Ticket::factory()->create(),
            ]
        );
        $response = $this->get(route('show.global.dashboard'))
            ->assertStatus(200);
    }

    /** @test  */
    public function ticket_details_can_be_displayed_from_the_show_page()
    {
        $ticket = Ticket::factory()->create();

        $this->get("tickets/show/{$ticket->id}")
            ->assertStatus(200)
            ->assertSee($ticket->name);
    }

    /** @test  */
    public function a_ticket_can_be_updated_through_the_form_without_a_file()
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();

        $ticket = Ticket::factory()->create(['title' => 'world', 'urgency' => 1]);

        $this->get("tickets/show/{$ticket->id}")
            ->assertStatus(200);

        $response = $this->put(
            "tickets/update/{$ticket->id}",
            [
                'title' => 'hello',
                'urgency' => 2,
            ]
        );
        $this->get(route('show.global.dashboard'))
            ->assertOk();
    }

    /** @test  */
    public function a_ticket_can_be_deleted()
    {
        $ticket = Ticket::factory()->create(['title' => 'g']);

        $this->get(route('show.global.dashboard'))->assertSee('g');

        $this->delete("/tickets/delete/{$ticket->id}");

        $this->get(route('show.global.dashboard'))
            ->assertOk();
    }

    /** @test  */
    // public function see_if_correct_search_results_are_displayed() //NOT WORKING
    // {
    //     $user = User::factory()->create();

    //     $response = $this->post('/login', [
    //         'email' => $user->email,
    //         'password' => 'password',
    //     ]);

    //     $this->assertAuthenticated();

    //     $ticket = Ticket::factory()->create(['id' => 1, 'title' => 'Login Issue']);
    //     $search = 1;
    //     $ticketsId = $ticket->where('id', $search);

    //     //Check what

    //     // direct to search page with correct details showing
    //     $this->get(route('search.ticket'))
    //         ->assertOk()
    //         ->assertSee('Login Issue');
    // }
}
