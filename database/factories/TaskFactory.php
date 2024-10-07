<?php

namespace Database\Factories;

use App\Models\User;
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
        return [
            'task_number' => $this->faker->unique()->numberBetween(100000, 999900),
            'assigned_to' => User::where('user_role', 'user')->inRandomOrder()->first()->id,
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'status' => $this->faker->randomElement(['Pending', 'In Progress', 'Completed']),
            'due_date' => now()->addDays(10)->toDateString(),
            'image' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
