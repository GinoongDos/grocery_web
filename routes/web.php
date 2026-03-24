<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\ProductBrowseController;
use App\Http\Controllers\CartController;
use App\Models\Product;

Route::get('/', function () {
    return view('welcome');
});

// Public product browsing
Route::get('/products', [ProductBrowseController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductBrowseController::class, 'show'])->name('products.show');

// Authenticated dashboard - redirect admins to admin dashboard
Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user && method_exists($user, 'isAdmin') && $user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }

    $products = Product::with('category')->latest()->paginate(12);

    return view('dashboard', compact('products'));
})->middleware(['auth', 'verified'])->name('dashboard');

// User profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin routes (dashboard + CRUD)
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
});

// Authenticated cart + checkout
Route::middleware('auth')->group(function () {
    Route::post('/cart/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::patch('/cart/{product}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{product}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
});

require __DIR__.'/auth.php';
