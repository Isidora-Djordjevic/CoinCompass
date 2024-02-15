<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\BudgetResource;
use Illuminate\Support\Facades\Response;
use App\Models\Budget;
use Illuminate\Http\Request;
use App\Http\Resources\BudgetCollection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class BudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $budgets = Budget::all();
        return new BudgetCollection($budgets);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sum' => 'required|numeric',
            
        ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->errors()], 400);
        }

        
        $budget = Budget::create([
            'sum' => $request->input('sum'),
            'user_id' => Auth::user()->id, 
            
        ]);

        return Response::json(['message' => 'Budget created successfully', 'data' => $budget], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $budget = Budget::find($id);
        if(is_null($budget)){
            return Response::json(['Budget not found'],404);
        }
        return new BudgetResource($budget);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Budget $budget)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Budget $budget)
    {
        $validator = Validator::make($request->all(), [
            'sum' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->errors()], 400);
        }

        $budget->update([
            'sum' => $request->input('sum'),
        ]);

        return Response::json(['message' => 'Budget updated successfully', 'data' => $budget], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Budget $budget)
    {
        $budget->delete();

    return Response::json(['message' => 'Budget successfully deleted'], 200);
    }
}
