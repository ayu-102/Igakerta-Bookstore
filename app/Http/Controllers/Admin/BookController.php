<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\Author;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with(['category', 'author', 'publisher']);

        // Filter berdasarkan Tipe (opsional dari dropdown filter)
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter Search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '\%' . $request->search . '%')
                    ->orWhere('isbn', 'like', '%' . $request->search . '%');
            });
        }

        // Filter Kategori
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $books = $query->latest()->paginate(10);

        // AMBIL DATA KATEGORI UNTUK DROPDOWN FILTER
        $categories = Category::all();

        // PASSING $categories BERSAMA$books KE VIEW
        return view('admin.books.index', compact('books', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        $authors    = Author::orderBy('name', 'asc')->get();
        $publishers = Publisher::orderBy('name', 'asc')->get();

        return view('admin.books.create', compact('categories', 'authors', 'publishers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'            => 'required|string|max:255',
            'type'             => 'required|in:physical,ebook',
            'category_id'      => 'required|exists:categories,id',
            'author_id'        => 'required|exists:authors,id',
            'publisher_id'     => 'nullable|exists:publishers,id',
            'price'            => 'required|numeric|min:0',
            'stock'            => 'required_if:type,physical|nullable|integer|min:0',
            'file_pdf'         => 'nullable|file|mimes:pdf,epub|max:20480',
            'description'      => 'nullable|string',
            'cover_image'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',

            // Validasi Detail Tambahan
            'isbn'             => 'nullable|string|max:50',
            'publication_year' => 'nullable|numeric',
            'pages'            => 'nullable|integer',
            'dimensions'       => 'nullable|string|max:50',
            'weight'           => 'nullable|string|max:50',
            'language'         => 'nullable|string|max:50',
            'cover_type'       => 'nullable|in:Soft Cover,Hard Cover',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title) . '-' . Str::random(5);
        $data['is_featured'] = $request->has('is_featured') ? 1 : 0;

        // Jika tipe E-Book, stok diset ke 9999 (unlimited/digital)
        if ($request->type === 'ebook') {
            $data['stock'] = 9999;
        }

        // Upload Cover Image
        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('books/covers', 'public');
        }

        // Upload File E-Book (PDF/EPUB)
        if ($request->type === 'ebook' && $request->hasFile('file_pdf')) {
            $data['file_pdf'] = $request->file('file_pdf')->store('books/ebooks', 'public');
        }

        Book::create($data);

        return redirect()->route('admin.books.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Book $book)
    {
        $categories = Category::all();
        $authors    = Author::orderBy('name', 'asc')->get();
        $publishers = Publisher::orderBy('name', 'asc')->get();

        return view('admin.books.edit', compact('book', 'categories', 'authors', 'publishers'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title'            => 'required|string|max:255',
            'type'             => 'required|in:physical,ebook',
            'category_id'      => 'required|exists:categories,id',
            'author_id'        => 'required|exists:authors,id',
            'publisher_id'     => 'nullable|exists:publishers,id',
            'price'            => 'required|numeric|min:0',
            'stock'            => 'required_if:type,physical|nullable|integer|min:0',
            'file_pdf'         => 'nullable|file|mimes:pdf,epub|max:20480',
            'description'      => 'nullable|string',
            'cover_image'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',

            // Validasi Detail Tambahan
            'isbn'             => 'nullable|string|max:50',
            'publication_year' => 'nullable|numeric',
            'pages'            => 'nullable|integer',
            'dimensions'       => 'nullable|string|max:50',
            'weight'           => 'nullable|string|max:50',
            'language'         => 'nullable|string|max:50',
            'cover_type'       => 'nullable|in:Soft Cover,Hard Cover',
        ]);

        $data = $request->all();
        $data['is_featured'] = $request->has('is_featured') ? 1 : 0;

        // Update slug hanya jika judul berubah
        if ($request->title !== $book->title) {
            $data['slug'] = Str::slug($request->title) . '-' . Str::random(5);
        } else {
            unset($data['slug']);
        }

        if ($request->type === 'ebook') {
            $data['stock'] = 9999;
        }

        // Update Cover
        if ($request->hasFile('cover_image')) {
            if ($book->cover_image && Storage::disk('public')->exists($book->cover_image)) {
                Storage::disk('public')->delete($book->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('books/covers', 'public');
        }

        // Update File PDF
        if ($request->type === 'ebook' && $request->hasFile('file_pdf')) {
            if ($book->file_pdf && Storage::disk('public')->exists($book->file_pdf)) {
                Storage::disk('public')->delete($book->file_pdf);
            }
            $data['file_pdf'] = $request->file('file_pdf')->store('books/ebooks', 'public');
        }

        $book->update($data);

        return redirect()->route('admin.books.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Book $book)
    {
        if ($book->cover_image && Storage::disk('public')->exists($book->cover_image)) {
            Storage::disk('public')->delete($book->cover_image);
        }

        if ($book->file_pdf && Storage::disk('public')->exists($book->file_pdf)) {
            Storage::disk('public')->delete($book->file_pdf);
        }

        $book->delete();

        return redirect()->route('admin.books.index')->with('success', 'Produk berhasil dihapus!');
    }

    public function show($id)
    {
        // Eager load reviews & promosinya yang sedang aktif
        $book = Book::with(['category', 'author', 'publisher', 'reviews', 'promotions' => function ($query) {
            $query->where('is_active', true)
                ->where('start_date', '<=', now())
                ->where('end_date', '>=', now());
        }])->findOrFail($id);

        // Ambil persentase diskon promo jika ada
        $activePromotion = $book->promotions->first();
        $discountPercent = 0;
        if ($activePromotion) {
            $discountPercent = $activePromotion->pivot->discount_percent
                ?? $activePromotion->discount_percent
                ?? 0;
        }

        // Cek apakah user yang terautentikasi sudah pernah membeli buku ini
        $hasPurchased = false;
        if (Auth::check()) {
            $hasPurchased = \App\Models\OrderItem::whereHas('order', function ($q) {
                $q->where('user_id', Auth::id())
                    ->whereIn('status', ['completed', 'success', 'paid']);
            })->where('book_id', $book->id)->exists();
        }

        // Ambil rekomendasi buku terkait dalam kategori sama
        $relatedBooks = Book::where('category_id', $book->category_id)
            ->where('id', '!=', $book->id)
            ->take(4)
            ->get();

        return view('books.show', compact('book', 'discountPercent', 'relatedBooks', 'hasPurchased'));
    }
}
