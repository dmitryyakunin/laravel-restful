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

Route::apiResource('products', 'App\Http\Controllers\Api\ProductController');

Route::get('product-name/{name}', 'App\Http\Controllers\Api\ProductController@searchByName')
    ->name('products.searchByName');
Route::get('product-category-name/{category}', 'App\Http\Controllers\Api\ProductController@searchByCategoryName')
    ->name('products.searchByCategoryName');
Route::get('product-category-id/{id}', 'App\Http\Controllers\Api\ProductController@searchByCategoryID')
    ->name('products.searchByCategoryID');
