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

Route::get('categories/search/{kind}/{param1}', 'App\Http\Controllers\Api\V1\CategoryController@search');
Route::get('categories/search/products/{category}', 'App\Http\Controllers\Api\V1\CategoryController@searchProducts');
Route::apiResource('categories', 'App\Http\Controllers\Api\V1\CategoryController');

Route::get('products/search/{kind}/{param1}/{param2}', 'App\Http\Controllers\Api\V1\ProductController@search');
Route::apiResource('products', 'App\Http\Controllers\Api\V1\ProductController');

