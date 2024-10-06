<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductsRequest;
use App\Http\Requests\UpdateProductsRequest;
use Illuminate\Http\JsonResponse;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json(Product::all());
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductsRequest $request) : JsonResponse
    {
        Product::create($request->all());
        return response()->json([
            'message' => 'Product created successfully.', 201
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): JsonResponse
    {
        return response()->json($product);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product): JsonResponse
    {
        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductsRequest $request,$id): JsonResponse
    {
        $product = Product::find($id);
        $product->update($request->all());
        return response()->json([
            'message' => 'Product updated successfully.', 201
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        Product::destroy($id);
        return response()->json([
            'message' => 'Product deleted successfully.', 201
        ]);
    }
}
