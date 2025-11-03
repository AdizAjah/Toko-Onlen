<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Models\Category;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\CartController;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder; // <-- Pastikan import ini ada

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route Dashboard (Versi final dengan SEMUA filter)
Route::get('/dashboard', function (Request $request) {
    
    $categories = Category::all(); // Ambil semua kategori
    
    // Ambil semua input filter
    $selectedCategory = $request->query('category_id');
    $search = $request->query('search');
    $minPrice = $request->query('min_price');
    $maxPrice = $request->query('max_price');

    // Mulai query produk
    $productsQuery = Product::query();

    // 1. Filter by Kategori
    if ($selectedCategory) {
        $productsQuery->where('category_id', $selectedCategory);
    }

    // 2. Filter by Harga
    if ($minPrice) {
        $productsQuery->where('price', '>=', $minPrice);
    }
    if ($maxPrice) {
        $productsQuery->where('price', '<=', $maxPrice);
    }

    // 3. Filter by Search (Nama, Deskripsi, ATAU Nama Kategori)
    if ($search) {
        $productsQuery->where(function (Builder $query) use ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('category', function (Builder $query) use ($search) {
                      $query->where('name', 'like', "%{$search}%");
                  });
        });
    }

    // Ambil produk (setelah difilter atau semua)
    $products = $productsQuery->latest()->get();

    // Kirim data ke view
    return view('dashboard', compact(
        'products', 
        'categories', 
        'selectedCategory',
        'search',       // Kirim nilai search kembali ke view
        'minPrice',     // Kirim nilai minPrice kembali ke view
        'maxPrice'      // Kirim nilai maxPrice kembali ke view
    ));

})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rute untuk Keranjang (Cart)
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::delete('/cart/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');

    // Rute untuk Halaman Detail Produk
    Route::get('/products/{product}', function (Product $product) {
        return view('products.show', compact('product'));
    })->name('products.show');
});

// Grup Rute untuk Admin
Route::middleware(['auth', 'admin'])->name('admin.')->prefix('admin')->group(function () {
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
});


require __DIR__.'/auth.php';

