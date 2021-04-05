<?php
namespace App\Library\Services;

use App\Http\Resources\CategoryResourceCollection;
use App\Models\Category;


class SearchCategories
{
    /**
     * invokes function by kind
     *
     * @param $kind
     * @param $param1
     * @return \Illuminate\Http\JsonResponse|null
     */
    public function search($kind, $param1)
    {
        switch ($kind) {
            case 'published': return($this->indexPublished($param1));
            case 'deleted': return($this->indexNotDeleted($param1));
            default: return  null;
        }
    }

    /**
     * @param $published
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexPublished($published)
    {
        $product = Category::all()->filter(function ($item) use ($published) {
            return ( $item->published == $published );
        });

        return (new CategoryResourceCollection($product))->response();
    }

    /**
     * @param $deleted
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexNotDeleted($deleted)
    {
        $product = Category::all()->filter(function ($item) use ($deleted) {
            return ( $item->deleted == $deleted );
        });

        return (new CategoryResourceCollection($product))->response();
    }
}
