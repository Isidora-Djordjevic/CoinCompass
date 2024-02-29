<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomeCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'categoryName',
    ];

    // Dodavanje relacije ka Income modelu
    public function incomes()
    {
        return $this->hasMany(Income::class, 'category_id');
    }
}
