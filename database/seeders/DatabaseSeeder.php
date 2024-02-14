<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Budget;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Income;
use App\Models\Challenge;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /*User::truncate();
        ExpenseCategory::truncate();
        Budget::truncate();
        Challenge::truncate();
        Expense::truncate();
        Income::truncate();*/
        

         $this->call([
            UserSeeder::class,
            ExpenseCategorySeeder::class,
            /*
            ChallengeSeeder::class,
            ExpenseCategorySeeder::class,
            ExpenseSeeder::class,
            
            */
        ]);
    }
}
