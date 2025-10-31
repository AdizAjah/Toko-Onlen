<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Menampilkan halaman keranjang belanja user.
     */
    public function index()
    {
        $user_id = Auth::id();
        
        // Ambil item keranjang milik user, beserta data produk terkait
        $cartItems = Cart::where('user_id', $user_id)
                         ->with('product') // Eager load relasi product
                         ->get();

        // Hitung total harga
        $totalPrice = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });
        
        // Buat folder 'cart' di dalam 'resources/views'
        return view('cart.index', compact('cartItems', 'totalPrice'));
    }

    /**
     * Menyimpan produk ke keranjang.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $user_id = Auth::id();
        $product_id = $request->product_id;
        $quantity = $request->input('quantity', 1); // Default quantity 1

        // Cek apakah produk sudah ada di keranjang user
        $existingItem = Cart::where('user_id', $user_id)
                            ->where('product_id', $product_id)
                            ->first();

        if ($existingItem) {
            // Jika sudah ada, tambahkan quantity-nya
            $existingItem->quantity += $quantity;
            $existingItem->save();
        } else {
            // Jika belum ada, buat entri baru
            Cart::create([
                'user_id' => $user_id,
                'product_id' => $product_id,
                'quantity' => $quantity,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    /**
     * Menghapus item dari keranjang.
     */
    public function destroy(Cart $cart)
    {
        // Pastikan user hanya bisa menghapus item miliknya sendiri
        if ($cart->user_id !== Auth::id()) {
            return abort(403, 'Aksi tidak diizinkan.');
        }

        $cart->delete();

        return redirect()->route('cart.index')->with('success', 'Produk berhasil dihapus dari keranjang.');
    }
}
