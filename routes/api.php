<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BudgetController;
use App\Http\Resources\BudgetResource;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExpenseCategoryController;
use App\Http\Controllers\UserChallengeController;
use App\Http\Resources\UserResource;
use App\Http\Resources\ExpenseCategoryResource;
use App\Http\Controllers\UserExpensesontroller;
use App\Http\Controllers\UserIncomeController;
use App\Http\Controllers\API\AuthController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//dozvoljen pristup neautentifikovanim
Route::resource('budgets', App\Http\Controllers\BudgetController::class)->only(['index','show']);
Route::resource('users', App\Http\Controllers\UserController::class);
Route::resource('expense_categories', App\Http\Controllers\ExpenseCategoryController::class);
Route::post('/register', [App\Http\Controllers\API\AuthController::class, 'register']);
Route::post('/login', [App\Http\Controllers\API\AuthController::class, 'login']);

//dozvoljen pristup samo autentifikovanim
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/profile', function(Request $request) {
        return auth()->user();
    });
    Route::resource('budgets', App\Http\Controllers\BudgetController::class)->only(['update','store','destroy','create']);
    Route::resource('expenses', App\Http\Controllers\UserExpensesController::class);
    Route::resource('incomes', App\Http\Controllers\UserIncomeController::class);
    Route::get('/users/{id}/challenges', [App\Http\Controllers\UserChallengeController::class ,'index'])->name('users.challenges.index');
    Route::get('/users/{id}/expenses', [App\Http\Controllers\UserExpensesController::class ,'index'])->name('users.expenses.index');
    Route::get('/users/{id}/incomes', [App\Http\Controllers\UserIncomeController::class ,'index'])->name('users.incomes.index');
    // API route for logout user
    Route::post('/logout', [AuthController::class, 'logout']);
});
    