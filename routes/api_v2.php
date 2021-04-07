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

Route::get('categories/search/{kind}/{param1}', 'App\Http\Controllers\Api\V2\CategoryController@search');
Route::get('categories/search/products/{category}', 'App\Http\Controllers\Api\V2\CategoryController@searchProducts');
Route::apiResource('categories', 'App\Http\Controllers\Api\V2\CategoryController');

Route::get('products/search/name/{param}', 'App\Http\Controllers\Api\V2\ProductController@searchByName');
Route::get('products/search/category-id/{param}', 'App\Http\Controllers\Api\V2\ProductController@searchByCategoryID');
Route::get('products/search/category-name/{param}', 'App\Http\Controllers\Api\V2\ProductController@searchByCategoryName');
Route::get('products/search/price/{param1}/{param2}', 'App\Http\Controllers\Api\V2\ProductController@searchByPrice');
Route::get('products/search/published/{param}', 'App\Http\Controllers\Api\V2\ProductController@indexPublished');
Route::get('products/search/deleted/{param}', 'App\Http\Controllers\Api\V2\ProductController@indexNotDeleted');
Route::apiResource('products', 'App\Http\Controllers\Api\V2\ProductController');

