<?php

namespace App\Http\Controllers;

use App\Models\ExpenseCategory;
use Illuminate\Support\Facades\Response;
use App\Http\Resources\ExpenseCategoryCollection;
use App\Http\Resources\ExpenseCategoryResource;
use Illuminate\Http\Request;

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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
