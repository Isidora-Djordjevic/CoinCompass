<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;

    protected $fillable = [
        'sum',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function incomes()
    {
        return $this->hasMany(Income::class, 'budget_id');
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class, 'budget_id');
    }
}
