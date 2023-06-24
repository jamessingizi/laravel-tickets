<?php

namespace Database\Factories;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'subject' => fake()->sentence(),
            'content' => fake()->paragraph(),
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'status' => false,
            'created_at' => now(),
        ];
    }
}
