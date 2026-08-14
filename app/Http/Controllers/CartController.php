<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Voucher;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // 1. Tampilkan Halaman Keranjang
    public function index()
    {
        $cart = session()->get('cart', []);

        // Ambil 6 rekomendasi buku acak beserta relasi author
        $recommendations = Book::with('author')->inRandomOrder()->take(6)->get();

        return view('cart', compact('cart', 'recommendations'));
    }

    // 2. Tambah Buku ke Keranjang (Session)
    public function add(Request $request, $id)
    {
        $book = Book::with('author')->findOrFail($id);

        // Cek jika stok buku habis
        if ($book->stock <= 0) {
            return redirect()->back()->with('error', 'Maaf, stok buku ini sedang habis!');
        }

        $cart = session()->get('cart', []);

        // Cek kuantitas yang ada di keranjang agar tidak melebihi stok
        $currentQty = isset($cart[$id]) ? $cart[$id]['quantity'] : 0;
        if ($currentQty + 1 > $book->stock) {
            return redirect()->back()->with('error', 'Jumlah melebihi batas stok yang tersedia!');
        }

        // Penanganan nama penulis secara aman
        $authorName = is_object($book->author) ? ($book->author->name ?? 'Penulis') : ($book->author ?? 'Penulis');
        // Tentukan harga yang dipakai (gunakan harga diskon jika ada dan lebih murah dari harga normal)
        $finalPrice = (isset($book->discount_price) && $book->discount_price < $book->price)
            ? $book->discount_price
            : $book->price;

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "title"       => $book->title,
                "author"      => $authorName,
                "quantity"    => 1,
                "price"       => $finalPrice, // <-- HARGA DISKON DIPAKAI
                "cover_image" => $book->cover_image
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Buku berhasil ditambahkan ke keranjang!');
    }

    public function applyVoucher(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        // Cari voucher berdasarkan kode yang aktif
        $voucher = Voucher::where('code', $request->code)
            ->where('is_active', true)
            ->first();

        if (!$voucher) {
            return back()->with('error', 'Kode voucher tidak valid atau sudah kadaluwarsa!');
        }

        // Ambil nilai nominal/diskon dari atribut model (menyesuaikan nama kolom di DB)
        $discountValue = $voucher->discount
            ?? $voucher->nominal
            ?? $voucher->discount_amount
            ?? $voucher->amount
            ?? 0;

        // Simpan data voucher ke dalam Session
        session()->put('voucher', [
            'code'     => $voucher->code,
            'type'     => strtolower($voucher->type ?? $voucher->discount_type ?? 'fixed'), // di-lowercase agar 'PERSENTASE' jadi 'persentase'
            'discount' => (float) $discountValue,
        ]);

        return back()->with('success', 'Voucher berhasil diterapkan!');
    }

    public function removeVoucher()
    {
        session()->forget('voucher');
        return back()->with('success', 'Voucher berhasil dihapus!');
    }

    // 3. Update Jumlah Buku di Keranjang
    public function update(Request $request, $id)
    {
        if ($id && $request->quantity) {
            $book = Book::find($id);
            $newQty = max(1, (int)$request->quantity);

            // Validasi stok jika pembeli menambah Qty di keranjang
            if ($book && $newQty > $book->stock) {
                return redirect()->route('cart.index')->with('error', 'Stok hanya tersedia ' . $book->stock . ' buku.');
            }

            $cart = session()->get('cart');
            $cart[$id]["quantity"] = $newQty;
            session()->put('cart', $cart);
        }
        return redirect()->route('cart.index')->with('success', 'Keranjang berhasil diperbarui!');
    }

    // 4. Hapus Buku dari Keranjang
    public function remove($id)
    {
        $cart = session()->get('cart');
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return redirect()->route('cart.index')->with('success', 'Buku dihapus dari keranjang!');
    }

    // 5. Generate Link WhatsApp, Potong Stok Otomatis, & Buat Format Pesan
    public function checkoutWhatsApp(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'alamat' => 'required|string',
            'pembayaran' => 'required|string',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Keranjang Anda masih kosong!');
        }

        // --- CEK DAN KURANGI STOK DI DATABASE AUTOMATIS ---
        foreach ($cart as $id => $item) {
            $book = Book::find($id);
            if ($book) {
                // Kurangi stok sesuai jumlah yang dibeli (stok minimal 0 agar tidak minus)
                $book->stock = max(0, $book->stock - $item['quantity']);
                $book->save();
            }
        }

        $noAdmin = "6285124157382"; // Nomor WA Admin Iga Kerta
        $catatan = $request->catatan ? $request->catatan : '-';

        // Format Pesan WhatsApp Simpel & Rapi
        $pesan = "*HALO IGAKERTA BOOKSTORE, SAYA INGIN ORDER BUKU*\n\n";

        $pesan .= "*DATA PEMESANAN*\n";
        $pesan .= "• *Nama:* " . $request->nama . "\n";
        $pesan .= "• *No. WA:* " . $request->phone . "\n";
        $pesan .= "• *Alamat:* " . $request->alamat . "\n";
        $pesan .= "• *Metode Bayar:* " . $request->pembayaran . "\n";
        $pesan .= "• *Catatan:* " . $catatan . "\n\n";

        $pesan .= "*DAFTAR PESANAN*\n";

        $totalHarga = 0;
        foreach ($cart as $item) {
            $subtotal = $item['price'] * $item['quantity'];
            $totalHarga += $subtotal;
            $pesan .= "• *" . $item['title'] . "* (" . $item['quantity'] . "x) - Rp " . number_format($subtotal, 0, ',', '.') . "\n";
        }

        $pesan .= "\n*TOTAL:* *Rp " . number_format($totalHarga, 0, ',', '.') . "*";

        // Kosongkan keranjang belanja setelah checkout
        session()->forget('cart');

        // Redirect langsung ke WhatsApp
        $urlWhatsApp = "https://wa.me/" . $noAdmin . "?text=" . urlencode($pesan);

        return redirect()->away($urlWhatsApp);
    }
}
