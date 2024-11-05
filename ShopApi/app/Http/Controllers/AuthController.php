<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Spatie\Permission\Models\Role;


class AuthController extends Controller
{
    public function login(LoginRequest $request):JsonResponse{
        try {
            if (auth()->attempt($request->validated())) {
                auth()->user()->tokens()->delete();
                return response()->json(['token' => auth()->user()->createToken('token-name')->plainTextToken, 'userId' => auth()->user()->id, 'userName' => auth()->user()->name, 'userEmail' => auth()->user()->email, 'role' => auth()->user()->getRoleNames()[0]]);
            }
            return response()->json(['error' => 'Unauthorized'], 401);
        }catch (\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function logout():JsonResponse{
        try {
            auth()->user()->tokens()->delete();
            return response()->json(['message' => 'Logged out']);
        }catch (\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }
    public function profile():JsonResponse
    {
        $name = auth()->user()->name;
        $email = auth()->user()->email;
        return response()->json(['name' => $name, 'email' => $email]);

    }

    public function register(RegisterRequest $request):JsonResponse
    {
        try {
            $user = User::create($request->validated());
            auth()->login($user);
            Cart::create(['user_id' => $user->id]);
            return response()->json(['token' => auth()->user()->createToken('token-name')->plainTextToken, 'userId'=> auth()->user()->id, 'userName'=> auth()->user()->name, 'userEmail'=> auth()->user()->email, 'role'=> auth()->user()->getRoleNames()[0]]);
        }catch (\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
