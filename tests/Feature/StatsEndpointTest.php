<?php

namespace Tests\Feature;

use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StatsEndpointTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function stats_endpoint(): void
    {
        Ticket::factory()->count(5)->create(['status' => true]);
        Ticket::factory()->count(3)->create(['status' => false]);

        $response = $this->getJson('/api/stats');

        $response->assertStatus(200);

        // Assert response structure and content
        $response->assertJsonStructure([
            'total_tickets',
            'total_unprocessed_tickets',
            'user_with_most_tickets',
            'last_processed_ticket_time',
        ]);
    }
}
