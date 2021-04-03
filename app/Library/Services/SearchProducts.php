<?php
namespace App\Library\Services;

use App\Http\Resources\ProductResourceCollection;
use App\Models\Category;
use App\Models\Product;


class SearchProducts
{
    /**
     * @param $name
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchByName($name)
    {
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
        $products = collect(new Product); // пустая коллекция

        $items = Category::all()->filter(function ($item) use ($category) { // выберем категории по имени
            return false !== stristr($item->name, $category);
        });

        foreach ($items as $item) {                 // в выбранных категориях
            foreach ($item->products as $prod) {
                $products->push($prod);             // дабавим все продукты в коллекцию
            }
        }

        return (new ProductResourceCollection($products))->response();
    }

    /**
     * @param $categoryID
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchByCategoryID($categoryID)
    {
        $products = collect(new Product); // пустая коллекция

        $items = Category::all()->filter(function ($item) use ($categoryID) { // выберем категории по ID
            return false !== stristr($item->id, $categoryID);
        });

        foreach ($items as $item) {                 // в выбранных категориях
            foreach ($item->products as $prod) {
                $products->push($prod);             // дабавим все продукты в коллекцию
            }
        }

        return (new ProductResourceCollection($products))->response();
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

    /**
     * @param $published
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexPublished($published)
    {
        $product = Product::all()->filter(function ($item) use ($published) {
            return ( $item->published == $published );
        });

        return (new ProductResourceCollection($product))->response();
    }

    /**
     * @param $deleted
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexNotDeleted($deleted)
    {
        $product = Product::all()->filter(function ($item) use ($deleted) {
            return ( $item->deleted == $deleted );
        });

        return (new ProductResourceCollection($product))->response();
    }
}
