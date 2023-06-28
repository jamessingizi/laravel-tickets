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
        $userEmail = 'user@example.com';
        $name = 'John Doe';
        Ticket::factory()
            ->count(10)
            ->create(['status' => true, 'email' => $userEmail, 'name' => $name]);
        $response = $this->getJson('/api/tickets/closed');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'subject',
                    'content',
                    'name',
                    'email',
                    'status',
                    'created_at',
                    'updated_at',
                ],
            ],
            'links' => [
                'first',
                'last',
                'prev',
                'next',
            ],
            'meta' => [
                'current_page',
                'from',
                'last_page',
                'links' => [
                    '*' => [
                        'url',
                        'label',
                        'active',
                    ],
                ],
                'path',
                'per_page',
                'to',
                'total',
            ],
        ]);
        $response->assertJsonFragment(['status' => true]);
        $response->assertJsonFragment(['email' => $userEmail]);
        $response->assertJsonFragment(['name' => $name]);
        $this->assertCount(10, $response->json('data'));
    }

    public function test_user_cannot_use_invalid_per_page_param(): void
    {
        $per_page = 'ss';
        Ticket::factory()->count(10)->create();
        $response = $this->getJson('/api/tickets/closed?per_page=' . $per_page);
        $response->assertStatus(200);

        $response->assertJson([
            'success' => false,
            'message' => 'Validation errors',
            'data' => [
                'per_page' => [
                    'The per page field must be an integer.',
                ],
            ],
        ]);
    }
}
