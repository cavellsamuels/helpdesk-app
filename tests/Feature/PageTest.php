<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Ticket;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PageTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function show_index_with_appropriate_models_passed_in()
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        $tickets = Ticket::all();
        
    }
}
