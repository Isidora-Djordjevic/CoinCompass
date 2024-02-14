<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;

    protected $fillable = [
        'incomeName',
        'incomeValue',
        'incomeDate',
    ];

    protected $primaryKey = 'incomeID';

    public function user()
    {
        return $this->belongsTo(User::class, 'userID');
    }

    public function budget()
    {
        return $this->belongsTo(Budget::class, 'budgetID');
    }
}
