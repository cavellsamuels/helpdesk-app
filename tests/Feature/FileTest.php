<?php

namespace Tests\Feature;

use App\Models\File;
use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function check_if_files_can_be_uploaded_to_the_database(): void
    {
        $this->post('files', [
            $file = File::factory()->create(['name' => 'hello', 'size' => 1000, 'ticket_id' => 1]),
        ]);

        $this->assertDatabaseHas('files', [
            'name'      => 'hello',
            'path'      => $file->path,
            'size'      => 1000,
            'ticket_id' => 1,
        ]);
    }

    /** @test */
    public function check_if_a_file_can_be_uploaded_to_the_storage_folder(): void
    {
        $file = FIle::factory()->create();
        Storage::fake('local');

        $this->json('POST', '/local', [
            UploadedFile::fake()->image($file),
        ]);

        Storage::disk('local');
        $this->assertFileExists($file->path);
    }

    /** @test  */
    public function check_if_a_file_can_be_updated(): void
    {
        $ticket = Ticket::factory()->create(['id' => 1]);
        File::factory()->create(['name' => 'Hello', 'ticket_id' => 1]);

        $this->put(
            "tickets/update/{$ticket->id}",
            [
                'title'   => 'hello',
                'urgency' => 2,
                $ticket->file,
            ]
        )->assertValid();

        $this->assertDatabaseHas('files', ['name' => $ticket->file->name]);
    }

    /** @test */
    public function check_if_files_can_be_downloaded(): void
    {
        $ticket = Ticket::factory()->create(['id' => 1]);
        $file = File::factory()->create(['name' => 'image.jpg', 'ticket_id' => 1]);

        $response = $this->get("tickets/{$ticket->id}/download/{$file->id}");

        $response->assertRedirect();
    }
}
