<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Library\Services\SearchProducts;
use App\Models\Product;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductResourceCollection;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $product = Product::all();

        return (new ProductResourceCollection($product))->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $product = new Product();
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->categories()->sync($request->input('categories'));
        $product->published = $request->input('published');
        $product->save();
        Log::info("Product ID {$product->id} created successfully.");

        return (new ProductResource($product))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Product $product)
    {
        return (new ProductResource($product))->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => '|required|string|max:255',
        ]);
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->categories()->sync($request->input('categories'));
        $product->published = $request->input('published');
        $product->save();
        Log::info("Product ID {$product->id} updated successfully.");

        return (new ProductResource($product))->response();
    }

    /**
     * Soft delete
     *
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Product $product)
    {
        $product->published = 0;
        $product->deleted = 1;
        $product->save();
        Log::info("Product ID {$product->id} deleted successfully.");

        return (new ProductResource($product))->response();
    }

    /**
     * Search product by params
     *
     * @param SearchProducts $searchProducts
     * @param $kind
     * @param $param1
     * @param $param2
     * @return \Illuminate\Http\JsonResponse|null
     */
    public function search(SearchProducts $searchProducts, $kind, $param1, $param2)
    {
        return $searchProducts->search($kind, $param1, $param2);
    }
}

