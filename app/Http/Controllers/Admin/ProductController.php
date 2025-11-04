<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category; // Pastikan Category di-import
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // MODIFIKASI:
        // Kita gunakan ->with('category') untuk 'Eager Loading'
        // Ini lebih efisien daripada mengambil data kategori satu per satu di dalam loop
        $products = Product::with('category')->latest()->get();
        
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil semua kategori untuk dropdown
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data (termasuk kategori dan stok)
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id', // Validasi kategori
            'quantity' => 'required|integer|min:0', // Validasi stok
            'image_url' => 'nullable|url'
        ]);

        Product::create($validated);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

// ... (sisa controller tetap sama) ...

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        // (Biasanya tidak dipakai di resource Admin, tapi biarkan saja)
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        // Ambil semua kategori untuk dropdown
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        // Validasi data (termasuk kategori dan stok)
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id', // Validasi kategori
            'quantity' => 'required|integer|min:0', // Validasi stok
            'image_url' => 'nullable|url'
        ]);

        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus.');
    }
}

