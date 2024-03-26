<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use App\Models\User;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request) {
        
        $validator = Validator::make($request->all(),[
            //'name' => 'nullable|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8'
        ]);

        if($validator->fails()){
            return Response::json($validator->errors());
        }

        $user = User::create([
            //'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'budget' => 0.0,
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return Response::json(['data'=> $user, 'access_token'=> $token, 'token_type'=>'Bearer', ]);
    }

    public function login(Request $request) {
        if (!Auth::attempt($request->only('email','password'))){
            return Response::json(['message'=> 'Login nije uspeo', 'success'=>false]);
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return Response::json(['success'=>true,'message' => 'Zdravo ' .$user->name. ', pazi kako trosis!', 'acces_token'=> $token, 'token_type'=>'Bearer', ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return Response::json(['message' => 'Successfully logged out']);
    }
}
