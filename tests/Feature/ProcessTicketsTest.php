<?php

namespace Tests\Feature;

use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProcessTicketsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function ticket_processing(): void
    {
        // Create 7 tickets with status false and different created_at timestamps
        $tickets = Ticket::factory()->count(7)->create(['status' => 0]);
        $tickets = $tickets->sortBy('created_at');

        $this->artisan('ticket:process')
            ->expectsOutput('5 ticket(s) processed successfully!')
            ->assertExitCode(0);

        // Assert that the first 5 tickets are processed
        foreach ($tickets->take(5) as $ticket) {
            $ticket->refresh();
            $this->assertTrue($ticket->status);
        }

        // Assert that the remaining 2 tickets are not processed
        foreach ($tickets->skip(5) as $ticket) {
            $ticket->refresh();
            $this->assertFalse($ticket->status);
        }
    }
}
