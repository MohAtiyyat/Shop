<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\JsonResponse;


class AuthController extends Controller
{
    public function user(): JsonResponse
    {
        return response()->json([auth()->user()], 200);
    }
    public function login(LoginRequest $request):JsonResponse{
        if(auth()->attempt($request->all())){
            return response()->json(['token'=>auth()->user()->createToken('token-name')->plainTextToken]);
        }
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function logout():JsonResponse{
        auth()->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out']);
    }

    public function register(LoginRequest $request):JsonResponse
    {
        $user = User::create($request->all());
        auth()->login($user);
        Cart::create(['user_id'=> $user->id]);
        return response()->json(['token'=>auth()->user()->createToken('token-name')->plainTextToken,'message'=>'Registered']);

    }
}
