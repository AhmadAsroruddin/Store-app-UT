<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryProductController;
use App\Http\Controllers\ProductController;


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
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware(['custom.jwt.verify', 'jwt.verify'])->group(function () {
    Route::get('category-products', [CategoryProductController::class, 'getAll']);
    Route::get('category-products/{id}', [CategoryProductController::class, 'getById']);
    Route::post('category-products', [CategoryProductController::class, 'store']);
    Route::put('category-products/{id}', [CategoryProductController::class, 'update']);
    Route::delete('category-products/{id}', [CategoryProductController::class, 'delete']);

    Route::post('product', [ProductController::class,'store']);
});

