<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteProductRequest;
use App\Http\Requests\ProductsSearchRequest;
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
        try {
            return response()->json(Product::paginate(12));
        }catch (\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
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
            return response()->json(['error' => $e->getMessage()], 500);
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
            return response()->json(['error' => $e->getMessage()], 500);
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
            return response()->json(['error' => $e->getMessage()], 500);
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
        }catch (\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id): JsonResponse
    {
        if(auth()->user()->hasRole('admin')) {
            try {
                $product = Product::find($id);
                $product->softdelete();
                return response()->json([
                    'message' => 'Product deleted successfully.'
                ]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }
        return response()->json(['error' => 'You are not authorized to delete this product.'], 403);
    }
    public function search(ProductsSearchRequest $request): JsonResponse
    {
        try {
            $search = $request->input('search');
            $results = Product::where('name', 'like', "%$search%")->get();
            return response()->json($results);
        }catch (\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
