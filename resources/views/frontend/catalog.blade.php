@extends('layouts.app')

@section('title', 'Katalog Buku - IGAKERTA Book Store')

@push('styles')
    <!-- CDN SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        /* BANNER HEADER DESIGN (HERO STYLE BERANDA) */
        .catalog-header {
            background: linear-gradient(90deg, #18003C 0%, #290858 55%, rgba(41, 8, 88, 0.45) 100%),
                url('https://images.unsplash.com/photo-1521587760476-6c12a4b040da?q=80&w=1200&auto=format&fit=crop') center / cover no-repeat;
            border-radius: 16px;
            color: white;
            padding: 35px 50px;
            margin: 20px 6% 30px 6%;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            box-sizing: border-box;
        }

        .catalog-header-content {
            max-width: 550px;
            position: relative;
            z-index: 2;
        }

        .breadcrumb-item {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 8px;
        }

        .breadcrumb-item a {
            color: #FFC000;
            text-decoration: none;
            font-weight: 600;
        }

        .catalog-header h1 {
            font-size: 1.85rem;
            font-weight: 800;
            margin-bottom: 8px;
            color: #FFFFFF;
            letter-spacing: -0.5px;
        }

        .catalog-header p {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.85);
            line-height: 1.5;
            margin: 0;
        }

        /* MAIN CONTAINER & GRID */
        .catalog-container {
            width: 100%;
            max-width: 100%;
            display: grid;
            grid-template-columns: 260px 1fr;
            gap: 30px;
            padding: 0 6% 30px;
            box-sizing: border-box;
        }

        /* SIDEBAR FILTER STYLING */
        .filter-card {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .filter-section-title {
            font-weight: 700;
            font-size: 0.95rem;
            color: #1E293B;
            margin-bottom: 16px;
        }

        .filter-group {
            margin-bottom: 22px;
        }

        .filter-group label {
            display: block;
            font-size: 0.82rem;
            font-weight: 700;
            color: #1E293B;
            margin-bottom: 8px;
        }

        .search-filter-box {
            position: relative;
        }

        .search-filter-box input {
            width: 100%;
            padding: 9px 35px 9px 12px;
            border: 1px solid #CBD5E1;
            border-radius: 8px;
            font-size: 0.8rem;
            outline: none;
            background: #F8FAFC;
        }

        .search-filter-box i {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #94A3B8;
            font-size: 0.85rem;
        }

        .cat-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .cat-list li {
            margin-bottom: 4px;
        }

        .cat-list a {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 6px 10px;
            border-radius: 6px;
            font-size: 0.82rem;
            color: #475569;
            text-decoration: none;
            transition: all 0.2s;
        }

        .cat-list a.active {
            background: #EDE9FE;
            color: #23085A;
            font-weight: 700;
        }

        .cat-count {
            font-size: 0.72rem;
            opacity: 0.7;
        }

        .select-input {
            width: 100%;
            padding: 9px 12px;
            border: 1px solid #CBD5E1;
            border-radius: 8px;
            font-size: 0.8rem;
            outline: none;
            color: #475569;
            background: #FFFFFF;
            cursor: pointer;
        }

        .radio-checkbox-list {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.8rem;
            color: #475569;
            cursor: pointer;
        }

        .checkbox-label input[type="radio"] {
            accent-color: #23085A;
            width: 15px;
            height: 15px;
        }

        .price-range-inputs {
            display: flex;
            gap: 8px;
            align-items: center;
            margin-top: 10px;
        }

        .price-range-inputs input {
            width: 100%;
            padding: 8px;
            border: 1px solid #CBD5E1;
            border-radius: 6px;
            font-size: 0.78rem;
            outline: none;
        }

        .year-selects {
            display: flex;
            gap: 8px;
        }

        .btn-submit-filter {
            width: 100%;
            background: #23085A;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.85rem;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-submit-filter:hover {
            background: #4A1996;
        }

        .btn-reset-filter {
            display: block;
            text-align: center;
            font-size: 0.78rem;
            color: #64748B;
            text-decoration: none;
            margin-top: 10px;
        }

        /* HELP BOX */
        .help-box {
            background: #F5EFFF;
            border: 1px solid #E9D5FF;
            border-radius: 12px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .help-icon {
            width: 40px;
            height: 40px;
            background: #FFFFFF;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #23085A;
            font-size: 1.1rem;
            margin-bottom: 12px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .btn-contact-help {
            background: #FFC000;
            color: #23085A;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 700;
            font-size: 0.78rem;
            text-decoration: none;
            margin-top: 12px;
            display: inline-block;
        }

        /* TOPBAR SORTING & VIEWS */
        .catalog-topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .view-modes {
            display: flex;
            gap: 6px;
            align-items: center;
        }

        .btn-view-mode {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            border: 1px solid #E2E8F0;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748B;
            cursor: pointer;
        }

        .btn-view-mode.active {
            background: #23085A;
            color: white;
            border-color: #23085A;
        }

        /* BOOK CARD DESIGN & RENDER SAMPUL */
        .books-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .book-card {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 12px;
            padding: 14px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .book-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.06);
        }

        .book-thumb-box {
            position: relative;
            width: 100%;
            height: 200px;
            background: #F8FAFC;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            margin-bottom: 12px;
        }

        .book-thumb-box img {
            max-height: 90%;
            max-width: 90%;
            object-fit: contain;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .book-card:hover .book-thumb-box img {
            transform: scale(1.04);
        }

        .badge-card {
            position: absolute;
            top: 8px;
            left: 8px;
            font-size: 0.6rem;
            font-weight: 800;
            padding: 3px 7px;
            border-radius: 4px;
            color: white;
            text-transform: uppercase;
            z-index: 5;
        }

        .badge-baru {
            background: #10B981;
        }

        .badge-bestseller {
            background: #F59E0B;
        }

        .badge-diskon {
            background: #EF4444;
        }

        .btn-wishlist {
            position: absolute;
            top: 8px;
            right: 8px;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.9);
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748B;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            z-index: 10;
            transition: all 0.2s ease;
        }

        .btn-wishlist:hover,
        .btn-wishlist.active-wishlist {
            color: #EF4444;
        }

        .card-book-title {
            font-size: 0.85rem;
            font-weight: 700;
            color: #1E293B;
            line-height: 1.3;
            margin-bottom: 4px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            height: 2.3em;
        }

        .card-book-title a {
            color: #1E293B;
            text-decoration: none;
        }

        .card-book-author {
            font-size: 0.72rem;
            color: #64748B;
            margin-bottom: 8px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .card-price-row {
            margin-bottom: 6px;
        }

        .card-price-main {
            font-size: 0.95rem;
            font-weight: 800;
            color: #1E293B;
        }

        .card-price-old {
            font-size: 0.72rem;
            color: #94A3B8;
            text-decoration: line-through;
            margin-left: 4px;
        }

        .card-rating-row {
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 0.7rem;
            color: #F59E0B;
            margin-bottom: 10px;
        }

        .rating-count {
            color: #94A3B8;
            font-size: 0.68rem;
        }

        .card-action-bottom {
            display: flex;
            justify-content: flex-end;
        }

        .btn-cart-purple {
            background: #23085A;
            color: white;
            border: none;
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-cart-purple:hover {
            background: #4A1996;
        }

        /* PAGINATION */
        .pagination-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 40px;
        }

        /* FEATURES FOOTER BANNER DESIGN */
        .features-banner {
            margin: 20px 6% 50px 6%;
            background: #F8FAFC;
            border: 1px solid #F1F5F9;
            border-radius: 14px;
            padding: 24px 30px;
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 20px;
            align-items: center;
            box-sizing: border-box;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 14px;
            position: relative;
        }

        .feature-item:not(:last-child)::after {
            content: '';
            position: absolute;
            right: -10px;
            top: 15%;
            height: 70%;
            width: 1px;
            background-color: #E2E8F0;
        }

        .feature-icon-wrapper {
            width: 42px;
            height: 42px;
            min-width: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #23085A;
            font-size: 1.5rem;
        }

        .feature-info h4 {
            font-size: 0.85rem;
            font-weight: 700;
            color: #1E293B;
            margin: 0 0 3px 0;
            line-height: 1.2;
        }

        .feature-info p {
            font-size: 0.72rem;
            color: #64748B;
            margin: 0;
            line-height: 1.35;
        }

        /* Custom Modal SweetAlert2 Styling */
        .swal2-login-popup {
            border-radius: 16px !important;
            padding: 28px !important;
        }

        .swal2-login-title {
            color: #1E293B !important;
            font-weight: 700 !important;
            font-size: 1.5rem !important;
        }

        .swal2-login-html {
            color: #64748B !important;
            font-size: 0.9rem !important;
        }

        .swal2-login-confirm-btn {
            background-color: #1d0746 !important;
            color: white !important;
            border-radius: 8px !important;
            padding: 10px 22px !important;
            font-weight: 600 !important;
            font-size: 0.9rem !important;
            box-shadow: none !important;
        }

        .swal2-login-cancel-btn {
            background-color: #5c6a7c !important;
            color: white !important;
            border-radius: 8px !important;
            padding: 10px 22px !important;
            font-weight: 600 !important;
            font-size: 0.9rem !important;
            box-shadow: none !important;
        }

        @media (max-width: 1100px) {
            .books-grid {
                grid-template-columns: repeat(3, 1fr);
            }

            .features-banner {
                grid-template-columns: repeat(3, 1fr);
                gap: 25px;
            }

            .feature-item:not(:last-child)::after {
                display: none;
            }
        }

        @media (max-width: 868px) {
            .catalog-header {
                padding: 25px 20px;
            }

            .catalog-container {
                grid-template-columns: 1fr;
            }

            .books-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .features-banner {
                grid-template-columns: 1fr;
                gap: 20px;
            }
        }
    </style>
@endpush

@section('content')
    <!-- BANNER HEADER -->
    <div class="catalog-header">
        <div class="catalog-header-content">
            <div class="breadcrumb-item">
                <a href="{{ route('home') }}">Beranda</a> &gt; <span>Katalog Buku</span>
            </div>
            <h1>Katalog Buku</h1>
            <p>Temukan ribuan buku berkualitas untuk pengembangan diri, akademik, dan penelitian.</p>
        </div>
    </div>

    <!-- MAIN CATALOG CONTENT -->
    <div class="catalog-container">
        <!-- SIDEBAR FILTER -->
        <aside>
            <form action="{{ route('catalog.index') }}" method="GET" id="filterForm">
                <div class="filter-card">
                    <h3 class="filter-section-title">Filter Pencarian</h3>

                    <!-- Cari Kata Kunci -->
                    <div class="filter-group">
                        <label>Cari Kata Kunci</label>
                        <div class="search-filter-box">
                            <input type="text" name="search" placeholder="Cari judul, ISBN..."
                                value="{{ request('search') }}">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </div>
                    </div>

                    <!-- Kategori -->
                    <div class="filter-group">
                        <label>Kategori</label>
                        <ul class="cat-list">
                            <li>
                                <a href="{{ route('catalog.index', array_merge(request()->query(), ['category' => ''])) }}"
                                    class="{{ !request('category') ? 'active' : '' }}">
                                    <span>Semua Kategori</span>
                                    <span class="cat-count">{{ $categories->sum('books_count') }}</span>
                                </a>
                            </li>
                            @foreach ($categories as $cat)
                                <li>
                                    <a href="{{ route('catalog.index', array_merge(request()->query(), ['category' => $cat->slug])) }}"
                                        class="{{ request('category') == $cat->slug ? 'active' : '' }}">
                                        <span>{{ $cat->name }}</span>
                                        <span class="cat-count">{{ $cat->books_count }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Penulis -->
                    <div class="filter-group">
                        <label>Penulis</label>
                        <select name="author" class="select-input"
                            onchange="document.getElementById('filterForm').submit();">
                            <option value="">Semua Penulis</option>
                            @if (isset($authors))
                                @foreach ($authors as $authorName)
                                    <option value="{{ $authorName }}"
                                        {{ request('author') == $authorName ? 'selected' : '' }}>
                                        {{ $authorName }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <!-- Harga -->
                    <div class="filter-group">
                        <label>Harga</label>
                        <div class="radio-checkbox-list">
                            <label class="checkbox-label">
                                <input type="radio" name="price_preset" value="all"
                                    {{ !request('min_price') && !request('max_price') ? 'checked' : '' }}>
                                Semua Harga
                            </label>
                            <label class="checkbox-label">
                                <input type="radio" name="price_preset" value="0-50000"
                                    {{ request('min_price') == 0 && request('max_price') == 50000 ? 'checked' : '' }}>
                                Di bawah Rp50.000
                            </label>
                            <label class="checkbox-label">
                                <input type="radio" name="price_preset" value="50000-100000"
                                    {{ request('min_price') == 50000 && request('max_price') == 100000 ? 'checked' : '' }}>
                                Rp50.000 - Rp100.000
                            </label>
                            <label class="checkbox-label">
                                <input type="radio" name="price_preset" value="100000-200000"
                                    {{ request('min_price') == 100000 && request('max_price') == 200000 ? 'checked' : '' }}>
                                Rp100.000 - Rp200.000
                            </label>
                            <label class="checkbox-label">
                                <input type="radio" name="price_preset" value="200000-up"
                                    {{ request('min_price') == 200000 && !request('max_price') ? 'checked' : '' }}>
                                Di atas Rp200.000
                            </label>
                        </div>

                        <div class="price-range-inputs">
                            <input type="number" name="min_price" id="min_price" placeholder="Rp Minimum"
                                value="{{ request('min_price') }}">
                            <input type="number" name="max_price" id="max_price" placeholder="Rp Maksimum"
                                value="{{ request('max_price') }}">
                        </div>
                    </div>

                    <!-- Tahun Terbit -->
                    <div class="filter-group">
                        <label>Tahun Terbit</label>
                        <div class="year-selects">
                            <select name="year_from" class="select-input">
                                <option value="">Dari Tahun</option>
                                @for ($y = date('Y'); $y >= 2010; $y--)
                                    <option value="{{ $y }}"
                                        {{ request('year_from') == $y ? 'selected' : '' }}>{{ $y }}</option>
                                @endfor
                            </select>
                            <select name="year_to" class="select-input">
                                <option value="">Sampai Tahun</option>
                                @for ($y = date('Y'); $y >= 2010; $y--)
                                    <option value="{{ $y }}" {{ request('year_to') == $y ? 'selected' : '' }}>
                                        {{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <!-- ISBN -->
                    <div class="filter-group">
                        <label>ISBN</label>
                        <input type="text" name="isbn" class="select-input" placeholder="Masukkan ISBN"
                            value="{{ request('isbn') }}">
                    </div>

                    <button type="submit" class="btn-submit-filter">Terapkan Filter</button>
                    <a href="{{ route('catalog.index') }}" class="btn-reset-filter"><i
                            class="fa-solid fa-rotate-right"></i> Reset Filter</a>
                </div>
            </form>

            <!-- HELP BOX -->
            <div class="help-box">
                <div class="help-icon"><i class="fa-solid fa-headset"></i></div>
                <h4 style="font-size: 0.88rem; font-weight: 700; color: #1E293B; margin-bottom: 4px;">Butuh Bantuan?</h4>
                <p style="font-size: 0.75rem; color: #64748B;">Hubungi kami jika Anda membutuhkan bantuan untuk menemukan
                    buku.</p>

                <a href="https://wa.me/6285124157382?text=Halo%20Admin%20IGAKERTA,%20saya%20butuh%20bantuan%20untuk%20mencari%20buku."
                    target="_blank" class="btn-contact-help">
                    <i class="fa-brands fa-whatsapp me-1"></i> Hubungi Kami
                </a>
            </div>
        </aside>

        <!-- CATALOG MAIN AREA -->
        <div>
            <!-- TOPBAR SORTING -->
            <div class="catalog-topbar">
                <div style="font-size: 0.85rem; color: #475569;">
                    Menampilkan <strong>{{ $books->firstItem() ?? 0 }}–{{ $books->lastItem() ?? 0 }}</strong> dari
                    <strong>{{ $books->total() }}</strong> buku
                </div>

                <div style="display: flex; gap: 15px; align-items: center;">
                    <form action="{{ route('catalog.index') }}" method="GET" id="sortForm">
                        @if (request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif
                        @if (request('author'))
                            <input type="hidden" name="author" value="{{ request('author') }}">
                        @endif
                        @if (request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif

                        <div style="display: flex; align-items: center; gap: 8px;">
                            <span style="font-size: 0.82rem; color: #64748B;">Urutkan:</span>
                            <select name="sort" class="select-input" style="width: auto; padding-right: 25px;"
                                onchange="document.getElementById('sortForm').submit();">
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru
                                </option>
                                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga
                                    Rendah - Tinggi</option>
                                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga
                                    Tinggi - Rendah</option>
                            </select>
                        </div>
                    </form>

                    <div class="view-modes">
                        <button class="btn-view-mode active"><i class="fa-solid fa-border-all"></i></button>
                        <button class="btn-view-mode"><i class="fa-solid fa-list"></i></button>
                    </div>
                </div>
            </div>

            <!-- BOOKS GRID / EMPTY STATE -->
            @if ($books->count() > 0)
                <div class="books-grid">
                    @foreach ($books as $index => $book)
                        <div class="book-card">
                            <div>
                                <!-- Tautan Sampul Gambar -->
                                <a href="{{ route('books.show', $book->id) }}"
                                    style="text-decoration: none; display: block;">
                                    <div class="book-thumb-box">
                                        @if ($book->discount_price && $book->discount_price < $book->price)
                                            @php
                                                $percent = round(
                                                    (($book->price - $book->discount_price) / $book->price) * 100,
                                                );
                                            @endphp
                                            <span class="badge-card badge-diskon">DISKON {{ $percent }}%</span>
                                        @elseif($book->is_featured)
                                            <span class="badge-card badge-bestseller">BEST SELLER</span>
                                        @endif

                                        @if ($book->cover_image)
                                            <img src="{{ asset('storage/' . $book->cover_image) }}"
                                                alt="{{ $book->title }}">
                                        @else
                                            <div
                                                style="display: flex; flex-direction: column; align-items: center; color: #94A3B8;">
                                                <i class="fa-solid {{ isset($book->type) && $book->type == 'ebook' ? 'fa-file-pdf' : 'fa-book-open' }}"
                                                    style="font-size: 2.5rem; margin-bottom: 6px;"></i>
                                                <span style="font-size: 0.75rem; font-weight: 600;">No Cover</span>
                                            </div>
                                        @endif
                                    </div>
                                </a>

                                <!-- FORM WISH-LIST (TOMBOL LOVE) -->
                                <form action="{{ route('wishlist.toggle', $book->id) }}" method="POST"
                                    style="position: absolute; top: 8px; right: 8px; z-index: 10;"
                                    @guest onsubmit="event.preventDefault(); showLoginModal();" @endguest>
                                    @csrf
                                    @php
                                        $isWishlisted = session()->has('wishlist.' . $book->id);
                                    @endphp
                                    <button class="btn-wishlist {{ $isWishlisted ? 'active-wishlist' : '' }}"
                                        type="submit"
                                        title="{{ $isWishlisted ? 'Hapus dari Wishlist' : 'Tambah ke Wishlist' }}">
                                        <i class="{{ $isWishlisted ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
                                    </button>
                                </form>

                                <!-- Tautan Pada Judul -->
                                <h3 class="card-book-title" title="{{ $book->title }}">
                                    <a href="{{ route('books.show', $book->id) }}">{{ $book->title }}</a>
                                </h3>
                                <div class="card-book-author">
                                    {{ is_object($book->author) ? $book->author->name : $book->author ?? '-' }}
                                </div>
                            </div>

                            <div>
                                <div class="card-price-row">
                                    @if ($book->discount_price && $book->discount_price < $book->price)
                                        <span class="card-price-main">Rp
                                            {{ number_format($book->discount_price, 0, ',', '.') }}</span>
                                        <span class="card-price-old">Rp
                                            {{ number_format($book->price, 0, ',', '.') }}</span>
                                    @else
                                        <span class="card-price-main">Rp
                                            {{ number_format($book->price, 0, ',', '.') }}</span>
                                    @endif
                                </div>

                                <div class="card-rating-row">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <span class="rating-count">({{ rand(15, 50) }})</span>
                                </div>

                                <div class="card-action-bottom">
                                    <form action="{{ route('cart.add', $book->id) }}" method="POST"
                                        style="position: relative; z-index: 10;">
                                        @csrf
                                        <input type="hidden" name="type" value="cetak">
                                        <button type="submit" class="btn-cart-purple" title="Tambah ke Keranjang">
                                            <i class="fa-solid fa-cart-shopping"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- PAGINATION -->
                <div class="pagination-wrapper">
                    {{ $books->links() }}
                </div>
            @else
                <div
                    style="text-align: center; padding: 60px 20px; background: white; border-radius: 12px; border: 1px solid #E2E8F0;">
                    <i class="fa-solid fa-book-open" style="font-size: 3rem; color: #CBD5E1; margin-bottom: 15px;"></i>
                    <h3 style="font-size: 1.1rem; color: #1E293B; margin-bottom: 6px;">Buku Tidak Ditemukan</h3>
                    <p style="font-size: 0.82rem; color: #64748B;">
                        @if (request('author'))
                            Tidak ada karya buku terdaftar untuk penulis <strong>"{{ request('author') }}"</strong>.
                        @else
                            Coba kata kunci lain atau gunakan reset filter.
                        @endif
                    </p>
                </div>
            @endif
        </div>
    </div>

    <!-- FEATURES FOOTER BANNER -->
    <div class="features-banner">
        <div class="feature-item">
            <div class="feature-icon-wrapper">
                <i class="fa-solid fa-shield-halved"></i>
            </div>
            <div class="feature-info">
                <h4>Buku Original</h4>
                <p>100% buku original dan berkualitas</p>
            </div>
        </div>

        <div class="feature-item">
            <div class="feature-icon-wrapper">
                <i class="fa-solid fa-truck-fast"></i>
            </div>
            <div class="feature-info">
                <h4>Pengiriman Cepat</h4>
                <p>Dikirim ke seluruh Indonesia</p>
            </div>
        </div>

        <div class="feature-item">
            <div class="feature-icon-wrapper">
                <i class="fa-solid fa-lock"></i>
            </div>
            <div class="feature-info">
                <h4>Pembayaran Aman</h4>
                <p>Transaksi aman dengan berbagai metode</p>
            </div>
        </div>

        <div class="feature-item">
            <div class="feature-icon-wrapper">
                <i class="fa-solid fa-headset"></i>
            </div>
            <div class="feature-info">
                <h4>Layanan 24/7</h4>
                <p>Customer service siap membantu Anda</p>
            </div>
        </div>

        <div class="feature-item">
            <div class="feature-icon-wrapper">
                <i class="fa-solid fa-rotate-left"></i>
            </div>
            <div class="feature-info">
                <h4>Garansi Buku</h4>
                <p>Garansi ganti buku jika terjadi kerusakan</p>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- CDN SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Fungsi untuk menampilkan Pop-up Modal Login
        function showLoginModal() {
            Swal.fire({
                title: 'Login Diperlukan',
                text: 'Silakan login terlebih dahulu untuk menyimpan buku ke wishlist favorit Anda.',
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Login Sekarang',
                cancelButtonText: 'Nanti Saja',
                buttonsStyling: false,
                customClass: {
                    popup: 'swal2-login-popup',
                    title: 'swal2-login-title',
                    htmlContainer: 'swal2-login-html',
                    confirmButton: 'swal2-login-confirm-btn',
                    cancelButton: 'swal2-login-cancel-btn'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('login') }}";
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Setup Toast Mixin SweetAlert2 (Opsi 3)
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

            // Tampilkan Toast jika ada session notification (Wishlist / Cart)
            @if (session('success'))
                Toast.fire({
                    icon: 'success',
                    title: "{!! session('success') !!}"
                });
            @endif

            @if (session('info'))
                Toast.fire({
                    icon: 'info',
                    title: "{!! session('info') !!}"
                });
            @endif

            @if (session('error'))
                Toast.fire({
                    icon: 'error',
                    title: "{!! session('error') !!}"
                });
            @endif

            // Logika Filter Harga Preset
            const radioPresets = document.querySelectorAll('input[name="price_preset"]');
            const minPriceInput = document.getElementById('min_price');
            const maxPriceInput = document.getElementById('max_price');

            radioPresets.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.checked) {
                        const val = this.value;
                        if (val === 'all') {
                            minPriceInput.value = '';
                            maxPriceInput.value = '';
                        } else if (val === '0-50000') {
                            minPriceInput.value = 0;
                            maxPriceInput.value = 50000;
                        } else if (val === '50000-100000') {
                            minPriceInput.value = 50000;
                            maxPriceInput.value = 100000;
                        } else if (val === '100000-200000') {
                            minPriceInput.value = 100000;
                            maxPriceInput.value = 200000;
                        } else if (val === '200000-up') {
                            minPriceInput.value = 200000;
                            maxPriceInput.value = '';
                        }
                    }
                });
            });

            [minPriceInput, maxPriceInput].forEach(input => {
                input.addEventListener('input', function() {
                    radioPresets.forEach(radio => {
                        if (radio.value !== 'all') {
                            radio.checked = false;
                        }
                    });
                });
            });
        });
    </script>
@endpush
