<?php

namespace App\Http\Controllers;

use App\Models\Book;

class WishlistController extends Controller
{
    // Tampilkan Halaman Wishlist
    public function index()
    {
        $wishlist = session()->get('wishlist', []);

        // Ambil 6 buku rekomendasi secara acak beserta data penulisnya
        $recommendations = Book::with('author')->inRandomOrder()->take(6)->get();

        return view('wishlist', compact('wishlist', 'recommendations'));
    }
    // Toggle Wishlist (Tambah jika belum ada, Hapus jika sudah ada)
    public function toggle($id)
    {
        $book = Book::findOrFail($id);
        $wishlist = session()->get('wishlist', []);

        if (isset($wishlist[$id])) {
            unset($wishlist[$id]);
            session()->put('wishlist', $wishlist);
            return redirect()->back()->with('success', 'Buku dihapus dari Wishlist!');
        }

        $wishlist[$id] = [
            'id' => $book->id,
            'title' => $book->title,
            'price' => $book->price,
            'cover_image' => $book->cover_image,
            'stock' => $book->stock
        ];

        session()->put('wishlist', $wishlist);
        return redirect()->back()->with('success', 'Buku berhasil ditambahkan ke Wishlist!');
    }

    // Pindahkan dari Wishlist ke Keranjang
    public function moveToCart($id)
    {
        $wishlist = session()->get('wishlist', []);

        if (isset($wishlist[$id])) {
            // Panggil logic penambahan cart atau simpan manual ke session cart
            $book = Book::findOrFail($id);

            if ($book->stock <= 0) {
                return redirect()->back()->with('error', 'Stok buku habis, tidak bisa dipindah ke keranjang.');
            }

            $cart = session()->get('cart', []);
            if (isset($cart[$id])) {
                $cart[$id]['quantity']++;
            } else {
                $cart[$id] = [
                    "title" => $book->title,
                    "quantity" => 1,
                    "price" => $book->price,
                    "cover_image" => $book->cover_image
                ];
            }
            session()->put('cart', $cart);

            // Hapus dari wishlist
            unset($wishlist[$id]);
            session()->put('wishlist', $wishlist);

            return redirect()->route('cart.index')->with('success', 'Buku dipindahkan ke Keranjang!');
        }

        return redirect()->back()->with('error', 'Buku tidak ditemukan di Wishlist.');
    }

    // Hapus dari Wishlist
    public function remove($id)
    {
        $wishlist = session()->get('wishlist', []);
        if (isset($wishlist[$id])) {
            unset($wishlist[$id]);
            session()->put('wishlist', $wishlist);
        }
        return redirect()->back()->with('success', 'Buku dihapus dari Wishlist!');
    }
}
