<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::all();

        return (new ProductResourceCollection($product))->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return (new ProductResource($product))->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
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
    public function searchByName($name)
    {
        //$product = Product::all();
        $product = Product::all()->filter(function ($item) use ($name) {
            return false !== stristr($item->name, $name);
        });

        return (new ProductResourceCollection($product))->response();
    }

    /**
     * @param $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchByCategoryName($category)
    {
        $c = collect(new Product); // пустая коллекция

        $items = Product::all();
        foreach ($items as $item) {
            $product = $item->categories->filter(function ($item) use ($category) {
                return false !== stristr($item->name, $category);
            });
            if ($product->count() > 0) {    // Если найдена категория
                $c->push($item);            // добавляем продукт в коллекцию
            }
        }

        return (new ProductResourceCollection($c))->response();
    }

    /**
     * @param $categoryID
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchByCategoryID($categoryID)
    {
        $c = collect(new Product); // пустая коллекция

        $items = Product::all();
        foreach ($items as $item) {
            $product = $item->categories->filter(function ($item) use ($categoryID) {
                return ($item->id == $categoryID);
            });
            if ($product->count() > 0) {    // Если найдена категория
                $c->push($item);            // добавляем продукт в коллекцию
            }
        }

        return (new ProductResourceCollection($c))->response();
    }

    /**
     * @param $priceFrom
     * @param $priceTo
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchByPrice($priceFrom, $priceTo)
    {
        $product = Product::all()->filter(function ($item) use ($priceFrom, $priceTo) {
            return ( ($item->price >= $priceFrom) && ($item->price <= $priceTo) );
        });

        return (new ProductResourceCollection($product))->response();
    }

    public function indexPublished($published)
    {
        $product = Product::all()->filter(function ($item) use ($published) {
            return ( $item->published == $published );
        });

        return (new ProductResourceCollection($product))->response();
    }

    public function indexNotDeleted($deleted)
    {
        $product = Product::all()->filter(function ($item) use ($deleted) {
            return ( $item->deleted == $deleted );
        });

        return (new ProductResourceCollection($product))->response();
    }
}
