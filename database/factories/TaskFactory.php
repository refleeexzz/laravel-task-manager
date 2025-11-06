<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = fake()->randomElement(['pending', 'in_progress', 'completed', 'qa_review']);

        return [
            'project_id' => fake()->boolean(70) ? \App\Models\Project::factory() : null,
            'user_id' => \App\Models\User::factory(),
            'title' => fake()->sentence(4),
            'description' => fake()->paragraph(),
            'priority' => fake()->randomElement(['low', 'medium', 'high']),
            'status' => $status,
            'due_date' => fake()->optional()->dateTimeBetween('now', '+3 months'),
            'completed_at' => $status === 'completed' ? fake()->dateTimeBetween('-1 month', 'now') : null,
        ];
    }
}
