<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Challenge;
use Illuminate\Support\Facades\Response;
use App\Http\Resources\ChallengeResource;
use App\Http\Resources\ChallengeCollection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UserChallengeController extends Controller
{
    public function index(){
        $user = auth()->user();
        $challenges = $user->challenges;

        return new ChallengeCollection($challenges);
    }

    public function show($id)
    {
        $challenge = Challenge::find($id);

        if (!$challenge) {
            return Response::json(['message' => 'Challenge not found'], 404);
        }

        return new ChallengeResource($challenge);
    }

        public function store(Request $request)
    {
        $user = auth()->user();

        $validator = Validator::make($request->all(), [
            'challengeName' => 'required|string|max:255',
            'startDate' => 'required|date',
            'endDate' => 'required|date',
        ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->errors()], 400);
        }

        $challenge = $user->challenges()->create($request->all());

        return new ChallengeResource($challenge);
    }

        public function update(Request $request, Challenge $challenge)
    {
        $validator = Validator::make($request->all(), [
            'challengeName' => 'required|string|max:255',
            'startDate' => 'required|date',
            'endDate' => 'required|date',
        ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->errors()], 400);
        }

        $challenge->update($request->all());

        return new ChallengeResource($challenge);
    }


        public function destroy(Challenge $challenge)
    {
        $challenge->delete();

        return Response::json(['message' => 'Challenge deleted successfully']);
    }

}
