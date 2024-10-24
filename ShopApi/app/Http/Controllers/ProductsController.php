<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductsSearchRequest;
use App\Models\Product;
use App\Http\Requests\StoreProductsRequest;
use App\Http\Requests\UpdateProductsRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
            if(auth()->user()->hasRole('admin')) {
                Product::create($request->validated());
                return response()->json([
                    'message' => 'Product created successfully.', 201
                ]);
            }else{
                return response()->json(['error' => 'Unauthorized'], 401);
            }
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
            if(auth()->user()->hasRole('admin')) {
                return response()->json($product);
            }else{
                return response()->json(['message' => 'Unauthorized access.'], 403);
            }
        }
        catch (\Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductsRequest $request,$id): JsonResponse
    {
        try {
            if(auth()->user()->hasRole('admin'))
            {
            $product = Product::find($id);
            $product->update($request->validated());
            return response()->json([
                'message' => 'Product updated successfully.', 201
            ]);
        }
        else{
                return response()->json(['message' => 'Unauthorized access.'], 403);
            }
        }catch (\Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id): JsonResponse
    {
        try {
            if(auth()->user()->hasRole('admin')) {
                $product = Product::find($id);
                $product->delete();
                return response()->json([
                    'message' => 'Product deleted successfully.', 201
                ]);
            }
            else{
                return response()->json([
                    'message' => 'You do not have permission to delete this product.', 403
                ]);
            }
        }catch (\Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    public function search(ProductsSearchRequest $request): JsonResponse
    {
        try {
            $search = $request->input('search');
            $results = Product::where('name', 'like', "%$search%")->get();
            return response()->json($results);
        }catch (\Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
