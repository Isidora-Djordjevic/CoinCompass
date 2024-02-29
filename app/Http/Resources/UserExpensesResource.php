<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Expense;

class UserExpensesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
{
    $expenseId = $this->resource->id;
    $expense = Expense::find($expenseId);

    if (!$expense) {
        return []; 
    }

    $user = $expense->user;

    if (!$user) {
        return []; 
    }

    return [
        'expenseName' => $this->resource->expenseName,
        'expenseDate' => $this->resource->expenseDate,
        'expenseValue' => $this->resource->expenseValue,
        'expenseCategory' => new ExpenseCategoryResource($this->resource->category),
        'user' => new UserResource($user),
    ];
}

}
