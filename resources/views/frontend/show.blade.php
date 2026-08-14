@extends('layouts.app')

@php
    $authorName = is_object($book->author) ? $book->author->name ?? 'Penulis' : $book->author ?? 'Penulis';
    $authorTitle = is_object($book->author) ? $book->author->title ?? 'Penulis / Kreator' : 'Penulis / Kreator';
    $authorPhoto = is_object($book->author) ? $book->author->photo ?? null : null;

    // Hitung Rating Dinamis
    $totalReviews = $book->reviews_count ?? ($book->reviews ? count($book->reviews) : 0);
    $avgRating = $totalReviews > 0 ? round($book->reviews->avg('rating'), 1) : $book->rating ?? 5.0;
    $totalSold = $book->sold_count ?? 0;

    // Pengecekan Penulis Buku
    $isAuthorOfBook = false;
    if (auth()->check()) {
        $authorId = is_object($book->author) ? $book->author->id ?? null : null;
        $isAuthorOfBook = auth()->id() === $book->user_id || ($authorId && auth()->id() === $authorId);
    }

    $wishlist = session()->get('wishlist', []);
    $isWishlisted = isset($wishlist[$book->id]);
    $isEbookDefault = request('type') === 'ebook' || $book->type === 'ebook';

    // 1. Ambil Persentase Diskon secara dinamis
    if (!isset($discountPercent) || $discountPercent == 0) {
        if ($book->promotions && $book->promotions->where('is_active', 1)->first()) {
            $discountPercent = $book->promotions->where('is_active', 1)->first()->discount_percentage;
        } elseif ($book->discount_price && $book->price > 0) {
            $discountPercent = round((($book->price - $book->discount_price) / $book->price) * 100);
        } else {
            $discountPercent = 0;
        }
    }

    // 2. Tentukan Harga Dasar (Sesuai tipe buku di Database)
    if ($book->type === 'ebook') {
        // Jika buku dari DB sudah bertipe ebook, gunakan harga asli tanpa diskon 60%
        $basePhysicalPrice = $book->price;
        $baseEbookPrice = $book->price;
    } else {
        // Jika buku bertipe fisik, tentukan varian fisik dan varian ebook-nya (60%)
        $basePhysicalPrice = $book->price;
        $baseEbookPrice = $book->price * 0.6;
    }

    // 3. Hitung Harga Setelah Diskon
    if ($discountPercent > 0) {
        $pricePhysical = $basePhysicalPrice * (1 - $discountPercent / 100);
        $strikePhysical = $basePhysicalPrice;

        $priceEbook = $baseEbookPrice * (1 - $discountPercent / 100);
        $strikeEbook = $baseEbookPrice;
    } else {
        $pricePhysical = $basePhysicalPrice;
        $strikePhysical = 0;

        $priceEbook = $baseEbookPrice;
        $strikeEbook = 0;
    }

    $activePrice = $isEbookDefault ? $priceEbook : $pricePhysical;
    $strikePrice = $isEbookDefault ? $strikeEbook : $strikePhysical;
@endphp

@section('title', $book->title . ' - IGAKERTA Book Store')

@push('styles')
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        .detail-container {
            padding: 30px 6%;
        }

        .breadcrumb-wrap {
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-bottom: 25px;
        }

        .breadcrumb-wrap a {
            color: var(--primary-purple);
            font-weight: 600;
            text-decoration: none;
        }

        /* TOP SECTION GRID: COVER + INFO + ACTION SIDEBAR */
        .book-detail-grid {
            display: grid;
            grid-template-columns: 320px 1fr 300px;
            gap: 30px;
            align-items: start;
        }

        /* COVER & GALLERY */
        .cover-gallery {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .main-cover-box {
            position: relative;
            background: #F8FAFC;
            border-radius: 12px;
            padding: 20px;
            border: 1px solid #E2E8F0;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.06);
            text-align: center;
        }

        .main-cover-box img {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: -10px 10px 20px rgba(0, 0, 0, 0.15);
        }

        .badge-bestseller {
            position: absolute;
            top: 15px;
            left: 15px;
            background: #18003C;
            color: #FFC000;
            font-size: 0.7rem;
            font-weight: 800;
            padding: 4px 10px;
            border-radius: 4px;
            text-transform: uppercase;
        }

        /* INFO BUKU UTAMA */
        .category-tag {
            font-size: 0.8rem;
            font-weight: 700;
            color: #D97706;
            margin-bottom: 6px;
        }

        .book-main-title {
            font-size: 1.8rem;
            font-weight: 800;
            color: #1E0A3C;
            line-height: 1.3;
            margin-bottom: 8px;
        }

        .author-link {
            font-size: 0.9rem;
            color: #6B21A8;
            font-weight: 600;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .rating-summary-row {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.85rem;
            margin-bottom: 20px;
        }

        .stars {
            color: #FFC000;
            font-size: 0.9rem;
        }

        /* SPESIFIKASI GRID */
        .specs-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px 20px;
            background: #F8FAFC;
            border-radius: 10px;
            padding: 15px;
            font-size: 0.8rem;
            margin-bottom: 20px;
        }

        .spec-item {
            display: flex;
            gap: 8px;
            color: #64748B;
        }

        .spec-item i {
            color: #1E0A3C;
            width: 16px;
            margin-top: 2px;
        }

        .spec-item strong {
            color: #1E0A3C;
        }

        .action-secondary {
            display: flex;
            gap: 12px;
        }

        .btn-outline-action {
            flex: 1;
            padding: 8px 12px;
            border: 1px solid #CBD5E1;
            background: white;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 600;
            color: #334155;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            transition: 0.2s;
        }

        .btn-outline-action:hover {
            background: #F1F5F9;
        }

        .btn-outline-action.active-wishlist {
            background: #FEE2E2;
            color: #EF4444;
            border-color: #FCA5A5;
        }

        /* ACTION SIDEBAR (BOX CHECKOUT) */
        .action-sidebar {
            background: white;
            border: 1px solid #E2E8F0;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
            position: sticky;
            top: 90px;
        }

        .price-wrap {
            margin-bottom: 12px;
        }

        .main-price {
            font-size: 1.6rem;
            font-weight: 800;
            color: #1E0A3C;
        }

        .strike-price {
            text-decoration: line-through;
            color: #94A3B8;
            font-size: 0.88rem;
            margin-left: 6px;
        }

        .badge-discount {
            background: #FEE2E2;
            color: #EF4444;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 4px;
            margin-left: 6px;
            display: inline-block;
        }

        .stock-status {
            font-size: 0.8rem;
            font-weight: 700;
            color: #16A34A;
            margin-bottom: 18px;
        }

        .format-selector {
            margin-bottom: 18px;
        }

        .format-label {
            font-size: 0.8rem;
            font-weight: 700;
            color: #1E0A3C;
            margin-bottom: 8px;
            display: block;
        }

        .format-option {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 12px;
            border: 1px solid #E2E8F0;
            border-radius: 8px;
            margin-bottom: 8px;
            cursor: pointer;
            font-size: 0.8rem;
            transition: 0.2s;
        }

        .format-option.active {
            border-color: #1E0A3C;
            background: #F5EFFF;
            font-weight: 700;
        }

        .qty-picker {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .qty-btn-wrap {
            display: flex;
            align-items: center;
            border: 1px solid #CBD5E1;
            border-radius: 6px;
            overflow: hidden;
        }

        .qty-btn {
            background: #F8FAFC;
            border: none;
            width: 32px;
            height: 32px;
            cursor: pointer;
            font-weight: bold;
        }

        .qty-input {
            width: 40px;
            text-align: center;
            border: none;
            font-size: 0.85rem;
            font-weight: 700;
        }

        .btn-buy-now {
            width: 100%;
            background: #FFC000;
            color: #1E0A3C;
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-weight: 800;
            font-size: 0.9rem;
            cursor: pointer;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-add-cart {
            width: 100%;
            padding: 12px;
            background: #1E0A3C;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-bottom: 20px;
            transition: opacity 0.2s;
        }

        .btn-add-cart:hover {
            opacity: 0.9;
        }

        .guarantee-list {
            border-top: 1px solid #F1F5F9;
            padding-top: 15px;
            display: flex;
            flex-direction: column;
            gap: 8px;
            font-size: 0.72rem;
            color: #64748B;
        }

        /* SECTION MIDDLE & DESKRIPSI */
        .middle-section {
            margin-top: 40px;
            display: grid;
            grid-template-columns: 1fr 300px;
            gap: 30px;
        }

        .section-header-title {
            font-size: 1.1rem;
            font-weight: 800;
            color: #1E0A3C;
            border-bottom: 2px solid #E2E8F0;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        .description-body {
            font-size: 0.88rem;
            color: #334155;
            line-height: 1.7;
        }

        .author-box {
            background: #F8FAFC;
            border-radius: 12px;
            padding: 20px;
            border: 1px solid #E2E8F0;
            margin-bottom: 25px;
        }

        /* RELATED BOOKS */
        .related-books-section {
            margin-top: 50px;
            position: relative;
        }

        .related-books-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 16px;
        }

        .book-card {
            background: white;
            border: 1px solid #E2E8F0;
            border-radius: 12px;
            padding: 12px;
            transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .book-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
            border-color: #6B21A8;
        }

        .book-cover-box {
            width: 100%;
            aspect-ratio: 1 / 1;
            background: #F1F5F9;
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 10px;
        }

        .book-cover-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .book-card:hover .book-cover-box img {
            transform: scale(1.05);
        }

        .book-title-text {
            font-size: 0.8rem;
            font-weight: 700;
            color: #1E0A3C;
            margin-bottom: 4px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            height: 38px;
        }

        .book-author-text {
            font-size: 0.7rem;
            color: #64748B;
            margin-bottom: 8px;
        }

        .book-price-text {
            font-size: 0.82rem;
            font-weight: 800;
            color: #1E0A3C;
            margin-bottom: 6px;
        }

        .book-cart-btn {
            position: absolute;
            bottom: 12px;
            right: 12px;
            background: #250A4E;
            color: white;
            border: none;
            width: 28px;
            height: 28px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 0.75rem;
        }

        .carousel-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: white;
            border: 1px solid #E2E8F0;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 10;
            color: #1E0A3C;
        }

        .carousel-arrow.left {
            left: -18px;
        }

        .carousel-arrow.right {
            right: -18px;
        }

        /* FEATURES BANNER */
        .features-banner {
            margin-top: 50px;
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 12px;
            padding: 20px;
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 15px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .feature-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            border: 1px solid #E2E8F0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            color: #1E0A3C;
            flex-shrink: 0;
        }

        .feature-title {
            font-size: 0.75rem;
            font-weight: 700;
            color: #1E0A3C;
        }

        .feature-desc {
            font-size: 0.68rem;
            color: #64748B;
        }

        @media (max-width: 992px) {
            .book-detail-grid {
                grid-template-columns: 1fr;
            }

            .middle-section {
                grid-template-columns: 1fr;
            }

            .related-books-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .features-banner {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@section('content')
    <div class="detail-container">

        <!-- BREADCRUMB -->
        <div class="breadcrumb-wrap">
            <a href="{{ route('home') }}">Beranda</a> /
            <a href="{{ route('catalog.index') }}">Katalog Buku</a> /
            <span>{{ $book->title }}</span>
        </div>

        <!-- SECTION TOP: COVER, INFO, ACTION SIDEBAR -->
        <div class="book-detail-grid">

            <!-- KOLOM 1: COVER BUKU -->
            <div class="cover-gallery">
                <div class="main-cover-box">
                    @if ($book->is_featured)
                        <span class="badge-bestseller">Best Seller</span>
                    @endif
                    @php
                        $coverPath = $book->cover ?? ($book->cover_image ?? ($book->image ?? null));
                    @endphp
                    <img src="{{ $coverPath ? asset('storage/' . $coverPath) : 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?q=80&w=600' }}"
                        alt="{{ $book->title }}" onerror="this.src='https://via.placeholder.com/300x400?text=No+Cover'">
                </div>
            </div>

            <!-- KOLOM 2: DETAIL SPESIFIKASI BUKU -->
            <div>
                <div class="category-tag">Kategori: {{ $book->category->name ?? 'Umum' }}</div>
                <h1 class="book-main-title">{{ $book->title }}</h1>

                <div class="author-link">
                    <i class="fa-solid fa-user"></i> {{ $authorName }}
                </div>

                <!-- RATING DAN REVIEWS DINAMIS -->
                <div class="rating-summary-row">
                    <div class="stars">
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="fa-solid fa-star"
                                style="color: {{ $i <= round($avgRating) ? '#FFC000' : '#E2E8F0' }};"></i>
                        @endfor
                    </div>
                    <strong>{{ number_format($avgRating, 1) }}</strong> ({{ $totalReviews }} Ulasan) &nbsp;|&nbsp; <span
                        style="color: #64748B;">{{ $totalSold }} Terjual</span>
                </div>

                <!-- SPESIFIKASI GRID -->
                <div class="specs-grid">
                    <div class="spec-item">
                        <i class="fa-solid fa-barcode"></i>
                        <span>ISBN: <strong>{{ $book->isbn ?? '-' }}</strong></span>
                    </div>

                    <div class="spec-item">
                        <i class="fa-solid fa-building"></i>
                        <span>Penerbit: <strong>{{ $book->publisher->name ?? '-' }}</strong></span>
                    </div>

                    <div class="spec-item">
                        <i class="fa-solid fa-calendar"></i>
                        <span>Tahun: <strong>{{ $book->publication_year ?? '-' }}</strong></span>
                    </div>

                    <div class="spec-item">
                        <i class="fa-solid fa-book-open"></i>
                        <span>Halaman: <strong>{{ $book->pages ? $book->pages . ' hlm' : '-' }}</strong></span>
                    </div>

                    <div class="spec-item">
                        <i class="fa-solid fa-ruler-combined"></i>
                        <span>Ukuran: <strong>{{ $book->dimensions ?? '-' }}</strong></span>
                    </div>

                    <div class="spec-item">
                        <i class="fa-solid fa-language"></i>
                        <span>Bahasa: <strong>{{ $book->language ?? 'Indonesia' }}</strong></span>
                    </div>

                    <div class="spec-item">
                        <i class="fa-solid fa-weight-hanging"></i>
                        <span>Berat: <strong>{{ $book->weight ?? '-' }}</strong></span>
                    </div>

                    <div class="spec-item">
                        <i class="fa-solid fa-scroll"></i>
                        <span>Cover: <strong>{{ $book->cover_type ?? 'Soft Cover' }}</strong></span>
                    </div>
                </div>

                <!-- AKSI SEKUNDER -->
                <div class="action-secondary">
                    <form action="{{ route('wishlist.toggle', $book->id) }}" method="POST" style="flex: 1;">
                        @csrf
                        <button type="submit" class="btn-outline-action {{ $isWishlisted ? 'active-wishlist' : '' }}"
                            style="width: 100%;">
                            <i class="{{ $isWishlisted ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
                            {{ $isWishlisted ? 'Di Wishlist' : 'Tambah Wishlist' }}
                        </button>
                    </form>
                    <button type="button" class="btn-outline-action" onclick="shareBook()"><i
                            class="fa-solid fa-share-nodes"></i>
                        Bagikan</button>
                </div>
            </div>

            <!-- KOLOM 3: CHECKOUT BOX SIDEBAR -->
            <div class="action-sidebar">
                <div class="price-wrap">
                    <span style="font-size: 0.75rem; color: #64748B; display: block;">Harga Buku</span>
                    <span class="main-price" id="display-price">Rp {{ number_format($activePrice, 0, ',', '.') }}</span>

                    @if ($discountPercent > 0)
                        <span class="strike-price" id="display-strike">Rp
                            {{ number_format($strikePrice, 0, ',', '.') }}</span>
                        <span class="badge-discount" id="display-badge">Diskon {{ $discountPercent }}%</span>
                    @else
                        <span class="strike-price" id="display-strike" style="display: none;"></span>
                        <span class="badge-discount" id="display-badge" style="display: none;"></span>
                    @endif
                </div>

                <div class="stock-status">
                    @if ($book->type === 'ebook')
                        <i class="fa-solid fa-circle-check"></i> Tersedia (Format Digital / E-Book)
                    @else
                        <i class="fa-solid fa-circle-check"></i> Tersedia > {{ $book->stock }} buku
                    @endif
                </div>

                <div class="format-selector">
                    @if ($book->type === 'ebook')
                        <span class="format-label">Format Buku</span>
                        <div class="format-option active" style="cursor: default;">
                            <span>Ebook (PDF)</span>
                            <strong>Rp {{ number_format($priceEbook, 0, ',', '.') }}</strong>
                        </div>
                    @else
                        <span class="format-label">Jenis Buku</span>
                        <div class="format-option active" style="cursor: default;">
                            <span>Buku Cetak</span>
                            <strong>Rp {{ number_format($pricePhysical, 0, ',', '.') }}</strong>
                        </div>
                    @endif
                </div>

                @if ($book->stock > 0)
                    <div class="qty-picker">
                        <span class="format-label" style="margin: 0;">Jumlah</span>
                        <div class="qty-btn-wrap">
                            <button type="button" class="qty-btn" onclick="decrementQty()">-</button>
                            <input type="text" id="qty-input" value="1" class="qty-input" readonly>
                            <button type="button" class="qty-btn" onclick="incrementQty()">+</button>
                        </div>
                    </div>

                    <!-- FORM 1: BELI SEKARANG -->
                    <form action="{{ route('checkout.index') }}" method="GET">
                        <input type="hidden" name="book_id" value="{{ $book->id }}">
                        <input type="hidden" name="type" class="selected-type-input"
                            value="{{ $isEbookDefault ? 'ebook' : 'cetak' }}">
                        <input type="hidden" name="quantity" class="selected-qty-input" value="1">

                        <button type="submit" class="btn-buy-now">
                            <i class="fa-solid fa-bolt"></i> Beli Sekarang
                        </button>
                    </form>

                    <!-- FORM 2: TAMBAH KE KERANJANG -->
                    <form id="add-to-cart-form" action="{{ route('cart.add', $book->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="type" class="selected-type-input"
                            value="{{ $isEbookDefault ? 'ebook' : 'cetak' }}">
                        <input type="hidden" name="quantity" class="selected-qty-input" value="1">

                        <button type="submit" class="btn-add-cart">
                            <i class="fa-solid fa-cart-plus"></i> Tambah ke Keranjang
                        </button>
                    </form>
                @else
                    <div class="qty-picker">
                        <span class="format-label" style="margin: 0;">Jumlah</span>
                        <div class="qty-btn-wrap">
                            <button type="button" class="qty-btn" disabled>-</button>
                            <input type="text" value="0" class="qty-input" readonly>
                            <button type="button" class="qty-btn" disabled>+</button>
                        </div>
                    </div>
                    <button class="btn-buy-now" style="background: #E2E8F0; color: #94A3B8; cursor: not-allowed;"
                        disabled>
                        Stok Habis
                    </button>
                @endif

                <div class="guarantee-list">
                    <div><i class="fa-solid fa-shield-check" style="color: #16A34A;"></i> Garansi 100% Original</div>
                    <div><i class="fa-solid fa-truck-fast" style="color: #2563EB;"></i> Pengiriman 1-3 Hari Kerja</div>
                    <div><i class="fa-solid fa-rotate-left" style="color: #D97706;"></i> Bisa Retur 7 Hari</div>
                </div>
            </div>

        </div>

        <!-- SECTION MIDDLE: DESKRIPSI LENGKAP & PROFIL PENULIS -->
        <div class="middle-section">

            <!-- KIRI: DESKRIPSI LENGKAP UTAMA & ULASAN PEMBELI -->
            <div>
                <h3 class="section-header-title">Deskripsi Buku</h3>
                <div class="description-body">
                    {!! nl2br(e($book->description ?? 'Deskripsi lengkap belum ditambahkan.')) !!}
                </div>

                <!-- SECTION ULASAN PEMBELI -->
                <div style="margin-top: 40px;">
                    <h3 class="section-header-title">Ulasan Pembeli ({{ $totalReviews }})</h3>

                    <!-- KONDISI FITUR RATING/ULASAN -->

                    @auth
                        @if ($isAuthorOfBook)
                            <!-- Dibatasi: Penulis tidak bisa memberi ulasan pada karya sendiri -->
                            <div
                                style="background: #F1F5F9; border: 1px solid #CBD5E1; color: #475569; padding: 14px 18px; border-radius: 8px; font-size: 0.85rem; margin-bottom: 25px;">
                                <i class="fa-solid fa-circle-info" style="margin-right: 6px; color: #1E0A3C;"></i>
                                Anda adalah penulis karya ini. Fitur pemberian ulasan dan rating mandiri tidak tersedia.
                            </div>
                        @elseif (!$hasPurchased)
                            <!-- Dibatasi: Pelanggan belum membeli buku -->
                            <div
                                style="background: #EFF6FF; border: 1px solid #BFDBFE; color: #1E40AF; padding: 14px 18px; border-radius: 8px; font-size: 0.85rem; margin-bottom: 25px;">
                                <i class="fa-solid fa-cart-shopping" style="margin-right: 6px;"></i>
                                Hanya pelanggan yang telah membeli buku ini yang dapat memberikan ulasan.
                            </div>
                        @else
                            <!-- Pembeli Login yang Valid & Sudah Membeli Buku -->
                            <div
                                style="background: #F8FAFC; border: 1px solid #E2E8F0; padding: 20px; border-radius: 12px; margin-bottom: 25px;">
                                <h5 style="font-weight: 700; color: #1E0A3C; margin-bottom: 12px;">Beri Ulasan Buku Ini</h5>
                                <form action="{{ route('reviews.store', $book->id) }}" method="POST">
                                    @csrf
                                    <div style="margin-bottom: 12px;">
                                        <label style="font-size: 0.85rem; font-weight: 600; color: #334155;">Rating
                                            Bintang</label>
                                        <select name="rating"
                                            style="width: 100%; padding: 8px; border-radius: 6px; border: 1px solid #CBD5E1; margin-top: 4px;"
                                            required>
                                            <option value="5">⭐⭐⭐⭐⭐ (5 - Sangat Bagus)</option>
                                            <option value="4">⭐⭐⭐⭐ (4 - Bagus)</option>
                                            <option value="3">⭐⭐⭐ (3 - Cukup)</option>
                                            <option value="2">⭐⭐ (2 - Kurang)</option>
                                            <option value="1">⭐ (1 - Buruk)</option>
                                        </select>
                                    </div>
                                    <div style="margin-bottom: 12px;">
                                        <label style="font-size: 0.85rem; font-weight: 600; color: #334155;">Ulasan
                                            Anda</label>
                                        <textarea name="comment" rows="3"
                                            style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #CBD5E1; margin-top: 4px;"
                                            placeholder="Bagikan kesan Anda membaca buku ini..." required></textarea>
                                    </div>
                                    <button type="submit"
                                        style="background: #1E0A3C; color: white; border: none; padding: 8px 18px; border-radius: 6px; font-weight: 600; cursor: pointer;">
                                        Kirim Ulasan
                                    </button>
                                </form>
                            </div>
                        @endif
                    @else
                        <div
                            style="background: #FFFBEB; border: 1px solid #FDE68A; color: #92400E; padding: 12px 16px; border-radius: 8px; font-size: 0.85rem; margin-bottom: 20px;">
                            Silakan <a href="{{ route('login') }}"
                                style="color: #B45309; font-weight: bold; text-decoration: underline;">Login</a> untuk
                            memberikan ulasan.
                        </div>
                    @endauth

                    <!-- Daftar Ulasan Masuk -->
                    @forelse ($book->reviews ?? [] as $review)
                        <div style="border-bottom: 1px solid #E2E8F0; padding-bottom: 15px; margin-bottom: 15px;">
                            <div
                                style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 6px;">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($review->user->name ?? 'User') }}&background=1E0A3C&color=fff"
                                        style="width: 32px; height: 32px; border-radius: 50%;">
                                    <div>
                                        <strong
                                            style="font-size: 0.85rem; color: #1E0A3C; display: block;">{{ $review->user->name ?? 'Pembeli' }}</strong>
                                        <span
                                            style="font-size: 0.7rem; color: #94A3B8;">{{ $review->created_at ? $review->created_at->diffForHumans() : '-' }}</span>
                                    </div>
                                </div>
                                <div class="stars" style="font-size: 0.8rem; color: #FFC000;">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="{{ $i <= $review->rating ? 'fa-solid' : 'fa-regular' }} fa-star"></i>
                                    @endfor
                                </div>
                            </div>
                            <p style="font-size: 0.85rem; color: #475569; margin: 0; line-height: 1.5;">
                                {{ $review->comment }}
                            </p>
                        </div>
                    @empty
                        <p style="font-size: 0.85rem; color: #94A3B8; font-style: italic;">Belum ada ulasan untuk buku ini.
                            Jadilah yang pertama memberikan ulasan!</p>
                    @endforelse
                </div>
            </div>

            <!-- KANAN: PROFIL PENULIS -->
            <div>
                <div class="author-box">
                    <h5 style="font-weight: 800; color: #1E0A3C; margin-bottom: 10px;">Penulis</h5>
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 10px;">
                        @if ($authorPhoto)
                            <img src="{{ asset('storage/' . $authorPhoto) }}"
                                style="width: 45px; height: 45px; border-radius: 50%; object-fit: cover;">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($authorName) }}&background=23085A&color=fff"
                                style="width: 45px; height: 45px; border-radius: 50%;">
                        @endif
                        <div>
                            <strong style="font-size: 0.85rem; display: block;">{{ $authorName }}</strong>
                            <span style="font-size: 0.72rem; color: #64748B;">{{ $authorTitle }}</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- BUKU TERKAIT -->
        @if (isset($relatedBooks) && count($relatedBooks) > 0)
            <div class="related-books-section">
                <h3 style="font-weight: 800; color: #1E0A3C; margin-bottom: 20px;">Buku Terkait</h3>

                <div class="carousel-arrow left"><i class="fa-solid fa-chevron-left"></i></div>
                <div class="carousel-arrow right"><i class="fa-solid fa-chevron-right"></i></div>

                <div class="related-books-grid">
                    @foreach ($relatedBooks as $related)
                        @php
                            $relAuthorName = is_object($related->author)
                                ? $related->author->name ?? 'Penulis'
                                : $related->author ?? 'Penulis';
                            $relCoverPath = $related->cover ?? ($related->cover_image ?? ($related->image ?? null));
                            $relReviews = $related->reviews_count ?? ($related->reviews ? count($related->reviews) : 0);
                            $relAvg = $relReviews > 0 ? round($related->reviews->avg('rating'), 1) : 5.0;
                        @endphp
                        <a href="{{ route('books.show', $related->id) }}" class="book-card"
                            style="text-decoration: none;">
                            <div class="book-cover-box">
                                <img src="{{ $relCoverPath ? asset('storage/' . $relCoverPath) : 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?q=80&w=400' }}"
                                    alt="{{ $related->title }}"
                                    onerror="this.src='https://via.placeholder.com/200x280?text=No+Cover'">
                            </div>
                            <h4 class="book-title-text">{{ $related->title }}</h4>
                            <p class="book-author-text">{{ $relAuthorName }}</p>
                            <div class="book-price-text">Rp {{ number_format($related->price ?? 0, 0, ',', '.') }}</div>
                            <div class="stars" style="font-size: 0.7rem; margin-bottom: 6px; color: #FFC000;">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="fa-solid fa-star"
                                        style="color: {{ $i <= round($relAvg) ? '#FFC000' : '#E2E8F0' }};"></i>
                                @endfor
                                <span style="color: #64748B;">({{ number_format($relAvg, 1) }})</span>
                            </div>
                            <button type="button" class="book-cart-btn"><i
                                    class="fa-solid fa-cart-shopping"></i></button>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- BENEFIT BAR -->
        <div class="features-banner">
            <div class="feature-item">
                <div class="feature-icon"><i class="fa-solid fa-shield-halved"></i></div>
                <div>
                    <div class="feature-title">Buku Original</div>
                    <div class="feature-desc">100% buku original dan berkualitas</div>
                </div>
            </div>

            <div class="feature-item">
                <div class="feature-icon"><i class="fa-solid fa-truck-fast"></i></div>
                <div>
                    <div class="feature-title">Pengiriman Cepat</div>
                    <div class="feature-desc">Dikirim ke seluruh Indonesia</div>
                </div>
            </div>

            <div class="feature-item">
                <div class="feature-icon"><i class="fa-solid fa-lock"></i></div>
                <div>
                    <div class="feature-title">Pembayaran Aman</div>
                    <div class="feature-desc">Transaksi aman dengan berbagai metode</div>
                </div>
            </div>

            <div class="feature-item">
                <div class="feature-icon"><i class="fa-solid fa-headset"></i></div>
                <div>
                    <div class="feature-title">Layanan 24/7</div>
                    <div class="feature-desc">Customer service siap membantu Anda</div>
                </div>
            </div>

            <div class="feature-item">
                <div class="feature-icon"><i class="fa-solid fa-box-archive"></i></div>
                <div>
                    <div class="feature-title">Garansi Buku</div>
                    <div class="feature-desc">Garansi ganti buku jika terjadi kerusakan</div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function selectFormat(type, price, strikePrice = 0) {
            // 1. Update nilai hidden input pada FORM 'Beli Sekarang' dan 'Tambah ke Keranjang'
            document.querySelectorAll('.selected-type-input').forEach(input => {
                input.value = type;
            });

            // 2. Update tampilan harga utama
            document.getElementById('display-price').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(price);

            // 3. Update tampilan harga coret (diskon)
            let strikeEl = document.getElementById('display-strike');
            if (strikeEl) {
                if (strikePrice > 0) {
                    strikeEl.innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(strikePrice);
                    strikeEl.style.display = 'inline';
                } else {
                    strikeEl.style.display = 'none';
                }
            }

            // 4. Switch class 'active' pada tombol pilihan varian
            const optCetak = document.getElementById('opt-cetak');
            const optEbook = document.getElementById('opt-ebook');

            if (optCetak && optEbook) {
                if (type === 'ebook') {
                    optEbook.classList.add('active');
                    optCetak.classList.remove('active');
                } else {
                    optCetak.classList.add('active');
                    optEbook.classList.remove('active');
                }
            }
        }

        function syncQuantity(val) {
            document.querySelectorAll('.selected-qty-input').forEach(input => {
                input.value = val;
            });
        }

        function incrementQty() {
            let input = document.getElementById('qty-input');
            let maxStock = {{ $book->stock ?? 999 }};
            let currentVal = parseInt(input.value);
            if (currentVal < maxStock) {
                let newVal = currentVal + 1;
                input.value = newVal;
                syncQuantity(newVal);
            }
        }

        function decrementQty() {
            let input = document.getElementById('qty-input');
            let currentVal = parseInt(input.value);
            if (currentVal > 1) {
                let newVal = currentVal - 1;
                input.value = newVal;
                syncQuantity(newVal);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            // 1. HANDLE FORM TAMBAH KE KERANJANG VIA AJAX
            const cartForm = document.getElementById('add-to-cart-form');
            if (cartForm) {
                cartForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(this);
                    const actionUrl = this.action;

                    fetch(actionUrl, {
                            method: 'POST',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                            },
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            Toast.fire({
                                icon: 'success',
                                title: data.message ||
                                    'Buku berhasil ditambahkan ke keranjang!',
                                timer: 3000
                            });
                        })
                        .catch(error => {
                            Toast.fire({
                                icon: 'success',
                                title: 'Buku berhasil ditambahkan ke keranjang!',
                                timer: 3000
                            });
                        });
                });
            }

            // 2. FLASH MESSAGES DARI SESSION LARAVEL
            @if (session('success'))
                Toast.fire({
                    icon: 'success',
                    title: '{{ session('success') }}'
                });
            @endif

            @if (session('error'))
                Toast.fire({
                    icon: 'error',
                    title: '{{ session('error') }}'
                });
            @endif
        });

        function shareBook() {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true
            });

            if (navigator.share) {
                navigator.share({
                    title: '{{ $book->title }}',
                    url: window.location.href
                }).catch(console.error);
            } else {
                navigator.clipboard.writeText(window.location.href);
                Toast.fire({
                    icon: 'success',
                    title: 'Tautan buku berhasil disalin!'
                });
            }
        }
    </script>
@endpush
