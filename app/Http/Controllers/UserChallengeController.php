<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Challenge;
use Illuminate\Support\Facades\Response;
use App\Http\Resources\ChallengeResource;
use App\Http\Resources\ChallengeCollection;
use App\Models\ChallengeCategory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UserChallengeController extends Controller
{
    public function index(Request $request){
        $user = Auth::user();
        $user_id = $user->id;

        print($user);

        $challengesQuery = ChallengeCategory::where('userID', $user_id);

        // Dodaj logiku za filtriranje prema kategoriji
        if ($request->has('categoryName')) {
            $categoryName = $request->categoryName;
            $challengeCat = ChallengeCategory::find($categoryName);
            if ($challengeCat) {
                $challengesQuery->where('challengeCategory', $challengeCat->id);
            }
        }

        $expenses = $challengesQuery->paginate(5);

        if ($expenses->isEmpty()) {
            return Response::json(['Expense not found'], 404);
        }

        return new ChallengeCollection($expenses);
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

        $validator = Validator::make($request->all(), [
            'challengeName' => 'required|string|max:255',
            //'startDate' => 'nullable|date',
            'endDate' => 'nullable|date',
            'value' => 'nullable|numeric',
            'challengeCategory' => 'required|exists:challenge_categories,id',
        /*'challengeName',
        'startDate',
        'endDate',
        'userID',
        'challengeCategory',
        'status',
        'value',*/
        ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->errors()], 400);
        }

        $user = Auth::user();
        print($user->id);
        $category = ChallengeCategory::find($request->challengeCategory);
        print($category);

        $challenge = Challenge::create([
            'startDate' => now(),
            'endDate' =>$request->endDate,
            'challengeName' => $request->challengeName,
            'value' => $request->value,
            'challengeCategory' => $category->id,
            'userID' => $user->id,
            'status' => false,
        ]);

        print($challenge);

        return new ChallengeResource($challenge);
    }

        public function update(Request $request, Challenge $challenge)
    {
        $validator = Validator::make($request->all(), [
            'challengeName' => 'required|string|max:255',
            'startDate' => 'nullable|date',
            'endDate' => 'nullable|date',
            'value' => 'nullable|numeric',
            'challengeCategory' => 'required|exists:challenge_categories,id',
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
