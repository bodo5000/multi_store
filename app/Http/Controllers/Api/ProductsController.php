<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ProductsController extends Controller implements HasMiddleware
{
    /**
     * Display a listing of the resource.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('auth:sanctum', except: ['index', 'show']),
        ];
    }

    public function index(Request $request)
    {
        $products = Product::filter($request->query())
            ->with('category:id,name,image', 'store:id,name', 'tags')
            ->paginate();

        return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'status' => 'in:active,inactive',
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|gt:price',
        ]);

        $user = $request->user();
        if (!$user->tokenCan('products.create')) {
            return response([
                'message' => 'Not allowed'
            ], 403);
        }
        $product = product::create($request->all());

        return response()->json($product, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
        // return $product->with('category'); //not working
        // return $product->load('category:name,id', 'store:name,id');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string|max:255',
            'category_id' => 'sometimes|required|exists:categories,id',
            'status' => 'in:active,inactive',
            'price' => 'sometimes|required|numeric|min:0',
            'compare_price' => 'nullable|numeric|gt:price',
        ]);

        $user = $request->user();

        if (!$user->tokenCan('products.update')) {
            return response([
                'message' => 'Not allowed'
            ], 403);
        }
        $product->update($request->all());

        return response()->json($product, 201);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = auth()->guard('sanctum')->user();
        if (!$user->tokenCan('products.create')) {
            return response([
                'message' => 'Not allowed'
            ], 403);
        }
        product::destroy($id);
        return response()->json(['message' => 'product deleted success'], 200);
    }
}
