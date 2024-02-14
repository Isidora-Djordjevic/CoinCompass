<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    use HasFactory;

    protected $fillable = [
        'challengeName',
        'startDate',
        'endDate',
        'userID',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userID');
    }
}
