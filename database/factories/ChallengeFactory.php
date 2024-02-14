<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Challenge>
 */
class ChallengeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'challengeName'=>fake()->title(),
            'startDate'=>$this->faker->dateTimeBetween('-1 month', 'now'),
            'endDate'=>$this->faker->dateTimeBetween('now', '+1 month'),
            'user_id'=>User::factory(),
        ];
    }
}
