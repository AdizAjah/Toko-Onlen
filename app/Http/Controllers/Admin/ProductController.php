<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Pastikan ini di-import
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil produk dengan relasi kategori (untuk efisiensi) dan stok
        $products = Product::with('category')->latest()->get();
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0', // Validasi stok
            'category_id' => 'required|exists:categories,id',
            
            // MODIFIKASI: Ubah 'required' menjadi 'nullable'
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image_url')) {
            // Simpan gambar ke 'storage/app/public/products'
            $imagePath = $request->file('image_url')->store('products', 'public');
            $validated['image_url'] = $imagePath;
        }

        Product::create($validated);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        // Tidak digunakan di admin panel kita, tapi bisa diisi jika perlu
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0', // Validasi stok
            'category_id' => 'required|exists:categories,id',
            
            // Validasi update gambar sudah benar (nullable)
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Logika untuk update gambar
        if ($request->hasFile('image_url')) {
            // 1. Hapus gambar lama jika ada
            if ($product->image_url && Storage::disk('public')->exists($product->image_url)) {
                Storage::disk('public')->delete($product->image_url);
            }

            // 2. Simpan gambar baru
            $imagePath = $request->file('image_url')->store('products', 'public');
            $validated['image_url'] = $imagePath;
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Hapus gambar dari storage JIKA ada
        if ($product->image_url && Storage::disk('public')->exists($product->image_url)) {
            Storage::disk('public')->delete($product->image_url);
        }

        // Hapus produk dari database
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus.');
    }

    /**
     * Menghapus gambar produk secara spesifik.
     */
    public function destroyImage(Product $product)
    {
        if ($product->image_url && Storage::disk('public')->exists($product->image_url)) {
            Storage::disk('public')->delete($product->image_url);
            $product->image_url = null; // Setel kolom di DB jadi null
            $product->save();
            return redirect()->back()->with('success', 'Gambar produk berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'Tidak ada gambar untuk dihapus.');
    }
}

