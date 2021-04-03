<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Library\Services\SearchProducts;
use App\Models\Product;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductResourceCollection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
     * @param Request $request
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function softDelete(Request $request, Product $product)
    {
        $product->published = 0;
        $product->deleted = 1;
        $product->save();
        Log::info("Product ID {$product->id} deleted successfully.");

        return (new ProductResource($product))->response();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        Log::info("Product ID {$product->id} deleted successfully.");
        return response(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @param $name
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchByName(SearchProducts $searchProducts, $name)
    {
      return $searchProducts->searchByName($name);
    }

    /**
     * @param $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchByCategoryName(SearchProducts $searchProducts, $category)
    {
       return $searchProducts->searchByCategoryName($category);
    }

    /**
     * @param $categoryID
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchByCategoryID(SearchProducts $searchProducts, $categoryID)
    {
        return $searchProducts->searchByCategoryID($categoryID);
    }

    /**
     * @param $priceFrom
     * @param $priceTo
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchByPrice(SearchProducts $searchProducts, $priceFrom, $priceTo)
    {
        return $searchProducts->searchByPrice($priceFrom, $priceTo);
    }

    /**
     * @param SearchProducts $searchProducts
     * @param $published
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexPublished(SearchProducts $searchProducts, $published)
    {
        return $searchProducts->indexPublished($published);
    }

    /**
     * @param SearchProducts $searchProducts
     * @param $deleted
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexNotDeleted(SearchProducts $searchProducts, $deleted)
    {
        return $searchProducts->indexNotDeleted($deleted);
    }
}
