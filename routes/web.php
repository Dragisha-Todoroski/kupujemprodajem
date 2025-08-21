<?php

use App\Http\Controllers\Frontend\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\AdController as AdminAdController;
use App\Http\Controllers\Frontend\AdController as FrontendAdController;
use Illuminate\Support\Facades\Route;

// -------------------- Profile routes --------------------
Route::middleware('auth')->prefix('profile')->name('profile.')->group(function () {
    Route::get('/', [ProfileController::class, 'edit'])->name('edit');
    Route::patch('/', [ProfileController::class, 'update'])->name('update');
    Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
});

// -------------------- Admin routes --------------------
Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/', [AdminController::class, 'index'])->name('dashboard');

    // Categories
    Route::get('categories', [CategoryController::class, 'index'])
        ->name('categories.index')
        ->middleware('can:viewAny,App\Models\Category');
    Route::get('categories/create', [CategoryController::class, 'create'])
        ->name('categories.create')
        ->middleware('can:create,App\Models\Category');
    Route::post('categories', [CategoryController::class, 'store'])
        ->name('categories.store')
        ->middleware('can:create,App\Models\Category');
    Route::get('categories/{category}/edit', [CategoryController::class, 'edit'])
        ->name('categories.edit')
        ->middleware('can:update,category');
    Route::put('categories/{category}', [CategoryController::class, 'update'])
        ->name('categories.update')
        ->middleware('can:update,category');
    Route::delete('categories/{category}', [CategoryController::class, 'destroy'])
        ->name('categories.destroy')
        ->middleware('can:delete,category');

    // Ads
    Route::get('ads', [AdminAdController::class, 'index'])
        ->name('ads.index')
        ->middleware('can:viewAny,App\Models\Ad');
    Route::get('ads/create', [AdminAdController::class, 'create'])
        ->name('ads.create')
        ->middleware('can:create,App\Models\Ad');
    Route::post('ads', [AdminAdController::class, 'store'])
        ->name('ads.store')
        ->middleware('can:create,App\Models\Ad');
    Route::get('ads/{ad}/edit', [AdminAdController::class, 'edit'])
        ->name('ads.edit')
        ->middleware('can:update,ad');
    Route::put('ads/{ad}', [AdminAdController::class, 'update'])
        ->name('ads.update')
        ->middleware('can:update,ad');
    Route::delete('ads/{ad}', [AdminAdController::class, 'destroy'])
        ->name('ads.destroy')
        ->middleware('can:delete,ad');

    // Customers
    Route::get('customers', [CustomerController::class, 'index'])
        ->name('customers.index')
        ->middleware('can:viewAny,App\Models\User');
    Route::get('customers/create', [CustomerController::class, 'create'])
        ->name('customers.create')
        ->middleware('can:create,App\Models\User');
    Route::post('customers', [CustomerController::class, 'store'])
        ->name('customers.store')
        ->middleware('can:create,App\Models\User');
    Route::get('customers/{customer}/edit', [CustomerController::class, 'edit'])
        ->name('customers.edit')
        ->middleware('can:update,customer');
    Route::put('customers/{customer}', [CustomerController::class, 'update'])
        ->name('customers.update')
        ->middleware('can:update,customer');
    Route::delete('customers/{customer}', [CustomerController::class, 'destroy'])
        ->name('customers.destroy')
        ->middleware('can:delete,customer');
});

// -------------------- Frontend customer ads routes --------------------
Route::middleware(['auth', 'is_customer'])->prefix('ads')->name('ads.')->group(function () {
    Route::get('create', [FrontendAdController::class, 'create'])
        ->name('create')
        ->middleware('can:create,App\Models\Ad');
    Route::post('/', [FrontendAdController::class, 'store'])
        ->name('store')
        ->middleware('can:create,App\Models\Ad');
    Route::get('{ad}/edit', [FrontendAdController::class, 'edit'])
        ->name('edit')
        ->middleware('can:update,ad');
    Route::put('{ad}', [FrontendAdController::class, 'update'])
        ->name('update')
        ->middleware('can:update,ad');
    Route::delete('{ad}', [FrontendAdController::class, 'destroy'])
        ->name('destroy')
        ->middleware('can:delete,ad');
});

// -------------------- Public ads routes --------------------
Route::get('/', [FrontendAdController::class, 'index'])->name('ads.index');
Route::get('/category/{categoryId}/ads', [FrontendAdController::class, 'category'])->name('ads.category');
Route::get('/ads/{ad}', [FrontendAdController::class, 'show'])->name('ads.show');

// Redirects /ads GET to homepage to avoid Whoops
Route::get('/ads', function () {
    return redirect()->route('ads.index');
});

require __DIR__.'/auth.php';
