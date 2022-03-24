<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('login', [LoginController::class, 'authenticate'])->name('login');
Route::post('logout', [LoginController::class, 'logout'])->middleware('auth:sanctum')->name('logout');
Route::get('auth', [LoginController::class, 'auth'])->middleware('auth:sanctum')->name('auth');

Route::apiResource('products', ProductController::class)->only('index', 'delete');
Route::post('detache-product/{product}', [OrderController::class, 'detacheProduct'])->middleware('auth:sanctum');

Route::apiResource('orders', OrderController::class)->middleware('auth:sanctum');
Route::apiResource('purchases', PurchaseController::class)->only('index')->middleware('auth:sanctum');
