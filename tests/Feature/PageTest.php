<?php

namespace Tests\Feature;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageTest extends TestCase
{
    use RefreshDatabase;

    protected AuthUser $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = AuthUser::create(['id' => 1, 'first_name' => 'john', 'last_name' => 'doe', 'email' => 'test@test.com', 'password' => 'password', 'role_id' => 2]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */

    /** @test  */
    public function show_global_dashboard_with_appropriate_models_passed_in(): void
    {
        Ticket::factory()->create(['title' => 'Login Issue']);
        Ticket::factory()->create(['title' => 'Register Issue']);

        $this->get(route('show.global.dashboard'))
            ->assertOk()
            ->assertSee('Login Issue')
            ->assertSee('Register Issue')
            ->assertSee('Important');
    }

    /** @test  */
    public function show_dashboard_with_tickets_assigned_to_logged_in_user(): void
    {
        $user = User::factory()->create(['id' => 1]);
        Ticket::factory()->create(['title' => 'Equipment Error', 'assigned_to' => 1]);
        Ticket::factory()->create(['title' => 'Desktop Error', 'assigned_to' => null]);

        $this->post('/login', [
            'email'    => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();

        $this->get(route('show.assigned.dashboard'))
            ->assertSee('Equipment Error')
            ->assertDontSee('Desktop Error')
            ->assertOk();
    }

    /** @test  */
    public function show_dashboard_with_all_unassigned_tickets(): void
    {
        Ticket::factory()->create(['title' => 'Equipment Error', 'assigned_to' => 1]);
        Ticket::factory()->create(['title' => 'Desktop Error', 'assigned_to' => null]);

        $this->actingAs($this->user)->get(route('show.unassigned.dashboard'))
            ->assertDontSee('Equipment Error')
            ->assertSee('Desktop Error')
            ->assertOk();
    }
}
