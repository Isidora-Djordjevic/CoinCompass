<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'expenseName',
        'expenseDate',
        'budgetID',
        'categoryID',
    ];

    public function budget()
    {
        return $this->belongsTo(Budget::class, 'budgetID');
    }

    public function category()
    {
        return $this->belongsTo(ExpenseCategory::class, 'categoryID');
    }
}
