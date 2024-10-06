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
        $user = auth()->user();
        return response()->json($user->cart->product);
    }

    public function update(UpdateCartRequest $request): JsonResponse
    {
        $user = auth()->user();
        $user->cart->product()->detach($request['product_id']);
        if($request['quantity']>0) {
            $user->cart->product()->attach($request['product_id'], ['quantity' => $request['quantity']]);
        }
        return response()->json(['message ' => 'cart updated successfully'], 200);
    }

}
