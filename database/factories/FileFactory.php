<?php

namespace Database\Factories;

use App\Models\File;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\WithFaker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\File>
 */
class FileFactory extends Factory
{
    use WithFaker;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->fileExtension(),
            'path' => $this->faker->filePath(),
            'file_size' => $this->faker->randomNumber(),
            'ticket_id' => Ticket::factory(),
        ];
    }
}
