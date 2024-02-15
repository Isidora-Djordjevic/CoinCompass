<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Income;
use App\Http\Resources\UserIncomeCollection;

class UserIncomeController extends Controller
{
    public function index($id){
        $incomes = Income::get()->where('user_id', $id);
        if(is_null($incomes)){
            return Response::json(['Incomes not found'],404);
        }
        return new UserIncomeCollection($incomes);
    }
}
