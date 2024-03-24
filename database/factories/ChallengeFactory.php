<?php

namespace Database\Factories;

use App\Models\ChallengeCategory;
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
            'challengeCategory'=>ChallengeCategory::factory(),
            'challengeName'=>$this->faker->randomElement($challengeNames),
            'startDate'=>$this->faker->dateTimeBetween('-1 month', 'now'),
            'endDate'=>$this->faker->dateTimeBetween('now', '+1 month'),
            'value'=>$this->faker->randomFloat(2, 100, 10000),
            'status'=>$this->faker->boolean(),
        ];
    }
}
