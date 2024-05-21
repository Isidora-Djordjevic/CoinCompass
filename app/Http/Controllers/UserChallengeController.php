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

        //print($user);

            // Ažuriranje statusa svih izazova
        $challenges = Challenge::where('userID', $user_id)->get();

        if ($challenges->isEmpty()) {
            return Response::json(['Challenge not found']);
        }

        foreach ($challenges as $challenge) {
            $this->checkChallengeCompletion($challenge);
        }

        //$challengesQuery = ChallengeCategory::where('userID', $user_id);

        // Dodaj logiku za filtriranje prema kategoriji
        if ($request->has('categoryName')) {
            $categoryName = $request->categoryName;
            $challengeCat = ChallengeCategory::find($categoryName);
            if ($challengeCat) {
                $challenges->where('challengeCategory', $challengeCat->id);
            }
        }

       // $expenses = $challenges;

        return $this->paginateChallenges($challenges);
       //return new ChallengeCollection($challenges);
    }

    protected function paginateChallenges($challenges)
{
    // Priprema strukture odgovora za paginaciju
    return response()->json([
        'data' => new ChallengeCollection($challenges),
        'current_page' => $challenges->currentPage(),
        'next_page_url' => $challenges->nextPageUrl(),
        'prev_page_url' => $challenges->previousPageUrl(),
        'total' => $challenges->total(),
    ]);
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


function checkChallengeCompletion(Challenge $challenge)
{
    $categoryName = $challenge->category->categoryName;
    $startDate = $challenge->startDate;
    $endDate = $challenge->endDate;
    $challengeAmount = $challenge->value;
    $userID = $challenge->userID;

    $expenses = \App\Models\Expense::where('user_id', $userID)
                                    ->whereBetween('expenseDate', [$startDate, $endDate])
                                    ->sum('expenseValue');

    if ($categoryName === 'Troškovna trka') {
        // Provera da li je korisnik potrošio dovoljno
        if ($expenses >= $challengeAmount) {
            $challenge->status = true;
            $challenge->save();
        }
    } elseif ($categoryName === 'Ograničeni horizont') {
        // Provera da li je korisnik potrošio više od dozvoljenog
        if ($expenses <= $challengeAmount) {
            $challenge->status = true;
            $challenge->save();
        }
    } elseif ($challenge->challengeCategory === 'Finansijski fitnes') {
        // Provera za kategoriju 'Finansijski fitnes'
        $totalIncomes = \App\Models\Income::where('user_id', $challenge->user_id)
                              ->whereBetween('incomeDate', [$challenge->startDate, $challenge->endDate])
                              ->sum('incomeValue');

        if ($totalIncomes >= $challenge->value) {
            $challenge->status = true;
            $challenge->save();
            //return true; // Ili neki drugi odgovor koji odgovara vašoj logici
        }
    }
}

}
