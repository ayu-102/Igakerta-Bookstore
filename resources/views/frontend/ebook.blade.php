@extends('layouts.app')

@section('title', 'Katalog Ebook - IGAKERTA Book Store')

@push('styles')
    <!-- CDN SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        /* BANNER HEADER DESIGN (HERO BACKGROUND STYLE) */
        .catalog-header {
            background: linear-gradient(90deg, #18003C 0%, #290858 55%, rgba(41, 8, 88, 0.45) 100%),
                url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?q=80&w=1200&auto=format&fit=crop') center / cover no-repeat;
            border-radius: 16px;
            color: white;
            padding: 35px 45px;
            margin: 1% 6% 30px 6%;
            width: auto;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            min-height: 160px;
            box-sizing: border-box;
        }

        .catalog-header-content {
            max-width: 600px;
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

        .catalog-header-img-wrapper {
            position: relative;
            z-index: 2;
            height: 120px;
            width: 180px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            overflow: hidden;
        }

        .catalog-header-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.3);
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

        /* BOOK CARD DESIGN */
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

        .pagination-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 40px;
        }

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

            .catalog-header-img-wrapper {
                display: none;
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
                <a href="{{ route('home') }}">Beranda</a> &gt; <span>Katalog Ebook</span>
            </div>
            <h1>Katalog Ebook Digital</h1>
            <p>Akses cepat ribuan buku digital berkualitas untuk akademik, penelitian, dan pengembangan diri dalam format
                PDF & EPUB.</p>
        </div>
    </div>

    <!-- MAIN CATALOG CONTENT -->
    <div class="catalog-container">
        <!-- SIDEBAR FILTER -->
        <aside>
            <form action="{{ route('ebook.index') }}" method="GET" id="filterForm">
                @if (request('sort'))
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                @endif

                <div class="filter-card">
                    <h3 class="filter-section-title">Filter Pencarian Ebook</h3>

                    <!-- Cari Kata Kunci -->
                    <div class="filter-group">
                        <label>Cari Ebook</label>
                        <div class="search-filter-box">
                            <input type="text" name="search" placeholder="Cari judul ebook, penulis..."
                                value="{{ request('search') }}">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </div>
                    </div>

                    <!-- Kategori -->
                    <div class="filter-group">
                        <label>Kategori</label>
                        <ul class="cat-list">
                            <li>
                                <a href="{{ route('ebook.index', array_merge(request()->except('category', 'page'))) }}"
                                    class="{{ !request('category') ? 'active' : '' }}">
                                    <span>Semua Kategori</span>
                                    <span class="cat-count">{{ $categories->sum('books_count') }}</span>
                                </a>
                            </li>
                            @foreach ($categories as $cat)
                                <li>
                                    <a href="{{ route('ebook.index', array_merge(request()->except('page'), ['category' => $cat->slug])) }}"
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
                        <select name="author" class="select-input">
                            <option value="">Semua Penulis</option>
                            @if (isset($authors))
                                @foreach ($authors as $author)
                                    <option value="{{ $author }}"
                                        {{ request('author') == $author ? 'selected' : '' }}>
                                        {{ $author }}
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
                        <label>e-ISBN / ISBN</label>
                        <input type="text" name="isbn" class="select-input" placeholder="Masukkan ISBN"
                            value="{{ request('isbn') }}">
                    </div>

                    <button type="submit" class="btn-submit-filter">Terapkan Filter</button>
                    <a href="{{ route('ebook.index') }}" class="btn-reset-filter"><i class="fa-solid fa-rotate-right"></i>
                        Reset Filter</a>
                </div>
            </form>

            <!-- HELP BOX -->
            <div class="help-box">
                <div class="help-icon"><i class="fa-solid fa-file-pdf"></i></div>
                <h4 style="font-size: 0.88rem; font-weight: 700; color: #1E293B; margin-bottom: 4px;">Bantuan Akses Ebook?
                </h4>
                <p style="font-size: 0.75rem; color: #64748B;">Hubungi tim kami jika Anda mengalami masalah saat mengunduh
                    atau membaca file ebook.</p>

                <a href="https://wa.me/6285124157382?text=Halo%20Admin%20IGAKERTA,%20saya%20mengalami%20kendala%20saat%20mengakses/membaca%20file%20ebook."
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
                    <strong>{{ $books->total() }}</strong> ebook
                </div>

                <div style="display: flex; gap: 15px; align-items: center;">
                    <form action="{{ route('ebook.index') }}" method="GET" id="sortForm">
                        @foreach (request()->except('sort', 'page') as $key => $val)
                            @if (is_array($val))
                                @foreach ($val as $item)
                                    <input type="hidden" name="{{ $key }}[]" value="{{ $item }}">
                                @endforeach
                            @else
                                <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                            @endif
                        @endforeach

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
                                <!-- LINK DETAIL DENGAN QUERY TYPE EBOOK -->
                                <a href="{{ route('books.show', ['id' => $book->id, 'type' => 'ebook']) }}"
                                    style="text-decoration: none; display: block;">
                                    <div class="book-thumb-box">
                                        @if ($index % 3 == 0)
                                            <span class="badge-card badge-baru">BARU</span>
                                        @elseif($index % 3 == 1)
                                            <span class="badge-card badge-bestseller">BEST SELLER</span>
                                        @else
                                            <span class="badge-card badge-diskon">DISKON 15%</span>
                                        @endif

                                        <img src="{{ $book->cover_image ? asset('storage/' . $book->cover_image) : 'https://via.placeholder.com/150x200?text=No+Cover' }}"
                                            alt="{{ $book->title }}">
                                    </div>
                                </a>

                                <form action="{{ route('wishlist.toggle', $book->id) }}" method="POST"
                                    class="form-wishlist" style="position: absolute; top: 8px; right: 8px; z-index: 10;">
                                    @csrf
                                    @php $isWishlisted = session()->has('wishlist.' . $book->id); @endphp
                                    <button class="btn-wishlist {{ $isWishlisted ? 'active-wishlist' : '' }}"
                                        type="submit"
                                        title="{{ $isWishlisted ? 'Hapus dari Wishlist' : 'Tambah ke Wishlist' }}">
                                        <i class="{{ $isWishlisted ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
                                    </button>
                                </form>

                                <h3 class="card-book-title" title="{{ $book->title }}">
                                    <a
                                        href="{{ route('books.show', ['id' => $book->id, 'type' => 'ebook']) }}">{{ $book->title }}</a>
                                </h3>
                                <div class="card-book-author">
                                    {{ is_object($book->author) ? $book->author->name : $book->author ?? '-' }}
                                </div>
                            </div>

                            <div>
                                <div class="card-price-row">
                                    <span class="card-price-main">Rp
                                        {{ number_format($book->price, 0, ',', '.') }}</span>
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
                                    <form action="{{ route('cart.add', $book->id) }}" method="POST" class="form-cart"
                                        style="position: relative; z-index: 10;">
                                        @csrf
                                        <input type="hidden" name="type" value="ebook">
                                        <button type="submit" class="btn-cart-purple" title="Beli & Unduh Ebook">
                                            <i class="fa-solid fa-cart-shopping"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="pagination-wrapper">
                    {{ $books->links() }}
                </div>
            @else
                <div
                    style="text-align: center; padding: 60px 20px; background: white; border-radius: 12px; border: 1px solid #E2E8F0;">
                    <i class="fa-solid fa-file-pdf" style="font-size: 3rem; color: #CBD5E1; margin-bottom: 15px;"></i>
                    <h3 style="font-size: 1.1rem; color: #1E293B; margin-bottom: 6px;">Ebook Tidak Ditemukan</h3>
                    <p style="font-size: 0.82rem; color: #64748B;">Coba kata kunci lain atau reset filter pencarian Anda.
                    </p>
                </div>
            @endif
        </div>
    </div>

    <!-- FEATURES FOOTER BANNER -->
    <div class="features-banner">
        <div class="feature-item">
            <div class="feature-icon-wrapper"><i class="fa-solid fa-file-pdf"></i></div>
            <div class="feature-info">
                <h4>Format Standar</h4>
                <p>Format PDF & EPUB berkualitas tinggi</p>
            </div>
        </div>
        <div class="feature-item">
            <div class="feature-icon-wrapper"><i class="fa-solid fa-bolt"></i></div>
            <div class="feature-info">
                <h4>Akses Instan</h4>
                <p>Langsung unduh setelah pembayaran konfirmasi</p>
            </div>
        </div>
        <div class="feature-item">
            <div class="feature-icon-wrapper"><i class="fa-solid fa-lock"></i></div>
            <div class="feature-info">
                <h4>Pembayaran Aman</h4>
                <p>Transaksi aman dengan berbagai metode</p>
            </div>
        </div>
        <div class="feature-item">
            <div class="feature-icon-wrapper"><i class="fa-solid fa-cloud-arrow-down"></i></div>
            <div class="feature-info">
                <h4>Bisa Diunduh Kembali</h4>
                <p>Akses berkas ebook kapan saja di akun Anda</p>
            </div>
        </div>
        <div class="feature-item">
            <div class="feature-icon-wrapper"><i class="fa-solid fa-headset"></i></div>
            <div class="feature-info">
                <h4>Bantuan Bantuan</h4>
                <p>Customer service siap membantu kendala unduhan</p>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- CDN SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const isUserLoggedIn = @json(auth()->check());
            const loginUrl = "{{ route('login') }}";

            // Setup Toast Mixin SweetAlert2 (Sejenis dengan katalog.blade.php)
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

            // Tampilkan Toast dari Session Flash jika backend mengirimkan salam/notifikasi
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

            // Intersept Form Wishlist
            const wishlistForms = document.querySelectorAll('.form-wishlist');
            wishlistForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    if (!isUserLoggedIn) {
                        e.preventDefault();
                        Swal.fire({
                            title: 'Login Diperlukan',
                            text: 'Silakan login terlebih dahulu untuk menyimpan buku ke wishlist favorit Anda.',
                            icon: 'info',
                            showCancelButton: true,
                            confirmButtonColor: '#23085A',
                            cancelButtonColor: '#64748B',
                            confirmButtonText: 'Login Sekarang',
                            cancelButtonText: 'Nanti Saja'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = loginUrl;
                            }
                        });
                    }
                });
            });

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
