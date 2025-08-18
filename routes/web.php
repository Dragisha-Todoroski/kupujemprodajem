<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AdController as AdminAdController;
use App\Http\Controllers\Frontend\AdController as FrontendAdController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



// Routes for admins
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth'])
    ->group(function () {
        // Admin dashboard
        Route::get('/', [AdminController::class, 'index'])->name('dashboard');

        // Admin Category CRUD
        Route::resource('categories', CategoryController::class)->except(['show']);

        // Admin Ad CRUD
        Route::resource('ads', AdminAdController::class)->except(['show']);
    });


// Routes for ads
Route::prefix('/')
    ->name('ads.')
    ->group(function () {
        /// Public  routes (accessible to everyone)
        Route::get('/', [FrontendAdController::class, 'index'])->name('index');
        Route::get('/ads/{ad}', [FrontendAdController::class, 'show'])->name('show');
        Route::get('/category/{categoryId}/ads', [FrontendAdController::class, 'category'])->name('category');

         // Authenticated customer routes
        Route::middleware('auth')->group(function () {
            Route::get('/ads/create', [FrontendAdController::class, 'create'])->name('create');
            Route::post('/ads', [FrontendAdController::class, 'store'])->name('store');
            Route::get('/ads/{ad}/edit', [FrontendAdController::class, 'edit'])->name('edit');
            Route::put('/ads/{ad}', [FrontendAdController::class, 'update'])->name('update');
            Route::delete('/ads/{ad}', [FrontendAdController::class, 'destroy'])->name('destroy');
        });
    });

require __DIR__.'/auth.php';
