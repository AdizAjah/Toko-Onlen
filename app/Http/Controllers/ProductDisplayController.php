<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductDisplayController extends Controller
{
    /**
     * Menampilkan halaman detail satu produk.
     */
    public function show(Product $product)
    {
        // Ambil produk serupa berdasarkan kategori yang sama, kecuali produk ini sendiri
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->latest()
            ->take(10)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }
}
