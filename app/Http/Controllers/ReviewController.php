<?php

namespace App\Http\Controllers;


use App\Models\Order;
use App\Models\Review;
use App\Models\Testimonial; // Pastikan Model Testimonial sudah ada
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, $orderId)
    {
        // 1. Validasi input
        $request->validate([
            'store_rating'   => 'required|integer|min:1|max:5',
            'store_comment'  => 'nullable|string|max:1000',
            'book_ratings'   => 'required|array',
            'book_ratings.*' => 'required|integer|min:1|max:5',
            'book_comments'  => 'nullable|array',
            'book_comments.*' => 'nullable|string|max:1000',
        ], [
            'store_rating.required' => 'Silakan beri rating untuk toko kami.',
            'book_ratings.*.required' => 'Silakan beri rating bintang untuk setiap buku.',
        ]);

        // 2. Pastikan pesanan milik user dan statusnya sudah selesai
        $order = Order::where('id', $orderId)
            ->where('user_id', Auth::id())
            ->whereIn('status', ['completed', 'selesai'])
            ->firstOrFail();

        if (class_exists('App\Models\Testimonial')) {
            Testimonial::create([
                'name'      => Auth::user()->name,
                'role'      => 'Customer',
                'quote'     => $request->store_comment ?? 'Layanan toko sangat baik.',
                'rating'    => $request->store_rating ?? 5,
                'is_active' => 1,
            ]);
        }

        // 4. Simpan Ulasan Buku per Item
        foreach ($request->book_ratings as $bookId => $rating) {
            $comment = $request->book_comments[$bookId] ?? '';

            Review::updateOrCreate(
                [
                    'book_id' => $bookId,
                    'user_id' => Auth::id(),
                ],
                [
                    'rating'  => $rating,
                    'comment' => $comment,
                ]
            );
        }

        return redirect()->back()->with('success', 'Terima kasih! Ulasan & testimoni Anda berhasil disimpan.');
    }
}
