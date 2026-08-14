<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - IGAKERTA Book Store</title>

    <!-- Google Fonts & FontAwesome & Chart.js -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @stack('styles')
    <style>
        :root {
            --primary-dark: #18003C;
            --primary-medium: #23085A;
            --accent-yellow: #FFC000;
            --bg-body: #F8FAFC;
            --card-bg: #FFFFFF;
            --text-main: #1E293B;
            --text-muted: #64748B;
            --border-color: #E2E8F0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            display: flex;
            background-color: var(--bg-body);
            color: var(--text-main);
            min-height: 100vh;
        }

        /* SIDEBAR DESIGN */
        .sidebar {
            width: 250px;
            height: 100vh;
            position: sticky;
            top: 0;
            background: #FFFFFF;
            border-right: 1px solid var(--border-color);
            padding: 20px 16px;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .sidebar-menu-wrapper {
            overflow-y: auto;
            flex-grow: 1;
            padding-right: 4px;
        }

        /* Custom Scrollbar Tipis */
        .sidebar-menu-wrapper::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-menu-wrapper::-webkit-scrollbar-thumb {
            background: #CBD5E1;
            border-radius: 10px;
        }

        .sidebar-menu-wrapper::-webkit-scrollbar-track {
            background: transparent;
        }

        /* LOGO BRAND SIDEBAR */
        .brand-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 4px 20px 4px;
        }

        .brand-text {
            font-size: 1.05rem;
            font-weight: 800;
            color: var(--primary-dark);
            line-height: 1.1;
        }

        .brand-text span {
            display: block;
            font-size: 0.68rem;
            color: var(--text-muted);
            font-weight: 600;
            letter-spacing: 0.5px;
            margin-top: 1px;
        }

        .nav-section {
            font-size: 0.68rem;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: var(--text-muted);
            font-weight: 700;
            margin: 18px 8px 8px 8px;
        }

        .sidebar-nav {
            list-style: none;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #475569;
            text-decoration: none;
            padding: 10px 12px;
            border-radius: 8px;
            font-size: 0.83rem;
            font-weight: 600;
            margin-bottom: 2px;
            transition: all 0.2s;
        }

        .sidebar-nav a:hover {
            background: #F1F5F9;
            color: var(--primary-medium);
        }

        .sidebar-nav a.active {
            background: var(--primary-medium);
            color: #FFFFFF;
        }

        .sidebar-nav a.active i {
            color: var(--accent-yellow);
        }

        .sidebar-nav i {
            font-size: 0.95rem;
            width: 18px;
            text-align: center;
        }

        .btn-logout-sidebar {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            padding: 10px 12px;
            border-radius: 8px;
            background: #FEF2F2;
            color: #EF4444;
            border: none;
            font-size: 0.83rem;
            font-weight: 700;
            cursor: pointer;
        }

        /* MAIN AREA & TOPBAR */
        .main-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            overflow-x: hidden;
        }

        .topbar {
            height: 65px;
            background: #FFFFFF;
            border-bottom: 1px solid var(--border-color);
            padding: 0 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .search-bar-top {
            display: flex;
            align-items: center;
            background: #F1F5F9;
            border-radius: 8px;
            padding: 4px 6px 4px 12px;
            width: 420px;
        }

        .search-bar-top input {
            border: none;
            background: transparent;
            outline: none;
            width: 100%;
            font-size: 0.82rem;
        }

        .search-bar-top select {
            border: none;
            background: transparent;
            font-size: 0.78rem;
            color: var(--text-muted);
            outline: none;
            padding-right: 8px;
        }

        .search-bar-top button {
            background: var(--primary-medium);
            color: white;
            border: none;
            width: 32px;
            height: 32px;
            border-radius: 6px;
            cursor: pointer;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .topbar-user {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .avatar-user {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
        }

        .main-content {
            padding: 25px 30px;
            flex: 1;
        }

        /* FOOTER ADMIN UNGU SESUAI TEMA */
        .admin-footer {
            background: var(--primary-dark);
            color: rgba(255, 255, 255, 0.8);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding: 16px 30px;
            margin-top: auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.813rem;
        }

        .admin-footer-brand {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .admin-footer-brand strong {
            color: #FFFFFF;
        }

        .admin-footer-logo {
            height: 28px;
            width: auto;
            object-fit: contain;
        }

        .admin-footer-links {
            display: flex;
            align-items: center;
            gap: 16px;
            color: rgba(255, 255, 255, 0.4);
        }

        .admin-footer-links a {
            color: rgba(255, 255, 255, 0.75);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }

        .admin-footer-links a:hover {
            color: var(--accent-yellow);
        }

        .version-badge {
            background: var(--primary-medium);
            color: var(--accent-yellow);
            padding: 3px 8px;
            border-radius: 6px;
            font-weight: 700;
            font-size: 0.72rem;
            border: 1px solid rgba(255, 192, 0, 0.2);
        }
    </style>
</head>

<body>
    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-menu-wrapper">
            <div class="brand-logo">
                <img src="{{ asset('images/logo.png') }}" style="height: 40px; width: auto;" alt="Logo IGAKERTA">
                <div class="brand-text">
                    IGAKERTA
                    <span>BOOK STORE</span>
                </div>
            </div>

            <div class="nav-section">UTAMA</div>
            <ul class="sidebar-nav">
                <li>
                    <a href="{{ route('admin.dashboard') }}"
                        class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fa-solid fa-chart-line"></i> Dashboard
                    </a>
                </li>
            </ul>

            <div class="nav-section">KATALOG</div>
            <ul class="sidebar-nav">
                <li>
                    <a href="{{ route('admin.books.index') }}"
                        class="{{ request()->routeIs('admin.books.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-book"></i> Buku & Ebook
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.categories.index') }}"
                        class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-layer-group"></i> Kategori
                    </a>
                </li>
            </ul>

            <div class="nav-section">TRANSAKSI</div>
            <ul class="sidebar-nav">
                <li>
                    <a href="{{ route('admin.orders.index') }}"
                        class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-cart-shopping"></i> Pesanan
                    </a>
                </li>
            </ul>

            <div class="nav-section">PROMOSI</div>
            <ul class="sidebar-nav">
                <li>
                    <a href="{{ route('admin.promos.index') }}"
                        class="{{ request()->routeIs('admin.promos.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-percent"></i> Promo & Diskon
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.vouchers.index') }}"
                        class="{{ request()->routeIs('admin.vouchers.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-ticket"></i> Voucher
                    </a>
                </li>
            </ul>

            <div class="nav-section">KONTEN</div>
            <ul class="sidebar-nav">
                <li>
                    <a href="{{ route('admin.articles.index') }}"
                        class="{{ request()->routeIs('admin.articles.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-newspaper"></i> Kelola Artikel
                    </a>
                </li>
            </ul>

            <div class="nav-section">PENGGUNA</div>
            <ul class="sidebar-nav">
                <li>
                    <a href="{{ route('admin.customers.index') }}"
                        class="{{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-users"></i> Pelanggan
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.members.index') }}"
                        class="{{ request()->routeIs('admin.members.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-id-card"></i> Member & Poin
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.admins.index') }}"
                        class="{{ request()->routeIs('admin.admins.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-user-shield"></i> Kelola Admin
                    </a>
                </li>
            </ul>

            <div class="nav-section">SISTEM</div>
            <ul class="sidebar-nav">
                <li>
                    <a href="{{ route('admin.reports.index') }}"
                        class="{{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-chart-pie"></i> Laporan
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.settings.index') }}"
                        class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-sliders"></i> Pengaturan
                    </a>
                </li>
            </ul>

            <!-- BUTTON KELUAR -->
            <div style="padding-top: 12px; border-top: 1px solid var(--border-color);">
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-logout-sidebar">
                        <i class="fa-solid fa-power-off"></i> Keluar
                    </button>
                </form>
            </div>
    </aside>

    <!-- MAIN WRAPPER -->
    <div class="main-wrapper">
        <!-- TOPBAR -->
        <header class="topbar">
            <div class="search-bar-top">

            </div>

            <div class="topbar-right">


                <div class="topbar-user">
                    <img src="https://ui-avatars.com/api/?name=Admin+Igakerta&background=23085A&color=fff"
                        alt="Avatar" class="avatar-user">
                    <div>
                        <div style="font-size: 0.82rem; font-weight: 700; color: #1E293B;">Admin Igakerta</div>
                        <div style="font-size: 0.68rem; color: #64748B;">Super Admin</div>
                    </div>
                </div>
            </div>
        </header>

        <!-- MAIN CONTENT -->
        <main class="main-content">
            @yield('content')
        </main>

        <!-- FOOTER ADMIN UNGU -->
        <footer class="admin-footer">
            <div class="admin-footer-brand">
                <img src="{{ asset('images/logo.png') }}" class="admin-footer-logo" alt="Logo Igakerta">
                <div>
                    &copy; {{ date('Y') }} <strong>IGAKERTA Publisher</strong>. All rights reserved.
                </div>
            </div>
            <div class="admin-footer-links">
                <a href="#">Dokumentasi</a>
                <span>•</span>
                <a href="#">Bantuan Sistem</a>
                <span>•</span>
                <span class="version-badge">v1.0.0</span>
            </div>
        </footer>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
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
