<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use function Pest\Laravel\json;

class UsersController extends Controller
{
    public function index(): JsonResponse{
        if(auth()->user()->hasRole('admin')) {
            try {
                return response()->json(User::paginate(12));

            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }
        return response()->json(['error' => 'unauthentic.'], 403);
    }

    public function show($id): JsonResponse{
        if(auth()->user()->hasRole('admin')) {
            try {
                $user = User::find($id);
                return response()->json(['user'=>$user]);
            }catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }
        return response()->json(['error' => 'unauthentic.'], 403);
    }
    public function cartShow($id): JsonResponse
    {
        if(auth()->user()->hasRole('admin')) {
            try {
                $cart = Cart::find($id);
                return response()->json($cart->product);
            }catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }
        return response()->json(['error' => 'unauthentic.'], 403);
    }
    public function carts($id): JsonResponse
    {
        if(auth()->user()->hasRole('admin')) {
            try {
                $user = User::find($id);
                $cart = $user->cartAll->all()->toArray();//....
                return response()->json($cart);
            }catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }
        return response()->json(['error' => 'unauthentic.'], 403);
    }
    public function update(UpdateUserRequest $request, $id): JsonResponse
    {
        if(auth()->user()->hasRole('admin')) {
            try {
                $user = User::find($id);
                $user->update($request->validated());
                return response()->json([
                    'message' => 'User updated successfully.', 201
                ]);
            }catch (\Exception $e){
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }
        return response()->json(['error' => 'unauthentic.'], 403);
    }
    public function delete($id): JsonResponse
    {
        if(auth()->user()->hasRole('admin')) {
            try {
                $user = User::find($id);
                $user->cartAll()->delete();//....
                $user->delete();
                return response()->json([
                    'message' => 'User delete successfully.', 201
                ]);
            }catch (\Exception $e){
                return response()->json(['error' => $e->getMessage()],500);
            }
        }
        return response()->json(['error' => 'unauthentic.'], 403);
    }
}
