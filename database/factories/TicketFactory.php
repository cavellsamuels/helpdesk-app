<?php

namespace Database\Factories;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->name,
            'details' => $this->faker->sentence(),
            'urgency' => $this->faker->randomNumber(1,4),
            'category' => $this->faker->randomNumber(1,4),
            'open' => $this->faker->boolean(),
            'logged_by' => $this->faker->name,
            'assigned_to' => $this->faker->randomNumber()
        ];
    }
}
