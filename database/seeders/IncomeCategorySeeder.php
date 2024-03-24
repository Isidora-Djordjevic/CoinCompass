<?php

namespace Database\Seeders;

use App\Models\IncomeCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IncomeCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        IncomeCategory::factory()->count(5)
        ->sequence(
            ['categoryName' => 'Plata'],
            ['categoryName' => 'Poklon'],
            ['categoryName' => 'Rodjendan'],
            ['categoryName' => 'Nagrada'],
            ['categoryName' => 'Moja kategorija'],
        )
        ->create();
    }
}
