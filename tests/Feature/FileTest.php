<?php

namespace Tests\Feature;

use App\Models\File;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function check_if_files_can_be_downloaded()
    {
        $ticket = Ticket::factory()->create(['id' => 1]);
        $file = File::factory()->create(['name' => 'image.jpg', 'ticket_id' => 1]);

        $response = $this->get("tickets/show/{$ticket->id}");
        $response->assertOk();

        $this->get("tickets/{$ticket->id}/download/{$file}");

        $response = $this->get("tickets/show/{$ticket->id}");
        $response->assertOk();
    }

    /** @test */
    public function check_if_files_can_be_uploaded_to_the_database()
    {
        $this->post('files', [
            File::factory()->create(['name' => 'hello']),
        ]);
        $this->get(route('show.global.dashboard'))
            ->assertOk();

        $this->assertDatabaseHas('files', [
            'name' => 'hello',
        ]);
    }

    /** @test */
    public function check_if_a_file_can_be_uploaded_to_the_storage_folder()
    {
        Storage::fake('local');

        $ticket = Ticket::factory()->create(['id' => 1]);
        $file = UploadedFile::fake(File::factory()->create(['ticket_id' => 1]));

        $response = $this->post('/files', [
            'file' => $file,
        ]);

        Storage::disk('local');
        $this->assertFileExists("{$ticket->file->path}");
    }

    /** @test  */
    public function check_if_a_file_can_be_updated()
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();

        $ticket = Ticket::factory()->create(['id' => 1]);
        $file = File::factory()->create(['name' => 'Hello', 'ticket_id' => 1]);

        $this->put(
            "tickets/update/{$ticket->id}",
            [
                'title' => 'hello',
                'urgency' => 2,
                $ticket->file,
            ]
        );

        $this->get(route('show.global.dashboard'))
            ->assertOk();
    }
}
