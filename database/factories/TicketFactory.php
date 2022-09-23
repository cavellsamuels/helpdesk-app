<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\File;
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
            'title'       => $this->faker->name,
            'details'     => $this->faker->sentence(),
            'urgency'     => 2,
            'category'    => 1,
            'open'        => $this->faker->boolean(),
            'logged_by'   => $this->faker->name,
            'assigned_to' => $this->faker->randomNumber(),
        ];
    }

    public function file()
    {
        File::factory()->create();
    }

    public function comment()
    {
        Comment::factory()->create();
    }
}
