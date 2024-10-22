<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Cart;
use App\Models\User;
use http\Env\Request;
use Illuminate\Http\JsonResponse;
use function Pest\Laravel\json;


class AuthController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            return response()->json(auth()->user());
        }catch (\Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }

    }
    public function login(LoginRequest $request):JsonResponse{
        if(auth()->attempt($request->validated())){
            auth()->user()->tokens()->delete();
            return response()->json(['token'=>auth()->user()->createToken('token-name')->plainTextToken, 'userId'=> auth()->user()->id, 'userName'=> auth()->user()->name, 'userEmail'=> auth()->user()->email]);
        }
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function logout():JsonResponse{
        try {
            auth()->user()->tokens()->delete();
            return response()->json(['message' => 'Logged out']);
        }
        catch (\Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function register(RegisterRequest $request):JsonResponse
    {
        try {
            $user = User::create($request->validated());
            auth()->login($user);
            Cart::create(['user_id'=> $user->id]);
            return response()->json(['token'=>auth()->user()->createToken('token-name')->plainTextToken, ['user'=> $user]]);
        }
        catch (\Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }


    }
}
