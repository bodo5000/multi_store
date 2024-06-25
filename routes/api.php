<?php

use App\Http\Controllers\Api\AccessTokensController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductsController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('/products', ProductsController::class);

Route::post('auth/access-tokens', [AccessTokensController::class, 'store'])->middleware('guest:sanctum');
Route::delete('auth/access-tokens/{token?}', [AccessTokensController::class, 'destroy'])->middleware('auth:sanctum');
