<?php

namespace Database\Factories;

use App\Models\Ticket;
use App\Models\TicketCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Ticket>
 */
class TicketFactory extends Factory
{
    public function definition(): array
    {
        $priority = fake()->randomElement(['low', 'medium', 'high', 'urgent']);
        $sla = [
            'low' => 3 * 24 * 60,
            'medium' => 1 * 24 * 60,
            'high' => 4 * 60,
            'urgent' => 2 * 60,
        ];

        return [
            'ticket_number' => 'TK-'.now()->format('Ymd').'-'.fake()->unique()->numberBetween(1, 9999),
            'user_id' => User::factory(),
            'category_id' => TicketCategory::factory(),
            'title' => fake()->sentence(4),
            'description' => fake()->paragraph(),
            'location' => 'Lantai '.fake()->numberBetween(1, 5),
            'priority' => $priority,
            'status' => 'open',
            'sla_due_at' => now()->addMinutes($sla[$priority]),
        ];
    }

    public function withRequester(User $user): static
    {
        return $this->state(fn () => [
            'user_id' => $user->id,
            'department' => $user->team?->name,
            'position' => $user->role_label,
        ]);
    }

    public function withStatus(string $status): static
    {
        return $this->state(fn () => [
            'status' => $status,
            'resolved_at' => $status === 'resolved' ? now() : null,
            'closed_at' => $status === 'closed' ? now() : null,
        ]);
    }
}
