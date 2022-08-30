<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class TicketTest extends TestCase
{
    use RefreshDatabase;
    // use WithoutMiddleware;

    protected $ticket;

    /** @test  */
    public function ticket_has_title()
    {
        $this->ticket = new Ticket(['title' => 'Problem With Router']);
        $this->assertEquals('Problem With Router', $this->ticket->title);
    }

    // Create
    /** @test  */
    public function a_ticket_can_be_added_through_the_form_by_a_guest()
    {
        $this->post(
            'tickets/store',
            [
                'title' => 'Mike',
                'details' => 'Joe',
                'logged_by' => 'test@test.com',
                'assigned_to' => 2,
                'urgency' => 2,
                'category' => 1,
                'open' => 1,
            ]
        );
        $response = $this->get('/')
            ->assertStatus(200);
    }

    /** @test  */
    public function a_ticket_can_be_added_through_the_form_by_an_authenticated_user()
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
                'title' => 'Mike',
                'details' => 'Joe',
                'logged_by' => 'test@test.com',
                'assigned_to' => 2,
                'urgency' => 2,
                'category' => 1,
                'open' => 1,
            ]
        );
        $response = $this->get('/dashboard')
            ->assertStatus(200);
    }

    //Read
    /** @test  */
    public function show_ticket_details()
    {
        $ticket = Ticket::factory()->create();
        $this->get('/show{ticket}')
            ->assertStatus(200);
    }

    // Update


    // Delete
    /** @test  */
    public function delete_a_ticket()
    {
        $ticket = Ticket::factory()->create();

        $this->assertModelExists($ticket);
    }















    // /** @test  */
    // public function a_ticket_can_be_updated_through_the_form()
    // {
    //     $this->withoutExceptionHandling();

    //     $user = User::factory()->create();

    //     $response = $this->post('/login', [
    //         'email' => $user->email,
    //         'password' => 'password',
    //     ]);

    //     $this->assertAuthenticated();

    //     $ticket = Ticket::factory()->create(['title' => 'example title']);

    //     $this->put("/update/{$ticket}", ['title' => 'example title 2'])
    //         ->assertStatus(200);
    //     // ->assert(['title' => 'example title 2']);
    // }

    // $this->put(
    //     'tickets/update/{ticket}',
    //     [
    //         'title' => 'GG',
    //         'details' => 'hh',
    //         'logged_by' => 'test@test.com',
    //         'assigned_to' => 2,
    //         'urgency' => 2,
    //         'category' => 1,
    //         'open' => 1,
    //     ]
    // );

    // $response = $this->get('/dashboard')
    //     ->assertStatus(200);

    /** @test  */
    // public function a_ticket_can_be_deleted()
    // {
    //     $this->withoutExceptionHandling();

    //     $user = User::factory()->create();

    //     $response = $this->post('/login', [
    //         'email' => $user->email,
    //         'password' => 'password',
    //     ]);

    //     $this->;

    //     $this->assertAuthenticated();

    //     $ticket = Ticket::factory();

    // }
}
