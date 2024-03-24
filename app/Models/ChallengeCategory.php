<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChallengeCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'categoryName',
    ];

    // Dodavanje relacije ka Challenge modelu
    public function challenges()
    {
        return $this->hasMany(Challenge::class, 'challengeCategory');
    }
}