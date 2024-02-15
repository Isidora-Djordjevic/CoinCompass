<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Budget;
use App\Models\Expense;
use App\Http\Resources\UserExpensesCollection;

class UserExpensesController extends Controller
{
    public function index($id){
        $budget = Budget::where('user_id', $id)->first();
        if (is_null($budget)) {
            return Response::json(['Budget not found'], 404);
        }
        $budget_id = $budget->id;
        $expenses = Expense::get()->where('budget_id', $budget_id);
        if ($expenses->isEmpty()) {
            return Response::json(['Expense not found'], 404);
        }
        return new UserExpensesCollection($expenses);
    }
}
