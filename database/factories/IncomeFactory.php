<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Budget;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Income>
 */
class IncomeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $incomeNames = ['Plata', 'Rodjendan', 'Povracaj pdv-a','Nasao na ulici'];
        return [
            'incomeDate'=>$this->faker->dateTimeBetween('-1 month', 'now'),
            'incomeName'=>$this->faker->randomElement($incomeNames),
            'incomeValue'=>$this->faker->randomFloat(2, 100, 10000),
            'user_id'=>User::factory(),
        ];
    }
}
