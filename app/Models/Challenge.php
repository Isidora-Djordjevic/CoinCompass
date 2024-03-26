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
        'challengeCategory',
        'status',
        'value',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userID');
    }

    public function category()
    {
        return $this->belongsTo(ChallengeCategory::class, 'challengeCategory');
    }
}
