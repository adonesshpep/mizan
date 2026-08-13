<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/feed', [ProductController::class, 'feed'])->name('products.feed');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

Route::get('/dashboard', [ProductController::class, 'dashboard'])->name('dashboard');
Route::post('/dashboard/login', [ProductController::class, 'login'])->name('dashboard.login');
Route::post('/dashboard/logout', [ProductController::class, 'logout'])->name('dashboard.logout');
Route::post('/dashboard/products', [ProductController::class, 'store'])->name('dashboard.products.store');
Route::get('/dashboard/products/{product}/edit', [ProductController::class, 'edit'])->name('dashboard.products.edit');
Route::put('/dashboard/products/{product}', [ProductController::class, 'update'])->name('dashboard.products.update');
Route::delete('/dashboard/products/{product}', [ProductController::class, 'destroy'])->name('dashboard.products.destroy');
Route::delete('/dashboard/products/{product}/images/{image}', [ProductController::class, 'destroyImage'])->name('dashboard.products.images.destroy');
Route::get('/language/{locale}', [ProductController::class, 'switchLocale'])->name('locale.switch');
