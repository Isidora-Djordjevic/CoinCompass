<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ExpenseCategory;
use Illuminate\Database\Eloquent\Factories\Sequence;

class ExpenseCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ExpenseCategory::factory()->count(5)
        ->sequence(
            ['categoryName' => 'Racuni'],
            ['categoryName' => 'Hrana'],
            ['categoryName' => 'Izlasci'],
            ['categoryName' => 'Gorivo'],
            ['categoryName' => 'Soping'],
        )
        ->hasExpenses(3)
        ->create();
    }
}
