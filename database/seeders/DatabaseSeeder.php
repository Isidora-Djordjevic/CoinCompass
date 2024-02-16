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

            ExpenseCategorySeeder::class,
            UserSeeder::class,

        ]);

        $user = User::factory()->create();
        Challenge::factory(3)->create([
            'user_id'=>$user->id,
        ]);
        Budget::factory()->create([
            'user_id'=>$user->id,
        ]);

        $budgets = Budget::all();
        $categories=ExpenseCategory::all();
        $users = User::all();

        foreach($budgets as $budget){
            Expense::factory(3)->create([
                'budget_id'=>$budget->id,
                'category_id'=>$categories->random()->id,
            ]);
        }

        foreach($budgets as $budget){
            Income::factory(3)->create([
                'budget_id'=>$budget->id,
                'user_id'=>$users->random()->id,
            ]);
        }
    }
}
