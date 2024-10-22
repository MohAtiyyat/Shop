<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateCartRequest;
use App\Models\Cart;
use Illuminate\Http\JsonResponse;

class CartsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $user = auth()->user();
            return response()->json($user->cart->product);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);

        }
    }

    public function update(UpdateCartRequest $request): JsonResponse
    {
        try {
            $user = auth()->user();
            $user->cart->product()->detach($request['product_id']);
            if ($request['quantity'] > 0) {
                $user->cart->product()->attach($request['product_id'], ['quantity' => $request['quantity']]);
            }
            return response()->json(['message ' => 'cart updated successfully'], 200);
        }catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

}
