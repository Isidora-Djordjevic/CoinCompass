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
        ExpenseCategory::factory()->count(11)
        ->sequence(
            ['categoryName' => 'Stanovanje'],
            ['categoryName' => 'Hrana'],
            ['categoryName' => 'Transport'],
            ['categoryName' => 'Odeća'],
            ['categoryName' => 'Komunalije'],
            ['categoryName' => 'Zdravlje'],
            ['categoryName' => 'Sport'],
            ['categoryName' => 'Pokloni'],
            ['categoryName' => 'Provodi'],
            ['categoryName' => 'Hobiji'],
            ['categoryName' => 'Moja kategorija'],
        )
        ->create();
    }
}
