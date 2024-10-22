<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductsRequest;
use App\Http\Requests\UpdateProductsRequest;
use App\Models\User;
use http\Env\Request;
use Illuminate\Http\JsonResponse;
use function Laravel\Prompts\error;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            return response()->json(Product::paginate(10));
        }catch (\Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductsRequest $request) : JsonResponse
    {
        try {

        Product::create($request->validated());
        return response()->json([
            'message' => 'Product created successfully.', 201
        ]);
        }catch (\Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        try {
            return response()->json(Product::find($id));
        }catch (\Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product): JsonResponse
    {
        try {
            return response()->json($product);
            }catch (\Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductsRequest $request,$id): JsonResponse
    {
        try {
            $product = Product::find($id);
            $product->update($request->validated());
            return response()->json([
                'message' => 'Product updated successfully.', 201
            ]);
        }
        catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, Request $request): JsonResponse
    {
        try {
            $token = $request->getHeader('token');
            User::where();
            Product::deleted($id);
            return response()->json([
                'message' => 'Product deleted successfully.', 201
            ]);
        }
        catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
