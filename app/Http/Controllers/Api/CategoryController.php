<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CategoryResourceCollection;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        //$categories = Category::all();
        $categories = Category::all()->filter(function ($item)  {
            return ( $item->deleted == 0 );
        });

        return (new CategoryResourceCollection($categories))->response();
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
            'description' => 'required|string|max:255',
        ]);
        $category = new Category();
        $category->name = $request->input('name');
        $category->description = $request->input('description');
        $category->published = $request->input('published');
        $category->save();
        Log::info("Category ID {$category->id} created successfully.");

        return (new CategoryResource($category))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Category $category)
    {
        return (new CategoryResource($category))->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Category $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);
        $category->name = $request->input('name');
        $category->description = $request->input('description');
        $category->published = $request->input('published');
        $category->save();
        Log::info("Category ID {$category->id} updated successfully.");

        return (new CategoryResource($category))->response();
    }

    /**
     * @param Request $request
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function softDelete(Request $request, Category $category)
    {
        $category->published = 0;
        $category->deleted = 1;
        $category->save();
        Log::info("Category ID {$category->id} deleted successfully.");

        return (new CategoryResource($category))->response();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        Log::info("Category ID {$category->id} deleted successfully.");

        return response(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @param Category $category
     * @return mixed
     */
    public function searchProducts(Category $category)
    {
        return $category->products->count();
    }
}
