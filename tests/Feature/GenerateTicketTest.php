<?php

namespace Tests\Feature;

use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GenerateTicketTest extends TestCase
{
    use RefreshDatabase;

    public function test_ticket_generation(): void
    {
        $this->artisan('ticket:generate')
            ->expectsOutput('Ticket generated successfully!')
            ->assertExitCode(0);

        $this->assertCount(1, Ticket::all());

        $ticket = Ticket::first();
        $this->assertNotNull($ticket->subject);
        $this->assertNotNull($ticket->content);
        $this->assertNotNull($ticket->name);
        $this->assertNotNull($ticket->email);
        $this->assertNotNull($ticket->created_at);
        $this->assertFalse($ticket->status === false);
    }
}
