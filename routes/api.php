<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\ChallengeCategoryController;
use App\Http\Controllers\ExpenseCategoryController;
use App\Http\Controllers\IncomeCategoryController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\UserChallengeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserExpensesController;
use App\Http\Controllers\UserIncomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
//Route::resource('budgets', BudgetController::class)->only(['index','show']);
Route::resource('users', UserController::class);
Route::resource('expense_categories', ExpenseCategoryController::class);
Route::resource('income_categories', IncomeCategoryController::class);
Route::resource('challenge_categories', ChallengeCategoryController::class);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

//forgot password opcija
Route::middleware('api')->group(function () {
    Route::get('/password/reset', [ResetPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/password/reset', [ResetPasswordController::class, 'reset']);
});

//dozvoljen pristup samo autentifikovanim
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/profile', function(Request $request) {
        return auth()->user();
    });
    //Route::resource('budgets', BudgetController::class)->only(['update','store','destroy','create']);
    Route::resource('expenses', UserExpensesController::class);
    Route::resource('incomes', UserIncomeController::class);
    Route::resource('challenges',UserChallengeController::class);
    Route::get('/users/{id}/challenges', [UserChallengeController::class ,'index'])->name('users.challenges.index');
    Route::get('/users/{id}/expenses', [UserExpensesController::class ,'index'])->name('users.expenses.index');
    Route::get('/users/{id}/incomes', [UserIncomeController::class ,'index'])->name('users.incomes.index');
    // API route for logout user
    Route::post('/logout', [AuthController::class, 'logout']);
});
    