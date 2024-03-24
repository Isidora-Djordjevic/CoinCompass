<?php

namespace App\Http\Controllers;

use App\Http\Resources\ChallengeCategoryCollection;
use App\Http\Resources\ChallengeCategoryResource;
use App\Models\Challenge;
use App\Models\ChallengeCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class ChallengeCategoryController extends Controller
{
    public function index()
    {
        $categories = ChallengeCategory::all();
        return new ChallengeCategoryCollection($categories);
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

        $expenseCategory = ChallengeCategory::create([
            'categoryName' => $request->categoryName,
        ]);


        return Response::json(['data' => $expenseCategory, 'message' => 'Expense category successfully added'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $expenseCategory = ChallengeCategory::find($id);
        if(is_null($expenseCategory)){
            return Response::json(['Expense category not found'],404);
        }
        return new ChallengeCategoryResource($expenseCategory);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ChallengeCategory $expenseCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ChallengeCategory $expenseCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ChallengeCategory $expenseCategory)
    {
        //
    }
}
