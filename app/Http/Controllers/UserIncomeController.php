<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Income;
use App\Http\Resources\UserIncomeCollection;
use App\Http\Resources\UserIncomeResource;
use App\Models\IncomeCategory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;


class UserIncomeController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $incomes = Income::where('user_id', $user->id);

        if ($incomes->isEmpty()) {
            return Response::json(['Incomes not found']);
        }

        // Ako postoji parametar za pretragu po nazivu, primenjujemo ga
        if ($request->has('categoryName')) {
            $categoryName = $request->categoryName;
            $incomeCat = IncomeCategory::find($categoryName);
            if ($incomeCat) {
                $incomes->where('category_id', $incomeCat->id);
            }
        }

        // Ako postoji parametar za pretragu po datumu, primenjujemo ga
        if ($request->has('incomeDate')) {
            $incomes->whereDate('incomeDate', $request->incomeDate);
        }

        
        $incomes = $incomes->cursorPaginate(5);
        

        // Proveravamo da li su prihodi pronađeni
        /*if ($incomes->isEmpty()) {
            return Response::json(['Incomes not found'], 404);
        }*/

        // Vraćamo prihode kao JSON sa paginacijom
        return $this->paginateIncomes($incomes);
        //return new UserIncomeCollection($incomes);
    }


    protected function paginateIncomes($incomes)
{
    // Priprema strukture odgovora za paginaciju
    return response()->json([
        'data' => new UserIncomeCollection($incomes),
        'current_page' => $incomes->currentPage(),
        'next_page_url' => $incomes->nextPageUrl(),
        'prev_page_url' => $incomes->previousPageUrl(),
        'total' => $incomes->total(),
    ]);
}


    public function store(Request $request)
{
    $user = Auth::user();

    $validator = Validator::make($request->all(), [
        //'incomeDate' => 'required|date',
        'incomeName' => 'required|string|max:255',
        'incomeValue' => 'required|numeric',
        'category_id' => 'required|exists:income_categories,id',
        //'budget_id' => 'required|exists:budgets,id',
    ]);

    if ($validator->fails()) {
        return Response::json(['errors' => $validator->errors()], 400);
    }

    $income = Income::create([
        'incomeDate' => now(),
        'incomeName' => $request->incomeName,
        'incomeValue' => $request->incomeValue,
        'user_id' => $user->id,  
        'category_id' => $request->category_id,
    ]);

    //print($income);
    $affected = DB::table('users')
              ->where('id', $user->id)
              ->increment('budget', $request->incomeValue);

    $affected = DB::table('users')
            ->where('id', $user->id)
            ->increment('incomes_sum', $request->incomeValue);

    return Response::json(['income' => new UserIncomeResource($income), 'message' => 'Income successfully added'], 201);
}

public function destroy(Income $income)
{
    $user = Auth::user();

    $affected = DB::table('users')
              ->where('id', $user->id)
              ->decrement('budget', $income->incomeValue);

    $affected = DB::table('users')
            ->where('id', $user->id)
            ->decrement('incomes_sum', $income->incomeValue);

    $income->delete();

    return Response::json(['message' => 'Income successfully deleted']);
}

}
