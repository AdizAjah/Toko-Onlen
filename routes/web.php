<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
// Import ProductController kita
use App\Http\Controllers\Admin\ProductController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// === RUTE ADMIN UNTUK PRODUK ===
// Kita kelompokkan rute admin di sini
// 'prefix' => 'admin' -> URL akan menjadi /admin/products
// 'name' => 'admin.' -> Nama rute akan menjadi admin.products.index
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Ini akan otomatis membuat rute untuk:
    // index, create, store, show, edit, update, destroy
    Route::resource('products', ProductController::class);
});


require __DIR__.'/auth.php';
