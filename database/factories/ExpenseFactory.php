<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Budget;
use App\Models\ExpenseCategory;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Expense>
 */
class ExpenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $expenseNames = ['Restoran', 'Klub', 'Haljina','Cipele','Odeca','Gorivo 10l','Racun za struju'];
        return [
           'expenseName'=> $this->faker->randomElement($expenseNames),
           'expenseDate'=>$this->faker->dateTimeBetween('-1 month', 'now'),
           'expenseValue'=>$this->faker->randomFloat(2, 100, 10000),
           'budget_id'=>Budget::factory(),
           'category_id'=>ExpenseCategory::factory(),
        ];
    }
}
