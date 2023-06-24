<?php

namespace Tests\Feature;

use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTicketsEndpointTest extends TestCase
{
    use RefreshDatabase;
    public function test_user_tickets_endpoint(): void
    {
        $userEmail = 'user@example.com';
        Ticket::factory()->count(15)->create(['email' => $userEmail]);
        $response = $this->getJson('/api/users/' . $userEmail . '/tickets');
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
                    'updated_at'
                ],
            ],
            'links'
        ]);
        $response->assertJsonCount(10, 'data');
        $response->assertJsonFragment(['email' => $userEmail]);
    }
}
