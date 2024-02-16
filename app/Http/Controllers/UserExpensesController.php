<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Budget;
use App\Models\Expense;
use App\Http\Resources\UserExpensesCollection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Carbon;

class UserExpensesController extends Controller
{
    public function index(Request $request){
        $user = Auth::user();
        $budget = $user->budget;
    
        if (is_null($budget)) {
            return Response::json(['Budget not found'], 404);
        }
    
        $budget_id = $budget->id;
        $expensesQuery = Expense::where('budget_id', $budget_id);

        // Dodaj logiku za filtriranje prema kategoriji
        if ($request->has('category_id')) {
            $expensesQuery->where('category_id', $request->category_id);
        }
    
        $expenses = $expensesQuery->paginate(5);
    
        if ($expenses->isEmpty()) {
            return Response::json(['Expense not found'], 404);
        }
    
        return new UserExpensesCollection($expenses);
    }

    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        //'expenseDate' => 'required|date',
        'expenseName' => 'required|string|max:255',
        'expenseValue' => 'required|numeric',
        'category_id' => 'required|exists:expense_categories,id'
        //'budget_id' => 'required|exists:budgets,id',
    ]);

    if ($validator->fails()) {
        return Response::json(['errors' => $validator->errors()], 400);
    }

    $user = Auth::user();
    $budget = $user->budget;

    if (!$budget) {
        return Response::json(['message' => 'Budget not found for the user'], 404);
    }

    $expense = Expense::create([
        'expenseDate' => now(),
        'expenseName' => $request->expenseName,
        'expenseValue' => $request->expenseValue,
        'budget_id' => $budget->id,
        'category_id' => $request->category_id,
    ]);


    $budget->sum -= $request->expenseValue; 
    $budget->save();

    return Response::json(['data' => $expense, 'message' => 'Expense successfully added'], 201);
}

public function destroy(Expense $expense)
{
    $expense->delete();

    return Response::json(['message' => 'Expense successfully deleted']);
}


}
