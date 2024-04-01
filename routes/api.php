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
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

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

Route::resource('expense_categories', ExpenseCategoryController::class);
Route::resource('income_categories', IncomeCategoryController::class);
Route::resource('challenge_categories', ChallengeCategoryController::class);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

//forgot password opcija
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');

Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);
 
    $status = Password::sendResetLink(
        $request->only('email')
    );
 
    return $status === Password::RESET_LINK_SENT
                ? back()->with(['status' => __($status)])
                : back()->withErrors(['email' => __($status)]);
})->middleware('guest')->name('password.email');

//reset password opcija
Route::get('/reset-password/{token}', function (string $token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);
 
    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function (User $user, string $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));
 
            $user->save();
 
            event(new PasswordReset($user));
        }
    );
 
    return $status === Password::PASSWORD_RESET
                ? redirect()->route('login')->with('status', __($status))
                : back()->withErrors(['email' => [__($status)]]);
})->middleware('guest')->name('password.update');


//dozvoljen pristup samo autentifikovanim
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/profile', function(Request $request) {
        return auth()->user();
    });
    //Route::resource('budgets', BudgetController::class)->only(['update','store','destroy','create']);
    Route::get('users', [UserController::class, 'show']);
    Route::resource('users', UserController::class)->except(['show','index']);
    Route::resource('expenses', UserExpensesController::class);
    Route::resource('incomes', UserIncomeController::class);
    Route::resource('challenges',UserChallengeController::class);
    Route::get('/users/{id}/challenges', [UserChallengeController::class ,'index'])->name('users.challenges.index');
    Route::get('/users/{id}/expenses', [UserExpensesController::class ,'index'])->name('users.expenses.index');
    Route::get('/users/{id}/incomes', [UserIncomeController::class ,'index'])->name('users.incomes.index');
    // API route for logout user
    Route::post('/logout', [AuthController::class, 'logout']);
});
    