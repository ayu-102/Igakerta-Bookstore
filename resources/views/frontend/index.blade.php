@extends('layouts.app')

@section('title', 'IGAKERTA Book Store - Toko Buku & Penerbit Resmi')

@push('styles')
    <!-- CDN SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        /* UTILITY & LAYOUT OVERFLOW PREVENTION */
        body,
        html {
            overflow-x: hidden !important;
            max-width: 100% !important;
        }

        .section-padding {
            padding: 40px 6%;
        }

        .section-title-wrap {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--text-dark);
        }

        .see-all-link {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .see-all-link:hover {
            color: var(--primary-purple);
        }

        /* 1. HERO BANNER SECTION */
        .hero-banner-wrap {
            background: linear-gradient(135deg, #18003C 0%, #300C63 100%);
            padding: 40px 6%;
            color: white;
            position: relative;
            margin: 20px 6%;
            border-radius: 16px;
        }

        .hero-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 30px;
        }

        .hero-text-side {
            max-width: 550px;
        }

        .hero-text-side h1 {
            font-size: 2.1rem;
            font-weight: 800;
            line-height: 1.25;
            margin-bottom: 12px;
        }

        .hero-text-side h1 span {
            color: var(--accent-yellow);
        }

        .hero-text-side p {
            font-size: 0.85rem;
            opacity: 0.85;
            margin-bottom: 25px;
        }

        .hero-stats {
            display: flex;
            gap: 20px;
            margin-top: 25px;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .stat-item i {
            font-size: 1.1rem;
            background: rgba(255, 255, 255, 0.15);
            padding: 8px;
            border-radius: 50%;
            color: white;
        }

        .stat-text h4 {
            font-size: 0.85rem;
            font-weight: 800;
            margin: 0;
        }

        .stat-text p {
            font-size: 0.7rem;
            margin: 0;
            opacity: 0.7;
        }

        .slider-dots {
            display: flex;
            gap: 6px;
            margin-top: 25px;
        }

        .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
        }

        .dot.active {
            width: 20px;
            border-radius: 10px;
            background: var(--accent-yellow);
        }

        .nav-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 32px;
            height: 32px;
            background: white;
            color: var(--text-dark);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            cursor: pointer;
            z-index: 10;
        }

        .nav-arrow.left {
            left: -16px;
        }

        .nav-arrow.right {
            right: -16px;
        }

        /* 2. KATEGORI POPULER GRID */
        .category-grid {
            display: grid !important;
            grid-template-columns: repeat(8, 1fr) !important;
            gap: 12px !important;
        }

        @media (max-width: 1200px) {
            .category-grid {
                grid-template-columns: repeat(4, 1fr) !important;
            }
        }

        .category-card {
            background: #F8FAFC;
            border: 1px solid #F1F5F9;
            border-radius: 10px;
            padding: 15px 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            transition: all 0.2s ease;
        }

        .category-card:hover {
            border-color: var(--purple-light);
            background: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        /* 3 & 5. BUKU GRID */
        .book-grid {
            display: grid !important;
            grid-template-columns: repeat(6, 1fr) !important;
            gap: 16px !important;
            width: 100% !important;
        }

        /* Badge Diskon di Kartu Buku */
        .badge-diskon {
            position: absolute;
            top: 8px;
            right: 8px;
            background: #DC2626;
            color: white;
            font-size: 0.65rem;
            font-weight: 800;
            padding: 3px 8px;
            border-radius: 4px;
            z-index: 2;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);
        }

        /* Tampilan Harga Coret */
        .book-price-box {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 6px;
            flex-wrap: wrap;
        }

        .price-discount {
            font-size: 0.82rem;
            font-weight: 800;
            color: #DC2626;
        }

        .price-original {
            font-size: 0.7rem;
            color: #94A3B8;
            text-decoration: line-through;
        }

        @media (max-width: 1200px) {
            .book-grid {
                grid-template-columns: repeat(3, 1fr) !important;
            }
        }

        @media (max-width: 768px) {
            .book-grid {
                grid-template-columns: repeat(2, 1fr) !important;
            }
        }

        .book-card {
            background: white !important;
            border: 1px solid #E2E8F0 !important;
            border-radius: 10px !important;
            padding: 12px !important;
            display: flex !important;
            flex-direction: column !important;
            justify-content: space-between !important;
            position: relative !important;
            overflow: hidden !important;
            box-sizing: border-box !important;
            transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
            cursor: pointer;
            text-decoration: none !important;
            color: inherit !important;
        }

        .book-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
            border-color: var(--primary-purple) !important;
        }

        .badge-rank {
            position: absolute;
            top: 18px;
            left: 18px;
            background: var(--accent-yellow);
            color: var(--primary-purple);
            font-weight: 800;
            font-size: 0.75rem;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2;
        }

        /* Badge Ebook di Kartu Buku */
        .badge-ebook {
            position: absolute;
            top: 8px;
            left: 8px;
            background: #2563EB;
            color: white;
            font-size: 0.65rem;
            font-weight: 800;
            padding: 3px 8px;
            border-radius: 4px;
            z-index: 2;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .book-cover-box {
            position: relative !important;
            width: 100% !important;
            height: 200px !important;
            background: #F8FAFC !important;
            border-radius: 8px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            overflow: hidden !important;
            margin-bottom: 12px !important;
        }

        .book-cover-box img {
            max-height: 180px !important;
            max-width: 90% !important;
            width: auto !important;
            height: auto !important;
            object-fit: contain !important;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .book-card:hover .book-cover-box img {
            transform: scale(1.05);
        }

        .book-title {
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--text-dark);
            line-height: 1.3;
            margin-bottom: 4px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            height: 2.6em;
        }

        .book-author {
            font-size: 0.7rem;
            color: var(--text-muted);
            margin-bottom: 6px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .book-price {
            font-size: 0.82rem;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 6px;
        }

        .book-rating {
            display: flex;
            align-items: center;
            gap: 2px;
            font-size: 0.65rem;
            color: #FFC107;
        }

        .book-rating span {
            color: var(--text-muted);
            margin-left: 2px;
        }

        .book-bottom {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 8px;
        }

        .btn-add-cart-sm {
            background: var(--primary-purple);
            color: white;
            border: none;
            width: 26px;
            height: 26px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 0.75rem;
            transition: background-color 0.2s ease, transform 0.2s ease;
        }

        .btn-add-cart-sm:hover {
            background: var(--accent-yellow);
            color: var(--primary-purple);
            transform: scale(1.1);
        }

        /* 4. PROMO BANNERS DOUBLE */
        .promo-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            padding: 0 6%;
            margin: 20px 0;
        }

        @media (max-width: 768px) {
            .promo-grid {
                grid-template-columns: 1fr;
            }
        }

        /* 8. FEATURES BAR */
        .features-bar {
            background: white;
            border-top: 1px solid var(--border-color);
            border-bottom: 1px solid var(--border-color);
            padding: 25px 6%;
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 15px;
            margin-top: 30px;
        }

        @media (max-width: 900px) {
            .features-bar {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .feature-item i {
            font-size: 1.2rem;
            color: var(--primary-purple);
            background: #F5EFFF;
            padding: 10px;
            border-radius: 8px;
        }

        .feature-text h5 {
            font-size: 0.78rem;
            font-weight: 700;
            margin: 0 0 2px;
        }

        .feature-text p {
            font-size: 0.68rem;
            color: var(--text-muted);
            margin: 0;
        }
    </style>
@endpush

@section('content')

    <!-- 1. HERO BANNER SECTION -->
    <div style="position: relative; margin: 20px 6%;">
        <div class="hero-banner-wrap"
            style="background: linear-gradient(90deg, #18003C 0%, #290858 55%, rgba(41, 8, 88, 0.45) 100%), url('https://images.unsplash.com/photo-1521587760476-6c12a4b040da?q=80&w=1200&auto=format&fit=crop') center / cover no-repeat; height: 380px; max-height: 380px; display: flex; align-items: center; border-radius: 16px; padding: 0 6%; margin: 0; box-sizing: border-box; overflow: hidden;">

            <div class="hero-content"
                style="display: flex; align-items: center; justify-content: space-between; width: 100%; position: relative; z-index: 2;">

                <!-- Sisi Kiri: Teks & Informasi -->
                <div class="hero-text-side" style="max-width: 520px;">
                    <h1 style="font-size: 2rem; font-weight: 800; line-height: 1.25; margin-bottom: 12px; color: white;">
                        Temukan Buku Terbaik<br>
                        untuk <span style="color: #FFC000;">Pengembangan Diri,<br>Akademik, dan Penelitian</span>
                    </h1>
                    <p style="font-size: 0.85rem; opacity: 0.85; margin-bottom: 22px; color: white;">
                        Tersedia <span style="color: #FFC000; font-weight: 600;">ribuan buku berkualitas</span><br>dari
                        penulis terbaik dan berpengalaman.
                    </p>

                    <a href="{{ route('catalog.index') }}" class="btn-hero"
                        style="background: #FFC000; color: #23085A; padding: 10px 22px; border-radius: 20px; font-weight: 700; font-size: 0.82rem; display: inline-flex; align-items: center; gap: 6px; text-decoration: none;">
                        Belanja Sekarang <i class="fa-solid fa-arrow-right"></i>
                    </a>

                    <div class="hero-stats" style="display: flex; gap: 20px; margin-top: 25px;">
                        <div class="stat-item" style="display: flex; align-items: center; gap: 10px;">
                            <i class="fa-solid fa-graduation-cap"
                                style="background: rgba(255, 255, 255, 0.15); padding: 10px; border-radius: 50%; color: white; font-size: 1rem;"></i>
                            <div class="stat-text">
                                <h4 style="font-size: 0.85rem; font-weight: 800; margin: 0; color: white;">10.000+</h4>
                                <p style="font-size: 0.7rem; margin: 0; opacity: 0.7; color: white;">Judul Buku</p>
                            </div>
                        </div>
                        <div class="stat-item" style="display: flex; align-items: center; gap: 10px;">
                            <i class="fa-solid fa-user-group"
                                style="background: rgba(255, 255, 255, 0.15); padding: 10px; border-radius: 50%; color: white; font-size: 1rem;"></i>
                            <div class="stat-text">
                                <h4 style="font-size: 0.85rem; font-weight: 800; margin: 0; color: white;">100+</h4>
                                <p style="font-size: 0.7rem; margin: 0; opacity: 0.7; color: white;">Penulis</p>
                            </div>
                        </div>
                        <div class="stat-item" style="display: flex; align-items: center; gap: 10px;">
                            <i class="fa-solid fa-award"
                                style="background: rgba(255, 255, 255, 0.15); padding: 10px; border-radius: 50%; color: white; font-size: 1rem;"></i>
                            <div class="stat-text">
                                <h4 style="font-size: 0.85rem; font-weight: 800; margin: 0; color: white;">ISBN Resmi</h4>
                                <p style="font-size: 0.7rem; margin: 0; opacity: 0.7; color: white;">Perpusnas</p>
                            </div>
                        </div>
                    </div>

                    <div class="slider-dots" style="display: flex; gap: 6px; margin-top: 20px;">
                        <div class="dot active" style="width: 20px; height: 8px; border-radius: 10px; background: #FFC000;">
                        </div>
                        <div class="dot"
                            style="width: 8px; height: 8px; border-radius: 50%; background: rgba(255, 255, 255, 0.3);">
                        </div>
                        <div class="dot"
                            style="width: 8px; height: 8px; border-radius: 50%; background: rgba(255, 255, 255, 0.3);">
                        </div>
                        <div class="dot"
                            style="width: 8px; height: 8px; border-radius: 50%; background: rgba(255, 255, 255, 0.3);">
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Tombol Navigasi -->
        <div class="nav-arrow left"
            style="position: absolute; top: 50%; left: -18px; transform: translateY(-50%); width: 36px; height: 36px; background: white; color: #18003C; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px rgba(0,0,0,0.2); cursor: pointer; z-index: 10;">
            <i class="fa-solid fa-chevron-left"></i>
        </div>
        <div class="nav-arrow right"
            style="position: absolute; top: 50%; right: -18px; transform: translateY(-50%); width: 36px; height: 36px; background: white; color: #18003C; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px rgba(0,0,0,0.2); cursor: pointer; z-index: 10;">
            <i class="fa-solid fa-chevron-right"></i>
        </div>
    </div>

    <!-- 2. KATEGORI POPULER SECTION -->
    <div class="categories-section" style="margin: 40px 6%;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="font-weight: 800; color: #1E0A3C; margin: 0;">Kategori Populer</h3>
            <a href="{{ route('catalog.index') }}"
                style="color: #6C757D; font-size: 0.85rem; text-decoration: none; font-weight: 600;">
                Lihat Semua Kategori &rarr;
            </a>
        </div>

        <div class="category-grid">
            @php
                $iconMap = [
                    'fiksi-sastra' => 'fa-feather',
                    'pengembangan-diri' => 'fa-user-graduate',
                    'bisnis-ekonomi' => 'fa-chart-line',
                    'sains-teknologi' => 'fa-microscope',
                    'buku-ajar' => 'fa-graduation-cap',
                    'referensi-akademik' => 'fa-book-open',
                    'monograf' => 'fa-file-lines',
                    'hasil-penelitian' => 'fa-flask',
                    'sosial-humaniora' => 'fa-users',
                    'teknologi-informasi' => 'fa-desktop',
                    'manajemen' => 'fa-briefcase',
                ];
            @endphp

            @foreach ($categories as $category)
                @php
                    $icon = $iconMap[$category->slug] ?? 'fa-bookmark';
                @endphp

                <a href="{{ route('catalog.index', ['category' => $category->slug]) }}"
                    style="background: #F8F9FA; border: 1px solid #E9ECEF; border-radius: 12px; padding: 18px 10px; text-align: center; text-decoration: none; transition: all 0.2s ease;"
                    onmouseover="this.style.borderColor='#1E0A3C'; this.style.transform='translateY(-2px)';"
                    onmouseout="this.style.borderColor='#E9ECEF'; this.style.transform='translateY(0)';">

                    <div style="font-size: 1.5rem; color: #1E0A3C; margin-bottom: 8px;">
                        <i class="fa-solid {{ $icon }}"></i>
                    </div>

                    <h5 style="font-size: 0.85rem; font-weight: 700; color: #1E0A3C; margin: 0 0 4px 0;">
                        {{ $category->name }}
                    </h5>
                    <p style="font-size: 0.7rem; color: #6C757D; margin: 0;">
                        {{ $category->books_count }} Judul
                    </p>
                </a>
            @endforeach
        </div>
    </div>

    <!-- 3. BUKU TERBARU -->
    <section class="section-padding" id="katalog">
        <div class="section-title-wrap">
            <h2 class="section-title">Buku Terbaru</h2>
            <a href="{{ route('catalog.index', ['sort' => 'latest']) }}" class="see-all-link">
                Lihat Semua <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
        <div class="book-grid">
            @forelse ($newReleases as $book)
                @php
                    $authorData = $book->author;

                    if (is_object($authorData)) {
                        $authorName = $authorData->name ?? ($authorData->author ?? '-');
                    } elseif (is_array($authorData)) {
                        $authorName = $authorData['name'] ?? ($authorData['author'] ?? '-');
                    } elseif (is_string($authorData) && str_starts_with(trim($authorData), '{')) {
                        $decoded = json_decode($authorData, true);
                        $authorName = $decoded['name'] ?? ($decoded['author'] ?? $authorData);
                    } else {
                        $authorName = $authorData;
                    }

                    // Penyesuaian data ulasan & rating
                    $bookAvgRating = isset($book->reviews_avg_rating)
                        ? round($book->reviews_avg_rating, 1)
                        : $book->rating ?? 5.0;
                    $bookReviewsCount = isset($book->reviews_count)
                        ? $book->reviews_count
                        : (isset($book->reviews)
                            ? count($book->reviews)
                            : 0);
                @endphp

                <a href="{{ route('books.show', $book->id) }}" class="book-card">
                    <div>
                        <div class="book-cover-box">
                            <!-- TAG EBOOK JIKA BUKU BERTIPE EBOOK -->
                            @if ($book->type === 'ebook')
                                <span class="badge-ebook">
                                    <i class="fa-solid fa-file-pdf"></i> Ebook
                                </span>
                            @endif

                            <!-- BADGE DISKON JIKA ADA DISKON -->
                            @if (isset($book->discount_price) && $book->discount_price < $book->price)
                                @php
                                    $percent = round((($book->price - $book->discount_price) / $book->price) * 100);
                                @endphp
                                <span class="badge-diskon">-{{ $percent }}%</span>
                            @endif

                            <!-- Ganti jadi seperti ini (BENAR) -->
                            <img src="{{ asset($book->cover_image) }}" alt="{{ $book->title }}">
                        </div>

                        <h3 class="book-title">{{ $book->title }}</h3>
                        <p class="book-author">{{ $authorName }}</p>

                        <!-- KONDISI TAMPILAN HARGA -->
                        <div class="book-price-box">
                            @if (isset($book->discount_price) && $book->discount_price < $book->price)
                                <span class="price-discount">Rp
                                    {{ number_format($book->discount_price, 0, ',', '.') }}</span>
                                <span class="price-original">Rp {{ number_format($book->price, 0, ',', '.') }}</span>
                            @else
                                <span class="book-price">Rp {{ number_format($book->price, 0, ',', '.') }}</span>
                            @endif
                        </div>
                    </div>


                    <div class="book-bottom">
                        <div class="book-rating">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= floor($bookAvgRating))
                                    <i class="fa-solid fa-star"></i>
                                @elseif ($i - $bookAvgRating < 1 && $i - $bookAvgRating > 0)
                                    <i class="fa-solid fa-star-half-stroke"></i>
                                @else
                                    <i class="fa-regular fa-star"></i>
                                @endif
                            @endfor
                            <span>({{ number_format($bookAvgRating, 1) }} @if ($bookReviewsCount > 0)
                                    &bull; {{ $bookReviewsCount }} ulasan
                                @endif)</span>
                        </div>
                        <form action="{{ route('cart.add', $book->id) }}" method="POST"
                            onclick="event.stopPropagation();" style="margin: 0;">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn-add-cart-sm" title="Tambah ke Keranjang">
                                <i class="fa-solid fa-cart-shopping"></i>
                            </button>
                        </form>
                    </div>
                </a>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; color: var(--text-muted); padding: 20px;">
                    Belum ada data buku yang tersedia.
                </div>
            @endforelse
        </div>
    </section>

    <!-- 4. BANNER PROMO & LOYALTY MEMBER SECTION (2 COLUMN) -->
    <section class="section-padding" style="padding-top: 20px; padding-bottom: 20px;">
        <div class="promo-grid" style="padding: 0; margin: 0;">

            <!-- Banner 1: Diskon Spesial (15%) -->
            <div
                style="background: linear-gradient(135deg, #1E0A3C 0%, #3B1277 100%); border-radius: 16px; padding: 28px 32px; color: white; display: flex; justify-content: space-between; align-items: center; position: relative; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); min-height: 160px; box-sizing: border-box;">
                <div style="z-index: 2; max-width: 70%;">
                    <span
                        style="font-size: 0.75rem; font-weight: 700; background: rgba(255,255,255,0.2); padding: 4px 12px; border-radius: 20px; display: inline-block; margin-bottom: 10px;">Diskon
                        Spesial</span>
                    <h4 style="font-size: 1.1rem; font-weight: 800; margin: 0 0 6px 0; line-height: 1.3;">Untuk Semua Buku
                    </h4>
                    <p style="font-size: 0.8rem; opacity: 0.85; margin: 0 0 16px 0;">Dapatkan diskon hingga <b
                            style="color: #FFC000; font-size: 1.2rem;">15%</b></p>
                    <a href="{{ route('catalog.index', ['filter' => 'promo']) }}"
                        style="background: #FFC000; color: #1E0A3C; font-size: 0.8rem; font-weight: 800; padding: 9px 18px; border-radius: 20px; text-decoration: none; display: inline-block;">Belanja
                        Sekarang &rarr;</a>
                </div>
                <div
                    style="font-size: 5rem; opacity: 0.15; color: white; position: absolute; right: 20px; bottom: -5px; pointer-events: none;">
                    <i class="fa-solid fa-percent"></i>
                </div>
            </div>

            <!-- Banner 2: Loyalty Member & Poin Reward -->
            <div
                style="background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%); border-radius: 16px; padding: 28px 32px; color: white; display: flex; justify-content: space-between; align-items: center; position: relative; overflow: hidden; border: 1px solid #334155; min-height: 160px; box-sizing: border-box;">
                <div style="z-index: 2; max-width: 70%;">
                    <span
                        style="font-size: 0.75rem; font-weight: 800; background: #FFC000; color: #0F172A; padding: 4px 12px; border-radius: 20px; display: inline-block; margin-bottom: 10px;">
                        <i class="fa-solid fa-coins" style="margin-right: 4px;"></i> Loyalty Member
                    </span>
                    <h4 style="font-size: 1.1rem; font-weight: 800; margin: 0 0 6px 0; line-height: 1.3;">Kumpulkan Poin
                        Setiap Belanja</h4>
                    <p style="font-size: 0.8rem; opacity: 0.85; margin: 0 0 16px 0;">Tukarkan poin belanja Anda dengan
                        voucher diskon & potongan harga!</p>

                    @auth
                        <a href="{{ route('customer.member.index') }}"
                            style="background: #FFC000; color: #0F172A; font-size: 0.8rem; font-weight: 800; padding: 9px 18px; border-radius: 20px; text-decoration: none; display: inline-block;">
                            Cek Poin Saya &rarr;
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            style="background: #FFC000; color: #0F172A; font-size: 0.8rem; font-weight: 800; padding: 9px 18px; border-radius: 20px; text-decoration: none; display: inline-block;">
                            Daftar / Login &rarr;
                        </a>
                    @endauth
                </div>
                <div
                    style="font-size: 4.8rem; color: #FFC000; opacity: 0.2; position: absolute; right: 20px; bottom: -5px; pointer-events: none;">
                    <i class="fa-solid fa-award"></i>
                </div>
            </div>

        </div>
    </section>

    <!-- 5. BUKU TERLARIS -->
    <section class="section-padding">
        <div class="section-title-wrap">
            <h2 class="section-title">Buku Terlaris</h2>
            <a href="{{ route('catalog.index', ['filter' => 'bestseller']) }}" class="see-all-link">
                Lihat Semua <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
        <div class="book-grid">
            @forelse ($featuredBooks as $index => $book)
                @php
                    $authorData = $book->author;

                    if (is_object($authorData)) {
                        $authorName = $authorData->name ?? ($authorData->author ?? '-');
                    } elseif (is_array($authorData)) {
                        $authorName = $authorData['name'] ?? ($authorData['author'] ?? '-');
                    } elseif (is_string($authorData) && str_starts_with(trim($authorData), '{')) {
                        $decoded = json_decode($authorData, true);
                        $authorName = $decoded['name'] ?? ($decoded['author'] ?? $authorData);
                    } else {
                        $authorName = $authorData;
                    }

                    // Penyesuaian data ulasan & rating
                    $bookAvgRating = isset($book->reviews_avg_rating)
                        ? round($book->reviews_avg_rating, 1)
                        : $book->rating ?? 5.0;
                    $bookReviewsCount = isset($book->reviews_count)
                        ? $book->reviews_count
                        : (isset($book->reviews)
                            ? count($book->reviews)
                            : 0);
                @endphp

                <a href="{{ route('books.show', $book->id) }}" class="book-card">
                    <div>
                        <div class="book-cover-box">
                            <!-- TAG EBOOK JIKA BUKU BERTIPE EBOOK -->
                            @if ($book->type === 'ebook')
                                <span class="badge-ebook">
                                    <i class="fa-solid fa-file-pdf"></i> Ebook
                                </span>
                            @endif

                            <!-- BADGE DISKON JIKA ADA DISKON -->
                            @if (isset($book->discount_price) && $book->discount_price < $book->price)
                                @php
                                    $percent = round((($book->price - $book->discount_price) / $book->price) * 100);
                                @endphp
                                <span class="badge-diskon">-{{ $percent }}%</span>
                            @endif

                            <!-- Ganti jadi seperti ini (BENAR) -->
                            <img src="{{ asset($book->cover_image) }}" alt="{{ $book->title }}">
                        </div>

                        <h3 class="book-title">{{ $book->title }}</h3>
                        <p class="book-author">{{ $authorName }}</p>

                        <!-- KONDISI TAMPILAN HARGA -->
                        <div class="book-price-box">
                            @if (isset($book->discount_price) && $book->discount_price < $book->price)
                                <span class="price-discount">Rp
                                    {{ number_format($book->discount_price, 0, ',', '.') }}</span>
                                <span class="price-original">Rp {{ number_format($book->price, 0, ',', '.') }}</span>
                            @else
                                <span class="book-price">Rp {{ number_format($book->price, 0, ',', '.') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="book-bottom">
                        <div class="book-rating">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= floor($bookAvgRating))
                                    <i class="fa-solid fa-star"></i>
                                @elseif ($i - $bookAvgRating < 1 && $i - $bookAvgRating > 0)
                                    <i class="fa-solid fa-star-half-stroke"></i>
                                @else
                                    <i class="fa-regular fa-star"></i>
                                @endif
                            @endfor
                            <span>({{ number_format($bookAvgRating, 1) }} @if ($bookReviewsCount > 0)
                                    &bull; {{ $bookReviewsCount }} ulasan
                                @endif)</span>
                        </div>
                        <form action="{{ route('cart.add', $book->id) }}" method="POST"
                            onclick="event.stopPropagation();" style="margin: 0;">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn-add-cart-sm" title="Tambah ke Keranjang">
                                <i class="fa-solid fa-cart-shopping"></i>
                            </button>
                        </form>
                    </div>
                </a>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; color: var(--text-muted); padding: 20px;">
                    Belum ada data buku terlaris yang ditandai.
                </div>
            @endforelse
        </div>
    </section>

    <!-- 6. PENULIS PILIHAN -->
    <section class="section-padding" style="padding-top: 20px; padding-bottom: 20px;">
        <div class="section-title-wrap">
            <h2 class="section-title">Penulis Pilihan</h2>
            <a href="{{ route('authors.index') }}" class="see-all-link">Lihat Semua <i
                    class="fa-solid fa-arrow-right"></i></a>
        </div>

        <div style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 16px;">
            @forelse ($featuredAuthors as $author)
                @php
                    $isObj = is_object($author);
                    $authorName = $isObj ? $author->name ?? ($author->author ?? 'Penulis') : $author;
                    $authorPhoto = $isObj ? $author->photo ?? null : null;
                    $authorTitle = $isObj ? $author->title ?? 'Penulis Resmi' : 'Penulis Resmi';

                    $authorUrl = $isObj
                        ? route('authors.show', $author->id ?? ($author->slug ?? $authorName))
                        : route('catalog.index', ['author' => $authorName]);
                @endphp
                <a href="{{ $authorUrl }}" style="text-decoration: none; color: inherit;">
                    <div style="background: #fff; border-radius: 12px; padding: 16px; text-align: center; box-shadow: 0 2px 8px rgba(0,0,0,0.05); border: 1px solid #f1f5f9; transition: transform 0.2s ease, border-color 0.2s ease;"
                        onmouseover="this.style.transform='translateY(-4px)'; this.style.borderColor='var(--primary-purple, #1E0A3C)';"
                        onmouseout="this.style.transform='translateY(0)'; this.style.borderColor='#f1f5f9';">

                        @if ($authorPhoto)
                            <img src="{{ asset($authorPhoto) }}" alt="{{ $authorName }}"
                                style="width: 70px; height: 70px; border-radius: 50%; object-fit: cover; margin: 0 auto 12px auto; display: block;">
                        @else
                            <div
                                style="width: 70px; height: 70px; border-radius: 50%; background: linear-gradient(135deg, #23085A 0%, #4A1996 100%); color: white; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: 800; margin: 0 auto 12px auto;">
                                {{ strtoupper(substr($authorName, 0, 1)) }}
                            </div>
                        @endif

                        <h5 style="font-size: 0.95rem; font-weight: 700; margin-bottom: 4px; color: var(--text-dark);">
                            {{ $authorName }}
                        </h5>
                        <p style="font-size: 0.8rem; color: #64748b; margin-bottom: 0;">
                            {{ $authorTitle }}
                        </p>
                    </div>
                </a>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; color: var(--text-muted); padding: 20px;">
                    Belum ada penulis pilihan.
                </div>
            @endforelse
        </div>
    </section>

    <!-- 7. KATA PEMBACA -->
    <section class="section-padding" style="padding-top: 20px; padding-bottom: 20px;">
        <div style="text-align: center; margin-bottom: 30px;">
            <h2 class="section-title" style="margin-bottom: 6px;">Apa Kata Pembaca?</h2>
            <p style="color: #64748b; font-size: 0.85rem; margin: 0;">Pengalaman mereka berbelanja dan membaca buku di
                IGAKERTA</p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
            @forelse ($testimonials as $testi)
                <div
                    style="background: #fff; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); border: 1px solid #f1f5f9; display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <div style="color: #f59e0b; margin-bottom: 10px; font-size: 0.85rem;">
                            @for ($i = 1; $i <= ($testi->rating ?? 5); $i++)
                                <i class="fa-solid fa-star"></i>
                            @endfor
                        </div>
                        <p style="font-size: 0.85rem; color: #334155; font-style: italic; margin-bottom: 16px;">
                            "{{ $testi->quote }}"
                        </p>
                    </div>

                    <div style="display: flex; align-items: center; gap: 12px;">
                        <img src="{{ $testi->avatar ? asset('storage/' . $testi->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($testi->name) }}"
                            alt="{{ $testi->name }}"
                            style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                        <div>
                            <h6 style="font-size: 0.85rem; font-weight: 700; margin: 0; color: var(--text-dark);">
                                {{ $testi->name }}
                            </h6>
                            <small style="color: #94a3b8; font-size: 0.75rem;">{{ $testi->role ?? 'Pembaca' }}</small>
                        </div>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; color: var(--text-muted); padding: 20px;">
                    Belum ada ulasan dari pembaca.
                </div>
            @endforelse
        </div>
    </section>

    <!-- 8. KENAPA BELANJA BAR -->
    <div style="text-align: center; margin-top: 30px;">
        <h3 style="font-size: 1.1rem; font-weight: 800; color: var(--text-dark);">Kenapa Belanja di IGAKERTA Book Store?
        </h3>
    </div>
    <div class="features-bar">
        <div class="feature-item">
            <i class="fa-solid fa-shield-halved"></i>
            <div class="feature-text">
                <h5>Buku Original</h5>
                <p>100% buku original dan berkualitas</p>
            </div>
        </div>
        <div class="feature-item">
            <i class="fa-solid fa-truck-fast"></i>
            <div class="feature-text">
                <h5>Pengiriman Cepat</h5>
                <p>Dikirim ke seluruh Indonesia</p>
            </div>
        </div>
        <div class="feature-item">
            <i class="fa-solid fa-lock"></i>
            <div class="feature-text">
                <h5>Pembayaran Aman</h5>
                <p>Transaksi aman dengan berbagai metode</p>
            </div>
        </div>
        <div class="feature-item">
            <i class="fa-solid fa-headset"></i>
            <div class="feature-text">
                <h5>Layanan 24/7</h5>
                <p>Customer service siap membantu Anda</p>
            </div>
        </div>
        <div class="feature-item">
            <i class="fa-solid fa-box-open"></i>
            <div class="feature-text">
                <h5>Garansi Buku</h5>
                <p>Garansi ganti buku jika terjadi kerusakan</p>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <!-- CDN SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
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

            // Tampilkan Toast jika ada session notification (misal setelah tambah keranjang)
            @if (session('success'))
                Toast.fire({
                    icon: 'success',
                    title: "{!! session('success') !!}"
                });
            @endif

            @if (session('error'))
                Toast.fire({
                    icon: 'error',
                    title: "{!! session('error') !!}"
                });
            @endif

            // Hero Slider JS
            const dots = document.querySelectorAll('.slider-dots .dot');
            const prevBtn = document.querySelector('.nav-arrow.left');
            const nextBtn = document.querySelector('.nav-arrow.right');

            let currentIndex = 0;

            const slides = [{
                    title: 'Temukan Buku Terbaik<br>untuk <span style="color: #FFC000;">Pengembangan Diri,<br>Akademik, dan Penelitian</span>',
                    desc: 'Tersedia <span style="color: #FFC000; font-weight: 600;">ribuan buku berkualitas</span><br>dari penulis terbaik dan berpengalaman.',
                    bg: 'https://images.unsplash.com/photo-1521587760476-6c12a4b040da?q=80&w=1200&auto=format&fit=crop'
                },
                {
                    title: 'Koleksi <span style="color: #FFC000;">Buku Ajar & Monograf</span><br>Terlengkap & Terpercaya',
                    desc: 'Mendukung pembelajaran <span style="color: #FFC000; font-weight: 600;">akademik perguruan tinggi</span> dengan cetakan ber-ISBN resmi.',
                    bg: 'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?q=80&w=1200&auto=format&fit=crop'
                },
                {
                    title: 'Promo Diskon <span style="color: #FFC000;">Spesial Bulan Ini</span><br>Hingga 15%',
                    desc: 'Dapatkan penawaran menarik untuk <span style="color: #FFC000; font-weight: 600;">pembelian bundle buku</span> pilihan.',
                    bg: 'https://images.unsplash.com/photo-1507842217343-583bb7270b66?q=80&w=1200&auto=format&fit=crop'
                },
                {
                    title: 'Penerbitan Buku Karya <span style="color: #FFC000;">Dosen & Peneliti</span>',
                    desc: 'Jadikan karya tulis Anda <span style="color: #FFC000; font-weight: 600;">diakui secara nasional</span> bersama IGAKERTA.',
                    bg: 'https://images.unsplash.com/photo-1457369804613-52c61a468e7d?q=80&w=1200&auto=format&fit=crop'
                }
            ];

            const heroWrap = document.querySelector('.hero-banner-wrap');
            const heroTitle = heroWrap ? heroWrap.querySelector('h1') : null;
            const heroDesc = heroWrap ? heroWrap.querySelector('p') : null;

            function updateSlide(index) {
                if (!heroWrap || !heroTitle || !heroDesc) return;

                heroWrap.style.transition = 'opacity 0.3s ease';
                heroWrap.style.opacity = '0.4';

                setTimeout(() => {
                    heroTitle.innerHTML = slides[index].title;
                    heroDesc.innerHTML = slides[index].desc;
                    heroWrap.style.background =
                        `linear-gradient(90deg, #18003C 0%, #290858 55%, rgba(41, 8, 88, 0.45) 100%), url('${slides[index].bg}') right center / cover no-repeat`;

                    dots.forEach((dot, idx) => {
                        if (idx === index) {
                            dot.classList.add('active');
                            dot.style.width = '20px';
                            dot.style.background = '#FFC000';
                        } else {
                            dot.classList.remove('active');
                            dot.style.width = '8px';
                            dot.style.background = 'rgba(255, 255, 255, 0.3)';
                        }
                    });

                    heroWrap.style.opacity = '1';
                }, 300);
            }

            if (nextBtn) {
                nextBtn.addEventListener('click', function() {
                    currentIndex = (currentIndex + 1) % slides.length;
                    updateSlide(currentIndex);
                });
            }

            if (prevBtn) {
                prevBtn.addEventListener('click', function() {
                    currentIndex = (currentIndex - 1 + slides.length) % slides.length;
                    updateSlide(currentIndex);
                });
            }

            dots.forEach((dot, index) => {
                dot.style.cursor = 'pointer';
                dot.addEventListener('click', function() {
                    currentIndex = index;
                    updateSlide(currentIndex);
                });
            });

            setInterval(() => {
                currentIndex = (currentIndex + 1) % slides.length;
                updateSlide(currentIndex);
            }, 5000);
        });
    </script>
@endpush
