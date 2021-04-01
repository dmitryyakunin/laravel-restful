<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('categories', 'App\Http\Controllers\Api\CategoryController');
Route::put('category-delete/{category}', 'App\Http\Controllers\Api\CategoryController@softDelete')
    ->name('categories.softDelete');
Route::get('category-search-products/{category}', 'App\Http\Controllers\Api\CategoryController@searchProducts')
    ->name('categories.searchProducts');

Route::apiResource('products', 'App\Http\Controllers\Api\ProductController');
Route::put('product-delete/{product}', 'App\Http\Controllers\Api\ProductController@softDelete')
    ->name('products.softDelete');
Route::get('product-name/{name}', 'App\Http\Controllers\Api\ProductController@searchByName')
    ->name('products.searchByName');
Route::get('product-category-name/{category}', 'App\Http\Controllers\Api\ProductController@searchByCategoryName')
    ->name('products.searchByCategoryName');
Route::get('product-category-id/{id}', 'App\Http\Controllers\Api\ProductController@searchByCategoryID')
    ->name('products.searchByCategoryID');
Route::get('product-price/{pricefrom}/{priceto}', 'App\Http\Controllers\Api\ProductController@searchByPrice')
    ->name('products.searchByPrice');
Route::get('product-published/{yes}', 'App\Http\Controllers\Api\ProductController@indexPublished')
    ->name('products.indexPublished');
Route::get('product-deleted/{yes}', 'App\Http\Controllers\Api\ProductController@indexNotDeleted')
    ->name('products.indexNotDeleted');
