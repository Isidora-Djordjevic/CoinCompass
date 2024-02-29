<?php

namespace App\Http\Controllers;

use App\Models\ExpenseCategory;
use Illuminate\Support\Facades\Response;
use App\Http\Resources\ExpenseCategoryCollection;
use App\Http\Resources\ExpenseCategoryResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExpenseCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = ExpenseCategory::all();
        return new ExpenseCategoryCollection($categories);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'categoryName' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->errors()], 400);
        }

        $expenseCategory = ExpenseCategory::create([
            'categoryName' => $request->categoryName,
        ]);


        return Response::json(['data' => $expenseCategory, 'message' => 'Expense category successfully added'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $expenseCategory = ExpenseCategory::find($id);
        if(is_null($expenseCategory)){
            return Response::json(['Expense category not found'],404);
        }
        return new ExpenseCategoryResource($expenseCategory);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ExpenseCategory $expenseCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ExpenseCategory $expenseCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExpenseCategory $expenseCategory)
    {
        //
    }
}
