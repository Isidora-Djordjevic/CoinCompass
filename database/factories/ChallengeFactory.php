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
        $challengeNames = ['Dan bez trosenja', 'Skupi 15k na racunu', 'Potrosi 5k'];
        return [
            'user_id'=>User::factory(),
            'challengeName'=>$this->faker->randomElement($challengeNames),
            'startDate'=>$this->faker->dateTimeBetween('-1 month', 'now'),
            'endDate'=>$this->faker->dateTimeBetween('now', '+1 month'),
            
        ];
    }
}
