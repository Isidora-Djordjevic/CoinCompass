<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Expense;
use App\Http\Resources\UserExpensesCollection;
use App\Models\ExpenseCategory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;



class UserExpensesController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;

        print($user);

        $expensesQuery = Expense::where('user_id', $user_id);

        // Dodaj logiku za filtriranje prema kategoriji
        if ($request->has('categoryName')) {
            $categoryName = $request->categoryName;
            $expenseCat = ExpenseCategory::find($categoryName);
            if ($expenseCat) {
                $expensesQuery->where('category_id', $expenseCat->id);
            }
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

        $expense = Expense::create([
            'expenseDate' => now(),
            'expenseName' => $request->expenseName,
            'expenseValue' => $request->expenseValue,
            'category_id' => $request->category_id,
            'user_id' => $user->id,
        ]);


        $affected = DB::table('users')
              ->where('id', $user->id)
              ->decrement('budget', $request->expenseValue);

        return Response::json(['data' => $expense, 'message' => 'Expense successfully added'], 201);
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();

        return Response::json(['message' => 'Expense successfully deleted']);
    }
}
