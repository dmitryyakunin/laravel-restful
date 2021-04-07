<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Library\Services\SearchCategories;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\CategoryResourceCollection;
use App\Models\Category;
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
        $categories = Category::all();

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
     * Soft delete
     *
     * @param Category $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Category $category)
    {
        $category->published = 0;
        $category->deleted = 1;
        $category->save();
        Log::info("Category ID {$category->id} deleted successfully.");

        return (new CategoryResource($category))->response();
    }

    /**
     * @param Category $category
     * @return mixed
     */
    public function searchProducts(Category $category)
    {
        return $category->products->count();
    }

    /**
     * Search Categories by params
     *
     * @param SearchCategories $searchCategories
     * @param $kind
     * @param $param1
     * @return mixed
     */
    public function search(SearchCategories $searchCategories, $kind, $param1)
    {
        return  $searchCategories->search($kind, $param1);
    }
}
