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

    protected $primaryKey = 'budgetID';

    public function user()
    {
        return $this->belongsTo(User::class, 'userID');
    }

    public function incomes()
    {
        return $this->hasMany(Income::class, 'budgetID');
    }
}
