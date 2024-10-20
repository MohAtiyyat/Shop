<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\JsonResponse;


class AuthController extends Controller
{
    public function login(LoginRequest $request):JsonResponse{
        if(auth()->attempt($request->all())){
            auth()->user()->tokens()->delete();
            return response()->json(['token'=>auth()->user()->createToken('token-name')->plainTextToken, 'userId'=> auth()->user()->id, 'userName'=> auth()->user()->name, 'userEmail'=> auth()->user()->email]);
        }
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function logout():JsonResponse{
        auth()->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out']);
    }

    public function register(RegisterRequest $request):JsonResponse
    {
        $user = User::create($request->all());
        auth()->login($user);
        Cart::create(['user_id'=> $user->id]);
        return response()->json(['token'=>auth()->user()->createToken('token-name')->plainTextToken, ['user'=> $user]]);

    }
}
