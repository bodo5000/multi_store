<?php

use App\Http\Controllers\Front\Auth\TwoFactorAuthController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\ProductsController;

Route::get('/', [HomeController::class, 'index'])->name('front.home');
Route::get('/products', [ProductsController::class, 'index'])->name('front.products.index');
Route::get('/products/{product:slug}', [ProductsController::class, 'show'])->name('front.products.show');
Route::resource('/cart', CartController::class)->except(['show', 'create', 'edit']);
Route::get('/checkout', [CheckoutController::class, 'create'])->name('checkout');
Route::post('/checkout', [CheckoutController::class, 'store']);

Route::middleware('auth')->group(function () {
    Route::get('auth/user/2fa', [TwoFactorAuthController::class, 'index'])->name('front.2fa');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// require __DIR__ . '/auth.php';

require __DIR__ . '/dashboard.php';
