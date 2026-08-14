<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Promotion;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function index()
    {
        $promotions = Promotion::withCount('books')->latest()->paginate(10);
        return view('admin.promos.index', compact('promotions'));
    }

    public function create()
    {
        $books = Book::select('id', 'title', 'price', 'cover_image')->get();
        return view('admin.promos.create', compact('books'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'discount_percentage' => 'required|numeric|min:1|max:100',
            'book_ids' => 'required|array|min:1',
            'book_ids.*' => 'exists:books,id',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ], [
            'book_ids.required' => 'Pilih minimal satu buku untuk diberi diskon!',
            'discount_percentage.min' => 'Diskon minimal 1%',
            'discount_percentage.max' => 'Diskon maksimal 100%',
        ]);

        // 1. Simpan Data Promo
        $promo = Promotion::create([
            'name' => $request->name,
            'discount_percentage' => $request->discount_percentage,
            'is_active' => $request->has('is_active') ? 1 : 0,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        // 2. Hubungkan Buku dengan Promo (Sync Checkbox)
        $promo->books()->sync($request->book_ids);

        // 3. Update Kolom discount_price di Tabel Books secara otomatis
        $this->updateBooksDiscountPrice($request->book_ids, $request->discount_percentage);

        return redirect()->route('admin.promos.index')->with('success', 'Promo berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $promo = Promotion::with('books')->findOrFail($id);
        $books = Book::select('id', 'title', 'price', 'cover_image')->get();
        $selectedBookIds = $promo->books->pluck('id')->toArray();

        return view('admin.promos.edit', compact('promo', 'books', 'selectedBookIds'));
    }

    public function update(Request $request, $id)
    {
        $promo = Promotion::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'discount_percentage' => 'required|numeric|min:1|max:100',
            'book_ids' => 'required|array|min:1',
            'book_ids.*' => 'exists:books,id',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        // Reset discount_price buku-buku lama sebelum di-update
        $oldBookIds = $promo->books->pluck('id')->toArray();
        Book::whereIn('id', $oldBookIds)->update(['discount_price' => null]);

        // Update Promo
        $promo->update([
            'name' => $request->name,
            'discount_percentage' => $request->discount_percentage,
            'is_active' => $request->has('is_active') ? 1 : 0,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        // Sync Ulang Checkbox Buku
        $promo->books()->sync($request->book_ids);

        // Update discount_price terbaru
        if ($request->has('is_active')) {
            $this->updateBooksDiscountPrice($request->book_ids, $request->discount_percentage);
        }

        return redirect()->route('admin.promos.index')->with('success', 'Data promo berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $promo = Promotion::findOrFail($id);

        // Reset discount_price pada buku terkait
        $bookIds = $promo->books->pluck('id')->toArray();
        Book::whereIn('id', $bookIds)->update(['discount_price' => null]);

        $promo->delete();

        return redirect()->route('admin.promos.index')->with('success', 'Promo berhasil dihapus!');
    }

    // Helper Fungsi untuk Mengukur & Memperbarui Harga Diskon di Tabel Books
    private function updateBooksDiscountPrice($bookIds, $percentage)
    {
        $books = Book::whereIn('id', $bookIds)->get();

        foreach ($books as $book) {
            $discountAmount = ($book->price * $percentage) / 100;
            $finalDiscountPrice = $book->price - $discountAmount;

            $book->update([
                'discount_price' => $finalDiscountPrice
            ]);
        }
    }
}
