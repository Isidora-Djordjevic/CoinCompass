<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Income;
use App\Http\Resources\UserIncomeCollection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;


class UserIncomeController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $incomes = Income::where('user_id', $user->id);

        // Ako postoji parametar za pretragu po nazivu, primenjujemo ga
        if ($request->has('incomeName')) {
            $incomes->where('incomeName', 'like', '%' . $request->incomeName . '%');
        }

        // Ako postoji parametar za pretragu po datumu, primenjujemo ga
        if ($request->has('incomeDate')) {
            $incomes->whereDate('incomeDate', $request->incomeDate);
        }

        
        $incomes = $incomes->paginate();
        

        // Proveravamo da li su prihodi pronađeni
        if ($incomes->isEmpty()) {
            return Response::json(['Incomes not found'], 404);
        }

        // Vraćamo prihode kao JSON
        return new UserIncomeCollection($incomes);
    }


    public function store(Request $request)
{
    $user = Auth::user();
    $budget = $user->budget;

    $validator = Validator::make($request->all(), [
        //'incomeDate' => 'required|date',
        'incomeName' => 'required|string|max:255',
        'incomeValue' => 'required|numeric',
        //'budget_id' => 'required|exists:budgets,id',
    ]);

    if ($validator->fails()) {
        return Response::json(['errors' => $validator->errors()], 400);
    }

    $income = Income::create([
        'incomeDate' => now(),
        'incomeName' => $request->incomeName,
        'incomeValue' => $request->incomeValue,
        'budget_id' => $budget->id,
        'user_id' => auth()->id(),  
    ]);

    $budget->sum += $request->incomeValue;
    $budget->save();

    return Response::json(['data' => $income, 'message' => 'Income successfully added'], 201);
}

public function destroy(Income $income)
{
    $income->delete();

    return Response::json(['message' => 'Income successfully deleted']);
}

}
