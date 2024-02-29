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
use App\Models\IncomeCategory;

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
            IncomeCategorySeeder::class,
            UserSeeder::class,
        ]);

        $users = User::all();
        $expcategories=ExpenseCategory::all();
        $inccategories=IncomeCategory::all();

        foreach($users as $user){
            Challenge::factory(2)->create([
                'user_id'=>$user->id,
            ]);
            Income::factory(3)->create([
                'user_id'=>$user->id,
                'category_id'=>$inccategories->random()->id,
            ]);
            Expense::factory(4)->create([
                'user_id'=>$user->id,
                'category_id'=>$expcategories->random()->id,
            ]);
        }
    }
}
