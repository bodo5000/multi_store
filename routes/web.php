<?php

use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\ProductsController;

Route::get('/', [HomeController::class, 'index'])->name('front.home');
Route::get('/products', [ProductsController::class, 'index'])->name('front.products.index');
Route::get('/products/{product:slug}', [ProductsController::class, 'show'])->name('front.products.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

require __DIR__ . '/dashboard.php';
