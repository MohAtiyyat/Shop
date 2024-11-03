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
            $totalQuantity = 0;
            $totalQuantity = $user->cart->product()->wherePivot('purchased_at',  null)->sum('quantity');
             $totalPrice = 0;
            foreach($user->cart->product()->wherePivot('purchased_at',  null)->get()->toArray() as $product) {
                $totalPrice += $product['pivot']['quantity'] * $product['price'];
            }
            return response()->json(['products' => $user->cart->product()->wherePivot('purchased_at',  null)->get(), 'totalQuantity' => $totalQuantity, 'totalPrice' => $totalPrice]);
        }catch (\Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function update(UpdateCartRequest $request): JsonResponse
    {
        try {
                $user = auth()->user();
                if($user->cart->product()->where('product_id', $request['product_id'])->first() != null){
                    if ($request['quantity'] > 0) {
                        $product = $user->cart->product()->where('product_id', $request['product_id'] && 'purchased_at' ==null);
                        $product->updateExistingPivot($request['product_id'], ['quantity' => $request['quantity']]);
                    }
                    else{
                        $user->cart->product()->detach($request['product_id']);
                    }
                }
                else{
                    $user->cart->product()->attach($request['product_id'], ['quantity' => $request['quantity']]);
                }

                return response()->json(['message ' => 'cart updated successfully'], 200);
        }catch (\Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }

}
