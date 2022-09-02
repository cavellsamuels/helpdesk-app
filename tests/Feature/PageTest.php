<?php

namespace Tests\Feature;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    /** @test  */
    public function show_global_dashboard_with_appropriate_models_passed_in()
    {
        $ticket = Ticket::factory()->create(['title' => 'Login Issue']);
        $ticket2 = Ticket::factory()->create(['title' => 'Register Issue']);

        $response = $this->get(route('show.global.dashboard'))
            ->assertSee('Login Issue')
            ->assertSee('Register Issue')
            ->assertSee('Important')
            ->assertOk();
    }

    /** @test  */
    public function show_dashboard_with_only_assigned_tickets()
    {
        $user = User::factory()->create(['id' => 1]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();

        $tickets = Ticket::factory()->create(['title' => 'Equipment Error', 'assigned_to' => 1]);
        // $ticket = Ticket::factory()->create(['title' => 'Desktop Error', 'assigned_to' => null]);

        $response = $this->get(route('show.assigned.dashboard'))
            ->assertSee('Equipment Error')
            // ->assertSee('Desktop Error')
            ->assertOk();
    }

    /** @test  */
    public function show_dashboard_with_unassigned_tickets()
    {
        $user = User::factory()->create(['id' => 1]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();

        // $tickets = Ticket::factory()->create(['title' => 'Equipment Error', 'assigned_to' => 1]);
        $ticket = Ticket::factory()->create(['title' => 'Desktop Error', 'assigned_to' => null]);

        $response = $this->get(route('show.unassigned.dashboard'))
            // ->assertSee('Equipment Error')
            ->assertSee('Desktop Error')
            ->assertOk();
    }
}
