<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Challenge;
use Illuminate\Support\Facades\Response;
use App\Http\Resources\ChallengeResource;
use App\Http\Resources\ChallengeCollection;


class UserChallengeController extends Controller
{
    public function index($id){
        $challenges = Challenge::get()->where('user_id', $id);
        if(is_null($challenges)){
            return Response::json(['Challenge not found'],404);
        }
        return new ChallengeCollection($challenges);
    }
}
