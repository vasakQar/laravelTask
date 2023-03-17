<?php

use App\Http\Controllers\Api\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LanguageController;
use App\Http\Controllers\Api\ProductController;

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

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::get('languages', [LanguageController::class, 'index']);

Route::middleware('auth:api')->group(function () {
    Route::get('/get-order/{id}', [OrderController::class, 'getOrder']);
    Route::apiResource('orders', OrderController::class);
    Route::apiResource('products', ProductController::class);
    Route::post('add-prod-name', [ProductController::class, 'addNewName']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('user', [AuthController::class, 'authorizeUser']);
});

