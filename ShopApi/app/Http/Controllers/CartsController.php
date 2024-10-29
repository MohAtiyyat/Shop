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
            $totalQuantity = $user->cart->product->sum('pivot.quantity');

//            dd($user->cart->product->toArray());
             $totalPrice = 0;
            foreach($user->cart->product->toArray() as $product) {
                $totalPrice += $product['pivot']['quantity'] * $product['price'];
            }
            return response()->json(['products' => $user->cart->product, 'totalQuantity' => $totalQuantity, 'totalPrice' => $totalPrice]);
        }catch (\Exception $e){
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
        }catch (\Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }

}
