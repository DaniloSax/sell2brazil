<?php

use App\Http\Controllers\ServerFakeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * routes fakers solicitadas na descricao do teste
 *
 * https://localhost:9001/order
 * https://localhost:9002/v1/order
 * https://localhost:9003/web_api/order
 */
Route::middleware('auth:sanctum')->group(function () {
    Route::get('order', [ServerFakeController::class, 'index']);
    Route::get('v1/order', [ServerFakeController::class, 'index']);
    Route::get('web_api/order', [ServerFakeController::class, 'index']);
});
