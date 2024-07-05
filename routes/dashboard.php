<?php

use App\Http\Controllers\Dashboard\AdminsController;
use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\ProductsController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\RolesController;
use Illuminate\Support\Facades\Route;


Route::group([
    'middleware' => ['auth:admin', 'verified'],
    'prefix' => 'admin/dashboard',
    'as' => 'dashboard.'
], function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/categories/trashed', [CategoriesController::class, 'trash'])->name('categories.trash');
    Route::put('/categories/{category}/restore', [CategoriesController::class, 'restore'])->name('categories.restore');
    Route::delete('/categories/{category}/force-delete', [CategoriesController::class, 'forceDelete'])->name('categories.force-delete');
    Route::resources(
        [
            'categories' => CategoriesController::class,
            'products' => ProductsController::class,
            'roles' => RolesController::class,
            'admins' => AdminsController::class,
        ]
    );

    // Route::resource('/categories', CategoriesController::class);
    // Route::resource('/products', ProductsController::class);
    // Route::resource('/roles', RolesController::class);
});
