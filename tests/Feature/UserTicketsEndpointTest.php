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
        $name = 'John Doe';
        Ticket::factory()->count(10)->create(['email' => $userEmail, 'name' => $name]);
        $response = $this->getJson('/api/users/' . $userEmail . '/tickets');
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
        $response->assertJsonCount(10, 'data');
        $response->assertJsonFragment(['email' => $userEmail]);
        $response->assertJsonFragment(['name' => $name]);
        $this->assertCount(10, $response->json('data'));
    }

    public function test_user_cannot_use_invalid_email(): void
    {
        $userEmail = 'invalid-email';
        Ticket::factory()->count(10)->create();
        $response = $this->getJson('/api/users/' . $userEmail . '/tickets');
        $response->assertStatus(200);

        $response->assertJson([
            'success' => false,
            'message' => 'Validation errors',
            'data' => [
                'email' => [
                    'The email field must be a valid email address.',
                ],
            ],
        ]);
    }

    public function test_user_cannot_use_invalid_per_page_param(): void
    {
        $per_page = '200';
        $userEmail = "user@email.com";
        Ticket::factory()->count(10)->create();
        $response = $this->getJson('/api/users/' . $userEmail . '/tickets?per_page=' . $per_page);
        $response->assertStatus(200);

        $response->assertJson([
            'success' => false,
            'message' => 'Validation errors',
            'data' => [
                'per_page' => [
                    'The per page field must not be greater than 100.',
                ],
            ],
        ]);
    }
}
