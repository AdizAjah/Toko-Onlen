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
        // Kita akan membuat view 'products.show'
        // dan mengirimkan data produk yang di-klik
        return view('products.show', compact('product'));
    }
}
