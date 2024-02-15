<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Budget;
use App\Models\Expense;
use App\Http\Resources\UserExpensesCollection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class UserExpensesController extends Controller
{
    public function index(){
        $user = Auth::user();
    
        $budget = $user->budget;
    
        if (is_null($budget)) {
            return Response::json(['Budget not found'], 404);
        }
    
        $budget_id = $budget->id;
        $expenses = Expense::where('budget_id', $budget_id)->get();
    
        if ($expenses->isEmpty()) {
            return Response::json(['Expense not found'], 404);
        }
    
        return new UserExpensesCollection($expenses);
    }

    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'expenseDate' => 'required|date',
        'expenseName' => 'required|string|max:255',
        'expenseValue' => 'required|numeric',
        'budget_id' => 'required|exists:budgets,id',
    ]);

    if ($validator->fails()) {
        return Response::json(['errors' => $validator->errors()], 400);
    }

    $expense = Expense::create([
        'expenseDate' => $request->expenseDate,
        'expenseName' => $request->expenseName,
        'expenseValue' => $request->expenseValue,
        'budget_id' => $request->budget_id,
        'category_id' => $request->category_id,
    ]);


    $budget = Budget::find($request->budget_id);
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
