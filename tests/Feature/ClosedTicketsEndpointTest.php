<?php

namespace Tests\Feature;

use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClosedTicketsEndpointTest extends TestCase
{
    use refreshDatabase;
    public function test_closed_tickets_endpoint(): void
    {
        Ticket::factory()->count(15)->create(['status' => true]);
        $response = $this->getJson('/api/tickets/closed');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'current_page',
            'data' => [
                '*' => [
                    'subject',
                    'content',
                    'name',
                    'email',
                    'status',
                    'created_at',
                ],
            ],
            'links',
        ]);
        $response->assertJsonFragment(['status' => true]);
    }
}
