<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil item keranjang milik user yang sedang login
        // 'with' digunakan untuk Eager Loading relasi produk, agar lebih efisien
        $cartItems = Cart::where('user_id', Auth::id())
                         ->with('product') // Pastikan relasi 'product' ada di model Cart
                         ->get();
        
        // MODIFIKASI: Hitung total harga
        $totalPrice = 0;
        foreach ($cartItems as $item) {
            // Pastikan produk ada untuk menghindari error jika produk dihapus
            if ($item->product) {
                $totalPrice += $item->quantity * $item->product->price;
            }
        }

        // Kirim data ke view, tambahkan $totalPrice
        return view('cart.index', compact('cartItems', 'totalPrice'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1' // Validasi quantity
        ]);

        $product = Product::find($request->product_id);
        $user = Auth::user();

        // Cek apakah produk sudah ada di keranjang user
        $cartItem = Cart::where('user_id', $user->id)
                        ->where('product_id', $product->id)
                        ->first();

        if ($cartItem) {
            // Jika sudah ada, tambahkan quantity-nya
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            // Jika belum ada, buat item baru
            Cart::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'quantity' => $request->quantity // Simpan quantity
            ]);
        }

        // MODIFIKASI:
        // Ganti redirect ke halaman keranjang, menjadi kembali ke halaman sebelumnya.
        // Pesan 'success' akan otomatis tampil sebagai "pop up" notifikasi.
        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        // Otorisasi: Pastikan user hanya bisa menghapus item keranjangnya sendiri
        if ($cart->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak diizinkan melakukan ini.');
        }

        $cart->delete();

        return redirect()->route('cart.index')->with('success', 'Produk berhasil dihapus dari keranjang.');
    }
}

