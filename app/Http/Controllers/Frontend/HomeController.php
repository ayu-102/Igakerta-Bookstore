<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\Banner;
use App\Models\Testimonial;
use App\Models\Voucher;
use App\Models\Order; // sesuaikan dengan nama model transaksi Anda
use App\Models\Author;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::withCount('books')->get();
        $banners = Banner::where('is_active', 1)->latest()->get();

        $query = Book::with(['category', 'author']);

        if ($request->has('category') && $request->category != '') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->has('search') && $request->search != '') {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhereHas('author', function ($authorQuery) use ($request) {
                        $authorQuery->where('name', 'like', '%' . $request->search . '%');
                    });
            });
        }

        $books = $query->latest()->get();

        // 1. Buku Featured (Bestseller)
        $featuredBooks = Book::with(['category', 'author'])->where('is_featured', 1)->latest()->take(4)->get();

        // 2. Buku Terbaru / New Releases
        $newReleases = Book::with(['category', 'author'])->latest()->take(4)->get();

        // AMBIL 6 PENULIS DARI TABEL AUTHORS BESERTA JUMLAH BUKUNYA
        $featuredAuthors = Author::where('is_featured', 1)
            ->withCount('books')
            ->orderBy('books_count', 'desc')
            ->take(6)
            ->get();

        // Ambil ulasan pembaca
        if (Schema::hasColumn('testimonials', 'is_active')) {
            $testimonials = Testimonial::where('is_active', true)->latest()->take(6)->get();
            if ($testimonials->isEmpty()) {
                $testimonials = Testimonial::latest()->take(6)->get();
            }
        } else {
            $testimonials = Testimonial::latest()->take(6)->get();
        }

        return view('frontend.index', compact('categories', 'books', 'featuredBooks', 'newReleases', 'banners', 'featuredAuthors', 'testimonials'));
    }

    // 3. Menampilkan Detail Buku
    // 3. Menampilkan Detail Buku
    public function show(Request $request, $id)
    {
        $book = Book::with(['category', 'author', 'reviews.user'])->findOrFail($id);

        $avgRating = $book->reviews()->avg('rating') ?? 0;
        $totalReviews = $book->reviews()->count();

        $relatedBooks = Book::where('category_id', $book->category_id)
            ->where('id', '!=', $id)
            ->latest()
            ->take(4)
            ->get();

        // Pengecekan status pembelian user
        $hasPurchased = false;

        if (Auth::check()) {
            $hasPurchased = Order::where('user_id', Auth::id())
                ->whereIn('status', ['completed', 'paid', 'success'])
                ->whereHas('items', function ($query) use ($id) {
                    $query->where('book_id', $id);
                })
                ->exists();
        }

        // --- LOGIKA VARIAN HARGA (CETAK & EBOOK) ---
        // Cek apakah halaman dibuka via link query param misal: ?type=ebook
        $defaultType = $request->get('type', $book->type);
        $isEbookDefault = ($defaultType === 'ebook');

        // Kalkulasi Harga Buku Cetak (Physical)
        $pricePhysical = $book->discount_price && $book->discount_price > 0 ? $book->discount_price : $book->price;
        $strikePhysical = $book->discount_price && $book->discount_price > 0 ? $book->price : 0;

        // Kalkulasi Harga Ebook (Bisa disesuaikan jika Anda punya kolom tersendiri seperti ebook_price)
        $ebookPriceRaw = $book->ebook_price ?? $book->price;
        $ebookDiscountRaw = $book->ebook_discount_price ?? $book->discount_price;

        $priceEbook = $ebookDiscountRaw && $ebookDiscountRaw > 0 ? $ebookDiscountRaw : $ebookPriceRaw;
        $strikeEbook = $ebookDiscountRaw && $ebookDiscountRaw > 0 ? $ebookPriceRaw : 0;

        return view('frontend.show', compact(
            'book',
            'avgRating',
            'totalReviews',
            'relatedBooks',
            'hasPurchased',
            'isEbookDefault',
            'pricePhysical',
            'strikePhysical',
            'priceEbook',
            'strikeEbook'
        ));
    }

    public function catalog(Request $request)
    {
        $categories = Category::withCount('books')->get();

        $query = Book::with(['category', 'author']);
        $query->where('type', 'physical');

        // Filter Pencarian Keyword (Judul / ISBN / Nama Penulis)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('isbn', 'like', '%' . $search . '%')
                    ->orWhereHas('author', function ($authorQuery) use ($search) {
                        $authorQuery->where('name', 'like', '%' . $search . '%');
                    });
            });
        }

        // Filter Spesifik Penulis
        if ($request->filled('author_id')) {
            $query->where('author_id', $request->author_id);
        }

        // Filter Kategori (Mendukung slug atau ID)
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category)->orWhere('id', $request->category);
            });
        }

        // Filter Diskon / Promo
        if ($request->filter === 'promo') {
            $query->whereNotNull('discount_price')->where('discount_price', '>', 0);
        }

        // Filter Best Seller
        if ($request->filter === 'bestseller') {
            $query->where('is_featured', 1);
        }

        // Filter Harga
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Sorting / Pengurutan
        if ($request->sort == 'price_low') {
            $query->orderBy('price', 'asc');
        } elseif ($request->sort == 'price_high') {
            $query->orderBy('price', 'desc');
        } else {
            $query->latest();
        }

        // Menggunakan withQueryString agar param ?search=...&category=... tetap ikut saat pindah halaman
        $books = $query->paginate(12)->withQueryString();

        // Ambil daftar penulis resmi untuk dropdown filter di sidebar
        $authors = Author::orderBy('name', 'asc')->get();

        return view('frontend.catalog', compact('books', 'categories', 'authors'));
    }

    public function ebook(Request $request)
    {
        $query = Book::with(['category', 'author']);

        // SESUAIKAN DENGAN MIGRASI KAMU (kolom 'type', nilai 'ebook')
        $query->where('type', 'ebook');

        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category)->orWhere('id', $request->category);
            });
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhereHas('author', function ($authorQuery) use ($request) {
                        $authorQuery->where('name', 'like', '%' . $request->search . '%');
                    });
            });
        }

        if ($request->filled('author_id')) {
            $query->where('author_id', $request->author_id);
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->sort == 'price_low') {
            $query->orderBy('price', 'asc');
        } elseif ($request->sort == 'price_high') {
            $query->orderBy('price', 'desc');
        } else {
            $query->latest();
        }

        $books = $query->paginate(12)->withQueryString();
        $categories = Category::withCount('books')->get();
        $authors = Author::orderBy('name', 'asc')->get();

        return view('frontend.ebook', compact('books', 'categories', 'authors'));
    }





    // Halaman Daftar Penulis Frontend (/penulis)
    public function authors(Request $request)
    {
        $query = Author::withCount('books');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $authors = $query->orderBy('name', 'asc')->paginate();
        $categories = Category::all();

        return view('frontend.authors.index', compact('authors', 'categories'));
    }

    public function promo()
    {
        // 1. Ambil voucher yang aktif dan belum expired
        $vouchers = Voucher::where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('expiry_date')
                    ->orWhereDate('expiry_date', '>=', Carbon::today());
            })
            ->get();

        // 2. Ambil buku yang memiliki harga diskon (discount_price > 0)
        $promoBooks = Book::whereNotNull('discount_price')
            ->where('discount_price', '>', 0)
            ->latest()
            ->paginate(12);

        return view('frontend.promo', compact('vouchers', 'promoBooks'));
    }

    // Halaman Detail Penulis Frontend (/penulis/{id})
    public function authorShow($id)
    {
        $author = Author::with('books.category')->findOrFail($id);

        return view('frontend.authors.show', compact('author'));
    }
}
