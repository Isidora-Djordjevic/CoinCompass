<?php

namespace App\Http\Controllers;

use App\Http\Resources\IncomeCategoryCollection;
use App\Http\Resources\IncomeCategoryResource;
use App\Models\IncomeCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class IncomeCategoryController extends Controller
{
    public function index()
    {
        $categories = IncomeCategory::all();
        return new IncomeCategoryCollection($categories);
    }

    public function show($id)
    {
        $incomeCategory = IncomeCategory::find($id);
        if(is_null($incomeCategory)){
            return Response::json(['Expense category not found'],404);
        }
        return new IncomeCategoryResource($incomeCategory);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'categoryName' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->errors()], 400);
        }

        $incomeCategory = IncomeCategory::create([
            'categoryName' => $request->categoryName,
        ]);


        return Response::json(['data' => $incomeCategory, 'message' => 'Income category successfully added'], 201);
    }
}
