<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:1000',
        ]);

        // Cek apakah user sudah pernah rating produk ini
        $existingRating = \App\Models\Rating::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($existingRating) {
            // Update rating jika sudah ada
            $existingRating->update([
                'rating' => $request->rating,
                'review' => $request->review,
            ]);
            $message = 'Rating berhasil diperbarui.';
        } else {
            // Buat rating baru
            \App\Models\Rating::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'rating' => $request->rating,
                'review' => $request->review,
            ]);
            $message = 'Terima kasih atas penilaian Anda!';
        }

        return back()->with('success', $message);
    }
}
