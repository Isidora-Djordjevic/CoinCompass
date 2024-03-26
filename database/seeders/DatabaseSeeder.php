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
use App\Models\ChallengeCategory;
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
            ChallengeCategorySeeder::class,
        ]);

        $users = User::all();
        $expcategories=ExpenseCategory::all();
        $inccategories=IncomeCategory::all();
        $challcategories = ChallengeCategory::all();

        foreach($users as $user){
            Challenge::factory(2)->create([
                'userID'=>$user->id,
                'challengeCategory'=>$challcategories->random()->id,
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

        foreach ($users as $user) {
            $incomesSum = Income::where('user_id', $user->id)->sum('incomeValue');
            $expensesSum = Expense::where('user_id', $user->id)->sum('expenseValue');
            
            $sum = $incomesSum - $expensesSum;
        
            // Ažurirajte polje "budget" u modelu korisnika
            $user->budget = $sum;
            $user->incomes_sum = $incomesSum;
            $user->expenses_sum = $expensesSum;
            $user->save();
        }
        
    }
}
