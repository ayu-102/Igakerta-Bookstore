<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'IGAKERTA Book Store')</title>

    <!-- Google Fonts & Font Awesome -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Bootstrap 5 CSS (Dibutuhkan untuk Form, Grid & Alert) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <style>
        :root {
            --primary-purple: #23085A;
            --purple-light: #4A1996;
            --purple-soft: #F5EFFF;
            --accent-yellow: #FFC000;
            --accent-yellow-hover: #E0A800;
            --text-dark: #1E293B;
            --text-muted: #64748B;
            --bg-light: #F8FAFC;
            --border-color: #E2E8F0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background-color: #FAFAFA;
            color: var(--text-dark);
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        /* TOPBAR */
        .topbar {
            background: var(--primary-purple);
            color: white;
            padding: 8px 6%;
            font-size: 0.75rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .topbar-right {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .topbar-right a:hover {
            color: var(--accent-yellow);
        }

        /* MAIN NAVBAR */
        .navbar-main {
            background: white;
            padding: 18px 6%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--border-color);
        }

        .search-box {
            display: flex;
            align-items: center;
            background: #F8FAFC;
            border: 1px solid #E2E8F0;
            border-radius: 30px;
            padding: 5px 6px 5px 20px;
            width: 52%;
            transition: all 0.2s ease;
        }

        .search-box:focus-within {
            border-color: var(--primary-purple);
            box-shadow: 0 0 0 3px rgba(35, 8, 90, 0.08);
        }

        .search-box input {
            border: none;
            background: transparent;
            outline: none;
            width: 100%;
            font-size: 0.85rem;
            color: var(--text-dark);
        }

        .search-box select {
            border: none;
            background: transparent;
            outline: none;
            font-size: 0.82rem;
            color: var(--text-muted);
            padding: 0 12px;
            border-left: 1px solid #CBD5E1;
            cursor: pointer;
        }

        .btn-search {
            background: var(--primary-purple);
            color: white;
            border: none;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 0.9rem;
            transition: background 0.2s ease;
        }

        .btn-search:hover {
            background: var(--purple-light);
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 22px;
        }

        .nav-icon-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            font-size: 0.72rem;
            color: var(--text-dark);
            position: relative;
        }

        /* CATEGORY NAV BAR */
        .cat-navbar {
            background: white;
            padding: 12px 6%;
            display: flex;
            align-items: center;
            gap: 24px;
            border-bottom: 1px solid var(--border-color);
            font-size: 0.95rem;
            font-weight: 700;
        }

        .cat-nav-item {
            color: var(--text-dark);
            padding: 8px 12px;
            display: flex;
            align-items: center;
            gap: 6px;
            border-radius: 6px;
            transition: all 0.2s ease;
        }

        .cat-nav-item:hover {
            color: var(--primary-purple);
        }

        .cat-nav-item.active {
            color: white;
            background: var(--primary-purple);
            padding: 8px 18px;
            border-radius: 8px;
        }

        /* DROPDOWN LIST FOR KATALOG & EBOOK */
        .cat-dropdown-wrapper {
            position: relative;
            display: inline-block;
        }

        .cat-dropdown-menu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            min-width: 220px;
            background-color: #ffffff;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 8px 0;
            z-index: 1000;
        }

        .cat-dropdown-wrapper:hover .cat-dropdown-menu {
            display: block;
        }

        .cat-dropdown-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 18px;
            color: var(--text-dark);
            font-size: 0.88rem;
            font-weight: 600;
            text-decoration: none;
            transition: background-color 0.2s, color 0.2s;
        }

        .cat-dropdown-item:hover {
            background-color: var(--purple-soft);
            color: var(--primary-purple);
        }

        .cat-dropdown-divider {
            height: 1px;
            background-color: var(--border-color);
            margin: 6px 0;
        }

        /* HELP / CONSULTATION BAR */
        .newsletter-bar {
            background: var(--primary-purple);
            color: white;
            padding: 30px 6%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-radius: 12px;
            margin: 40px 6%;
        }

        .newsletter-text {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .btn-subscribe {
            background: var(--accent-yellow);
            color: var(--primary-purple);
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 700;
            cursor: pointer;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
            white-space: nowrap;
            text-decoration: none;
        }

        .btn-subscribe:hover {
            background: var(--accent-yellow-hover);
            color: var(--primary-purple);
        }

        /* FOOTER */
        footer {
            background: #110426;
            color: white;
            padding: 50px 6% 20px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr 1.5fr;
            gap: 30px;
            margin-bottom: 40px;
            font-size: 0.8rem;
        }

        .footer-col h4 {
            font-size: 0.9rem;
            margin-bottom: 18px;
            color: white;
            font-weight: 700;
        }

        .footer-col ul {
            list-style: none;
            padding-left: 0;
        }

        .footer-col ul li {
            margin-bottom: 10px;
            opacity: 0.75;
        }

        .footer-col ul li a:hover {
            color: var(--accent-yellow);
            opacity: 1;
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.75rem;
            opacity: 0.7;
        }

        .social-icons-footer {
            display: flex;
            gap: 12px;
            margin-top: 15px;
        }

        .social-icons-footer a {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
        }

        .scroll-top-btn {
            position: fixed;
            bottom: 25px;
            right: 25px;
            width: 38px;
            height: 38px;
            background: var(--primary-purple);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            z-index: 99;
        }
    </style>
    @stack('styles')
</head>

<body>

    <!-- TOPBAR -->
    <div class="topbar">
        <div><i class="fa-solid fa-sparkles"></i> Selamat datang di IGAKERTA Book Store</div>
        <div class="topbar-right">
            <a href="{{ route('about') }}"><i class="fa-regular fa-circle-question"></i> Bantuan</a>
            <a href="{{ route('customer.orders.index') }}"><i class="fa-solid fa-truck-fast"></i> Lacak Pesanan</a>
            <a href="https://wa.me/6285124157382?text=Halo%20Admin%20IGAKERTA,%20saya%20ingin%20bertanya"
                target="_blank"><i class="fa-solid fa-phone"></i> Kontak Kami</a>
            <div style="display: flex; gap: 8px; margin-left: 5px;">
                <a href="https://facebook.com" target="_blank"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="https://instagram.com" target="_blank"><i class="fa-brands fa-instagram"></i></a>
                <a href="https://youtube.com" target="_blank"><i class="fa-brands fa-youtube"></i></a>
            </div>
        </div>
    </div>

    <!-- MAIN NAVBAR -->
    <header class="navbar-main">
        <a href="{{ route('home') }}" class="logo"
            style="display: flex; align-items: center; gap: 10px; text-decoration: none;">
            <img src="{{ asset('images/logo.png') }}" alt="Logo IGAKERTA"
                style="height: 45px; width: auto; object-fit: contain;">
            <span
                style="font-weight: 800; font-size: 1.15rem; color: #1E0A3C; line-height: 1.1; letter-spacing: -0.2px;">
                IGAKERTA<br>
                <small
                    style="font-size: 0.62rem; color: #E0A800; display: block; font-weight: 800; letter-spacing: 0.8px; margin-top: 1px;">BOOK
                    STORE</small>
            </span>
        </a>

        <form action="{{ route('catalog.index') }}" method="GET" class="search-box">
            <input type="text" name="search" placeholder="Cari buku berdasarkan judul, penulis, ISBN..."
                value="{{ request('search') }}">

            <select name="category" onchange="this.form.submit()">
                <option value="">Semua Kategori</option>
                @if (isset($categories))
                    @foreach ($categories as $c)
                        <option value="{{ $c->slug }}" {{ request('category') == $c->slug ? 'selected' : '' }}>
                            {{ $c->name }}
                        </option>
                    @endforeach
                @endif
            </select>

            <button type="submit" class="btn-search">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </form>

        <div class="nav-actions">
            <a href="{{ route('wishlist.index') }}"
                style="position: relative; display: inline-flex; align-items: center; justify-content: center;">
                <i class="fa-solid fa-heart" style="color: #FF4D4F; font-size: 1.25rem;"></i>
                @if (count(session('wishlist', [])) > 0)
                    <span
                        style="position: absolute; top: -6px; right: -10px; background: #FF4D4F; color: white; border-radius: 50%; width: 18px; height: 18px; font-size: 0.65rem; font-weight: bold; display: flex; align-items: center; justify-content: center; line-height: 1;">
                        {{ count(session('wishlist')) }}
                    </span>
                @endif
            </a>
            <a href="{{ route('cart.index') }}"
                style="position: relative; display: inline-flex; align-items: center; justify-content: center;">
                <i class="fa-solid fa-cart-shopping" style="color: var(--primary-purple); font-size: 1.25rem;"></i>
                @if (count(session('cart', [])) > 0)
                    <span
                        style="position: absolute; top: -6px; right: -10px; background: var(--accent-yellow); color: var(--primary-purple); border-radius: 50%; width: 18px; height: 18px; font-size: 0.65rem; font-weight: bold; display: flex; align-items: center; justify-content: center; line-height: 1;">
                        {{ count(session('cart')) }}
                    </span>
                @endif
            </a>

            <!-- NAV AUTH/LOGIN PEMBELI -->
            @auth
                <!-- TAMPILAN JIKA PEMBELI SUDAH LOGIN -->
                <a href="{{ route('customer.dashboard') }}" class="nav-icon-btn"
                    style="background: #F8FAFC; border: 1px solid #E2E8F0; padding: 6px 14px; border-radius: 20px; flex-direction: row; gap: 8px; text-decoration: none;">
                    <i class="fa-regular fa-user" style="color: var(--primary-purple); font-size: 0.9rem;"></i>
                    <div style="text-align: left; line-height: 1.2;">
                        <span style="display: block; font-size: 0.62rem; color: #64748B;">Halo,
                            {{ Str::words(Auth::user()->name, 1, '') }}</span>
                        <span style="font-weight: 700; font-size: 0.75rem; color: #0F172A;">Akun Saya</span>
                    </div>
                </a>
            @else
                <!-- TAMPILAN JIKA PEMBELI BELUM LOGIN -->
                <a href="{{ route('login') }}" class="nav-icon-btn"
                    style="background: #F8FAFC; border: 1px solid #E2E8F0; padding: 8px 16px; border-radius: 20px; flex-direction: row; gap: 6px; text-decoration: none; color: #0F172A;">
                    <i class="fa-regular fa-user"></i>
                    <span style="font-weight: 600;">Masuk / Daftar</span>
                </a>
            @endauth
        </div>
    </header>

    <!-- CATEGORY NAVBAR -->
    <nav class="cat-navbar">
        <a href="{{ route('home') }}"
            class="cat-nav-item {{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>

        <!-- DROPDOWN KATALOG BUKU -->
        <div class="cat-dropdown-wrapper">
            <a href="{{ route('catalog.index') }}"
                class="cat-nav-item {{ request()->routeIs('catalog.index') ? 'active' : '' }}">
                Katalog Buku <i class="fa-solid fa-chevron-down" style="font-size: 0.75rem;"></i>
            </a>
            <div class="cat-dropdown-menu">
                <a href="{{ route('catalog.index') }}" class="cat-dropdown-item">
                    <span>Semua Katalog</span>
                </a>
                <div class="cat-dropdown-divider"></div>
                @if (isset($categories) && count($categories) > 0)
                    @foreach ($categories as $cat)
                        <a href="{{ route('catalog.index', ['category' => $cat->slug]) }}" class="cat-dropdown-item">
                            <span>{{ $cat->name }}</span>
                        </a>
                    @endforeach
                @endif
            </div>
        </div>

        <!-- DROPDOWN EBOOK -->
        <div class="cat-dropdown-wrapper">
            <a href="{{ route('ebook.index') }}"
                class="cat-nav-item {{ request()->routeIs('ebook.index') ? 'active' : '' }}">
                Ebook <i class="fa-solid fa-chevron-down" style="font-size: 0.75rem;"></i>
            </a>
            <div class="cat-dropdown-menu">
                <a href="{{ route('ebook.index') }}" class="cat-dropdown-item">
                    <span>Semua Ebook</span>
                </a>
                <div class="cat-dropdown-divider"></div>
                @if (isset($categories) && count($categories) > 0)
                    @foreach ($categories as $cat)
                        <a href="{{ route('ebook.index', ['category' => $cat->slug]) }}" class="cat-dropdown-item">
                            <span>{{ $cat->name }}</span>
                        </a>
                    @endforeach
                @endif
            </div>
        </div>

        <a href="{{ route('authors.index') }}"
            class="cat-nav-item {{ request()->routeIs('authors.index') ? 'active' : '' }}">Penulis</a>
        <a href="{{ route('promo.index') }}"
            class="cat-nav-item {{ request()->routeIs('promo.index') ? 'active' : '' }}">Promo</a>
        <a href="{{ route('articles.index') }}"
            class="cat-nav-item {{ request()->routeIs('articles.index') ? 'active' : '' }}">Artikel</a>
        <a href="{{ route('about') }}"
            class="cat-nav-item {{ request()->routeIs('about') ? 'active' : '' }}">Tentang Kami</a>
    </nav>

    <!-- CONTENT PLACEHOLDER -->
    <main>
        @yield('content')
    </main>

    <!-- WA CONSULTATION & HELP BAR (ALAN DARI NEWSLETTER) -->
    <div class="newsletter-bar">
        <div class="newsletter-text">
            <div
                style="background: rgba(255,255,255,0.1); width: 48px; height: 48px; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                <i class="fa-brands fa-whatsapp" style="font-size: 1.8rem; color: #25D366;"></i>
            </div>
            <div>
                <h3 style="font-size: 1.05rem; font-weight: 800;">Butuh Rekomendasi Buku atau Bantuan Pemesanan?</h3>
                <p style="font-size: 0.78rem; opacity: 0.85;">Tim Customer Service IGAKERTA siap membantu Anda
                    menemukan buku favorit dan memandu transaksi.</p>
            </div>
        </div>
        <div>
            <a href="https://wa.me/6285124157382?text=Halo%20Admin%20IGAKERTA,%20saya%20butuh%20rekomendasi%20buku%20atau%20bantuan%20pemesanan."
                target="_blank" class="btn-subscribe">
                <i class="fa-brands fa-whatsapp" style="font-size: 1.1rem;"></i> Chat Admin WA
            </a>
        </div>
    </div>

    <!-- FOOTER -->
    <footer>
        <div class="footer-grid">
            <div>
                <div style="margin-bottom: 15px;">
                    <a href="{{ route('home') }}"
                        style="display: flex; align-items: center; gap: 10px; text-decoration: none;">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo IGAKERTA"
                            style="height: 45px; width: auto; object-fit: contain;">
                        <span
                            style="font-weight: 800; font-size: 1.2rem; color: white; line-height: 1.1; letter-spacing: -0.2px;">
                            IGAKERTA<br>
                            <small
                                style="font-size: 0.62rem; color: #E0A800; display: block; font-weight: 800; letter-spacing: 0.8px; margin-top: 1px;">BOOK
                                STORE</small>
                        </span>
                    </a>
                </div>
                <p style="opacity: 0.7; font-size: 0.78rem; line-height: 1.6;">Toko buku online resmi dari IGAKERTA
                    Publisher. Menyediakan ribuan buku berkualitas untuk mendukung pengembangan diri, akademik, dan
                    penelitian.</p>
                <div class="social-icons-footer">
                    <a href="https://facebook.com" target="_blank"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="https://instagram.com" target="_blank"><i class="fa-brands fa-instagram"></i></a>
                    <a href="https://youtube.com" target="_blank"><i class="fa-brands fa-youtube"></i></a>
                    <a href="https://tiktok.com" target="_blank"><i class="fa-brands fa-tiktok"></i></a>
                </div>
            </div>
            <div class="footer-col">
                <h4>Informasi</h4>
                <ul>
                    <li><a href="{{ route('about') }}">Tentang Kami</a></li>
                    <li><a href="{{ route('catalog.index') }}">Cara Belanja</a></li>
                    <li><a href="{{ route('promo.index') }}">Promo Terkini</a></li>
                    <li><a href="{{ route('articles.index') }}">Artikel Terbaru</a></li>
                    <li><a href="{{ route('about') }}">Kebijakan Privasi</a></li>
                    <li><a href="{{ route('about') }}">Syarat & Ketentuan</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Bantuan</h4>
                <ul>
                    <li><a href="{{ route('about') }}">FAQ</a></li>
                    <li><a href="{{ route('cart.index') }}">Lacak Pesanan</a></li>
                    <li><a href="{{ route('about') }}">Retur & Refund</a></li>
                    <li><a href="{{ route('about') }}">Kontak Kami</a></li>
                    <li><a href="{{ route('catalog.index') }}">Panduan Pembelian</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Kategori Populer</h4>
                <ul>
                    @if (isset($categories) && count($categories) > 0)
                        @foreach ($categories->take(5) as $c)
                            <li><a
                                    href="{{ route('catalog.index', ['category' => $c->slug]) }}">{{ $c->name }}</a>
                            </li>
                        @endforeach
                    @else
                        <li><a href="{{ route('catalog.index') }}">Buku Ajar</a></li>
                        <li><a href="{{ route('catalog.index') }}">Referensi Akademik</a></li>
                        <li><a href="{{ route('catalog.index') }}">Monograf</a></li>
                        <li><a href="{{ route('catalog.index') }}">Hasil Penelitian</a></li>
                    @endif
                </ul>
            </div>
            <div class="footer-col">
                <h4>Kontak Kami</h4>
                <ul style="line-height: 1.6;">
                    <li><i class="fa-solid fa-location-dot" style="margin-right: 6px;"></i> Jl. Melati No. 25, Depok,
                        Jawa Barat, Indonesia</li>
                    <li><i class="fa-solid fa-phone" style="margin-right: 6px;"></i> 0812-2456-7890</li>
                    <li><i class="fa-solid fa-envelope" style="margin-right: 6px;"></i> info@igakerta.com</li>
                    <li><i class="fa-regular fa-clock" style="margin-right: 6px;"></i> Senin - Sabtu: 08.00 - 17.00
                        WIB</li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <div>© 2026 IGAKERTA Publisher. All rights reserved.</div>
            <div style="display: flex; gap: 10px; align-items: center;">
                <span style="font-weight: 800; font-style: italic;">VISA</span>
                <span style="font-weight: 800; font-style: italic;">mastercard</span>
                <span style="font-weight: 800; color: #005E9E;">BCA</span>
                <span style="font-weight: 800; color: #003366;">mandırı</span>
                <span style="font-weight: 800; color: #006699;">BRI</span>
                <span style="font-weight: 800; color: #ED1C24;">QRIS</span>
            </div>
        </div>
    </footer>

    <a href="#" class="scroll-top-btn"><i class="fa-solid fa-arrow-up"></i></a>

    <!-- Bootstrap JS (Diperlukan agar komponen interaktif Bootstrap seperti alert dismiss berjalan) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- SCRIPT AUTO-FIX PERBAIKAN URL GAMBAR -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Otomatis memperbaiki semua gambar di halaman yang salah memanggil folder /storage/images/
            document.querySelectorAll('img').forEach(function(img) {
                if (img.src && img.src.includes('/storage/images/')) {
                    img.src = img.src.replace('/storage/images/', '/images/');
                }
            });
        });
    </script>

    @stack('scripts')
</body>

</html>
