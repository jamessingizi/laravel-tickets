<?php

namespace Tests\Feature;

use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OpenTicketsEndpointTest extends TestCase
{
    use RefreshDatabase;
    public function test_example(): void
    {
        Ticket::factory()->count(15)->create(['status' => false]);
        $response = $this->getJson('/api/tickets/open');
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
        $response->assertJsonFragment(['status' => false]);
    }

}
