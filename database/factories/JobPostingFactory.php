<?php

namespace Database\Factories;

use App\Models\JobPosting;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JobPosting>
 */
class JobPostingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'company_id' => User::factory()->create(['role' => 'company'])->id,
            'title' => fake()->jobTitle(),
            'description' => fake()->realText(),
            'status' => fake()->randomElement(['draft', 'published']),
        ];
    }
}
