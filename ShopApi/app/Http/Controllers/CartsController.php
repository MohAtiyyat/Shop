<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateCartRequest;
use App\Models\Cart;
use Carbon\Traits\Date;
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
            $cart = $user->cart->latest()->first();//.....
            $totalQuantity = $cart->product->sum('pivot.quantity');//....
            $totalPrice = 0;
            foreach($cart->product->toArray() as $product){//....
                $totalPrice += $product['pivot']['quantity'] * $product['price'];
            }
            return response()->json(['products' => $cart->product, 'totalQuantity' => $totalQuantity, 'totalPrice' => $totalPrice]);
        }catch (\Exception $e){
            return response()->json(['error' => $e->getMessage()],500);
        }
    }

    public function update(UpdateCartRequest $request): JsonResponse
    {
        try {
            $user = auth()->user();
            $cart = $user->cart->latest()->first();//....
            $product = $cart->product()->where('product_id', $request['product_id']);
                if($product->first() != null){
                    $quantity = $request['quantity'] + $product->first()->pivot->quantity;
                    if ($quantity >0 ) {
                        $product->updateExistingPivot($request['product_id'], ['quantity' => $quantity]);
                    }
                    else{
                        $cart->product()->detach($request['product_id']);
                    }
                }
                else{
                    $cart->product()->attach($request['product_id'], ['quantity' => $request['quantity']]);
                }

                return response()->json(['message ' => 'cart updated successfully'], 200);
        }catch (\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function buy(): JsonResponse
    {
        try {

            $user = auth()->user();
            $cart = $user->cart->latest()->first();//.....
            $cart->ordered_at = date("Y-m-d H:i:s");
            $cart->save();

            Cart::create(['user_id' => $user->id]);
            return response()->json(['message ' => 'cart updated successfully'], 200);
        }catch (\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }



    }

}
