<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\CartController; // <-- IMPORT CartController
use App\Models\Product; // <-- IMPORT Product Model
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    // Arahkan halaman utama ke dashboard jika sudah login, atau ke login jika belum
    if (Auth::check()) {
        return redirect('/dashboard');
    }
    return view('auth.login');
});

// MODIFIKASI: Ubah route dashboard
// Tidak lagi hanya menampilkan view, tapi juga mengambil data produk
Route::get('/dashboard', function () {
    // Ambil semua produk
    $products = Product::all();
    // Kirim data produk ke view dashboard
    return view('dashboard', compact('products'));
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // === RUTE KERANJANG (UNTUK USER) ===
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'store'])->name('cart.store');
    Route::delete('/cart/item/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');
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

// === RUTE BARU UNTUK HALAMAN DETAIL PRODUK ===
// Menggunakan Route Model Binding (Product $product) untuk otomatis fetch data
Route::get('/products/{product}', function (Product $product) {
    // Buat folder 'products' di 'resources/views'
    return view('products.show', compact('product')); 
})->middleware(['auth', 'verified'])->name('products.show');
// ===============================================

require __DIR__.'/auth.php';

