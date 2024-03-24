<?php

namespace Database\Seeders;

use App\Models\ChallengeCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChallengeCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ChallengeCategory::factory()->count(3)
        ->sequence(
            ['categoryName' => 'Finansijski fitnes'],
            ['categoryName' => 'Troškovna trka'],
            ['categoryName' => 'Ograničeni horizont'],
        )
        ->create();
    }
}
