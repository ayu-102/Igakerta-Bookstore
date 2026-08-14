@extends('layouts.app')

@section('title', 'Dashboard Pembeli - IGAKERTA Book Store')

@push('styles')
    <style>
        body,
        html {
            background-color: #F8FAFC;
            margin: 0;
            padding: 0;
            width: 100%;
            overflow-x: hidden;
        }

        .dashboard-container {
            width: 100%;
            max-width: 100%;
            margin: 24px 0 40px 0;
            padding: 0 32px;
            box-sizing: border-box;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: 260px 1fr;
            gap: 28px;
            align-items: start;
            width: 100%;
        }

        @media (max-width: 992px) {
            .dashboard-container {
                padding: 0 16px;
            }

            .dashboard-grid {
                grid-template-columns: 1fr;
            }
        }

        .sidebar-card {
            background: #FFFFFF;
            border-radius: 12px;
            padding: 16px;
            border: 1px solid #E2E8F0;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-menu li {
            margin-bottom: 4px;
        }

        .sidebar-menu a,
        .sidebar-menu button {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 0.82rem;
            font-weight: 600;
            color: #334155;
            text-decoration: none;
            transition: all 0.2s;
            width: 100%;
            border: none;
            background: transparent;
            text-align: left;
            cursor: pointer;
        }

        .sidebar-menu a:hover {
            background-color: #F1F5F9;
            color: #23085A;
        }

        .sidebar-menu a.active {
            background-color: #23085A;
            color: #FFFFFF;
        }

        .sidebar-menu a i,
        .sidebar-menu button i {
            font-size: 0.9rem;
            width: 18px;
        }

        .sidebar-divider {
            height: 1px;
            background-color: #E2E8F0;
            margin: 12px 0;
        }

        .logout-btn {
            color: #EF4444 !important;
        }

        .logout-btn:hover {
            background-color: #FEF2F2 !important;
        }

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .dashboard-title {
            font-size: 1.5rem;
            font-weight: 800;
            color: #0F172A;
            margin: 0;
        }

        .dashboard-welcome {
            font-size: 0.85rem;
            color: #64748B;
            margin-top: 4px;
        }

        .last-login {
            font-size: 0.75rem;
            color: #64748B;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 16px;
            margin-bottom: 24px;
            width: 100%;
        }

        @media (max-width: 1200px) {
            .stats-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 640px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .stat-card {
            border-radius: 14px;
            padding: 18px 16px;
            display: flex;
            align-items: center;
            gap: 14px;
            border: 1px solid transparent;
        }

        .stat-purple {
            background: #F4EFFC;
            border-color: #E9D5FF;
        }

        .stat-green {
            background: #E8FADF;
            border-color: #DCFCE7;
        }

        .stat-amber {
            background: #FFF8E6;
            border-color: #FEF3C7;
        }

        .stat-blue {
            background: #EBF8FF;
            border-color: #E0F2FE;
        }

        .stat-indigo {
            background: #EEF2FF;
            border-color: #E0E7FF;
        }

        .stat-icon {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            flex-shrink: 0;
            background: #FFFFFF;
        }

        .stat-purple .stat-icon {
            color: #23085A;
        }

        .stat-green .stat-icon {
            color: #16A34A;
        }

        .stat-amber .stat-icon {
            color: #D97706;
        }

        .stat-blue .stat-icon {
            color: #0284C7;
        }

        .stat-indigo .stat-icon {
            color: #4F46E5;
        }

        .stat-info span {
            font-size: 0.72rem;
            color: #64748B;
            display: block;
            font-weight: 500;
        }

        .stat-info h3 {
            font-size: 1.4rem;
            font-weight: 800;
            color: #0F172A;
            margin: 2px 0 4px 0;
        }

        .stat-link {
            font-size: 0.72rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .stat-purple .stat-link {
            color: #23085A;
        }

        .stat-green .stat-link {
            color: #16A34A;
        }

        .stat-amber .stat-link {
            color: #D97706;
        }

        .stat-blue .stat-link {
            color: #0284C7;
        }

        .stat-indigo .stat-link {
            color: #4F46E5;
        }

        .content-body-grid {
            display: grid;
            grid-template-columns: 1.3fr 0.7fr;
            gap: 24px;
            width: 100%;
        }

        @media (max-width: 1024px) {
            .content-body-grid {
                grid-template-columns: 1fr;
            }
        }

        .card-box {
            background: #FFFFFF;
            border-radius: 12px;
            padding: 20px;
            border: 1px solid #E2E8F0;
            margin-bottom: 24px;
        }

        .card-box-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
        }

        .card-box-title {
            font-size: 0.98rem;
            font-weight: 800;
            color: #0F172A;
            margin: 0;
        }

        .link-view-all {
            font-size: 0.75rem;
            font-weight: 600;
            color: #23085A;
            text-decoration: none;
        }

        .order-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 0;
            border-bottom: 1px solid #F1F5F9;
        }

        .order-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .order-item:first-child {
            padding-top: 0;
        }

        .order-book-details {
            display: flex;
            gap: 14px;
            align-items: center;
        }

        .order-book-cover {
            width: 52px;
            height: 72px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid #E2E8F0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .order-book-title-wrapper {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .order-book-info h4 {
            font-size: 0.85rem;
            font-weight: 700;
            color: #0F172A;
            margin: 0;
        }

        .order-book-info p {
            font-size: 0.74rem;
            color: #64748B;
            margin: 3px 0 6px 0;
        }

        .order-meta {
            font-size: 0.72rem;
            color: #94A3B8;
        }

        .status-badge {
            font-size: 0.65rem;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 12px;
            display: inline-block;
            text-transform: capitalize;
        }

        .badge-selesai,
        .badge-completed {
            background: #F0FDF4;
            color: #16A34A;
        }

        .badge-dikirim,
        .badge-shipped {
            background: #F0F9FF;
            color: #0284C7;
        }

        .badge-diproses,
        .badge-pending,
        .badge-paid {
            background: #FFFBEB;
            color: #D97706;
        }

        .order-right {
            text-align: right;
        }

        .order-price {
            font-size: 0.88rem;
            font-weight: 800;
            color: #0F172A;
            margin-bottom: 8px;
        }

        .btn-detail {
            font-size: 0.72rem;
            padding: 5px 12px;
            border: 1px solid #E2E8F0;
            border-radius: 6px;
            color: #334155;
            text-decoration: none;
            font-weight: 600;
            background: #FFFFFF;
            transition: all 0.2s;
        }

        .btn-detail:hover {
            background: #F8FAFC;
            border-color: #CBD5E1;
        }

        .banner-community {
            background: #FAF5FF;
            border-radius: 12px;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            border: 1px solid #F3E8FF;
        }

        .banner-content {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .banner-icon {
            font-size: 2.2rem;
            color: #23085A;
        }

        .banner-text h5 {
            font-size: 0.88rem;
            font-weight: 800;
            color: #0F172A;
            margin: 0 0 3px 0;
        }

        .banner-text p {
            font-size: 0.72rem;
            color: #64748B;
            margin: 0;
            line-height: 1.4;
        }

        .btn-banner {
            background: #23085A;
            color: #FFFFFF;
            padding: 9px 16px;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 700;
            text-decoration: none;
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: background 0.2s;
        }

        .btn-banner:hover {
            background: #1A0644;
            color: #FFFFFF;
        }

        .summary-list {
            list-style: none;
            padding: 0;
            margin: 0 0 16px 0;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            font-size: 0.8rem;
            padding: 8px 0;
            color: #475569;
        }

        .summary-item strong {
            color: #0F172A;
            font-weight: 700;
        }

        .summary-item.discount strong {
            color: #16A34A;
        }

        .btn-shop-now {
            display: block;
            width: 100%;
            background: #23085A;
            color: #FFFFFF;
            text-align: center;
            padding: 10px;
            border-radius: 8px;
            font-size: 0.82rem;
            font-weight: 700;
            text-decoration: none;
            transition: background 0.2s;
        }

        .btn-shop-now:hover {
            background: #1A0644;
        }

        .recommendation-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            width: 100%;
        }

        .book-card-mini {
            text-align: center;
        }

        .book-card-mini img {
            width: 100%;
            height: 130px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid #E2E8F0;
            margin-bottom: 8px;
        }

        .book-card-mini h5 {
            font-size: 0.72rem;
            font-weight: 700;
            color: #0F172A;
            margin: 0 0 3px 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .book-card-mini .price {
            font-size: 0.75rem;
            font-weight: 800;
            color: #23085A;
            margin-bottom: 2px;
        }
    </style>
@endpush

@section('content')
    <div class="dashboard-container">
        <div class="dashboard-grid">

            <!-- SIDEBAR NAVIGASI TERHUBUNG -->
            <aside class="sidebar-card">
                <ul class="sidebar-menu">
                    <li>
                        <a href="{{ route('customer.dashboard') }}"
                            class="{{ request()->routeIs('customer.dashboard') ? 'active' : '' }}">
                            <i class="fa-solid fa-square-poll-vertical"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('customer.member.index') }}"
                            class="{{ request()->routeIs('customer.member.*') ? 'active' : '' }}">
                            <i class="fa-solid fa-id-card"></i>
                            <span>Member & Poin</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('customer.orders.index') }}"
                            class="{{ request()->routeIs('customer.orders.*') ? 'active' : '' }}">
                            <i class="fa-regular fa-clipboard"></i>
                            <span>Pesanan Saya</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('customer.ebooks') }}"
                            class="{{ request()->routeIs('customer.ebooks') ? 'active' : '' }}">
                            <i class="fa-solid fa-book-bookmark"></i>
                            <span>Ebook Saya</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('customer.addresses.index') }}"
                            class="{{ request()->routeIs('customer.addresses.*') ? 'active' : '' }}">
                            <i class="fa-solid fa-location-dot"></i>
                            <span>Alamat Pengiriman</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('customer.vouchers') }}"
                            class="{{ request()->routeIs('customer.vouchers') ? 'active' : '' }}">
                            <i class="fa-solid fa-ticket"></i>
                            <span>Voucher Saya</span>
                        </a>
                    </li>

                    <div class="sidebar-divider"></div>

                    <li>
                        <a href="{{ route('customer.profile.edit') }}"
                            class="{{ request()->routeIs('customer.profile.*') ? 'active' : '' }}">
                            <i class="fa-regular fa-user"></i>
                            <span>Akun Saya</span>
                        </a>
                    </li>

                    <div class="sidebar-divider"></div>

                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="logout-btn">
                                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                <span>Keluar</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </aside>

            <!-- KONTEN UTAMA DASHBOARD -->
            <main>
                <!-- HEADER WELCOME & WAKTU LOGIN -->
                <div class="dashboard-header">
                    <div>
                        <h1 class="dashboard-title">Dashboard</h1>
                        <p class="dashboard-welcome">Selamat datang kembali, {{ Auth::user()->name }} 👋</p>
                    </div>
                    <div class="last-login">
                        Terakhir login:
                        {{ Auth::user()->last_login_at ? \Carbon\Carbon::parse(Auth::user()->last_login_at)->translatedFormat('d M Y H:i') . ' WIB' : 'Baru saja' }}
                    </div>
                </div>

                <!-- WIDGET STATISTIK DINAMIS -->
                <div class="stats-grid">
                    <div class="stat-card stat-purple">
                        <div class="stat-icon"><i class="fa-solid fa-bag-shopping"></i></div>
                        <div class="stat-info">
                            <span>Total Pesanan</span>
                            <h3>{{ $totalOrders }}</h3>
                            <a href="{{ route('customer.orders.index') }}" class="stat-link">Lihat semua pesanan <i
                                    class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    </div>

                    <div class="stat-card stat-green">
                        <div class="stat-icon"><i class="fa-solid fa-circle-check"></i></div>
                        <div class="stat-info">
                            <span>Pesanan Selesai</span>
                            <h3>{{ $completedOrders }}</h3>
                            <a href="{{ route('customer.orders.index') }}" class="stat-link">Lihat riwayat <i
                                    class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    </div>

                    <div class="stat-card stat-amber">
                        <div class="stat-icon"><i class="fa-solid fa-book-open"></i></div>
                        <div class="stat-info">
                            <span>Ebook Saya</span>
                            <h3>{{ $myEbooksCount }}</h3>
                            <a href="{{ route('customer.ebooks') }}" class="stat-link">Lihat koleksi <i
                                    class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    </div>

                    <div class="stat-card stat-blue">
                        <div class="stat-icon"><i class="fa-regular fa-heart"></i></div>
                        <div class="stat-info">
                            <span>Wishlist</span>
                            <h3>{{ $wishlistCount }}</h3>
                            <a href="{{ route('wishlist.index') }}" class="stat-link">Lihat wishlist <i
                                    class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    </div>

                    <div class="stat-card stat-indigo">
                        <div class="stat-icon"><i class="fa-solid fa-percent"></i></div>
                        <div class="stat-info">
                            <span>Voucher Aktif</span>
                            <h3>{{ $activeVouchersCount }}</h3>
                            <a href="{{ route('customer.vouchers') }}" class="stat-link">Lihat voucher <i
                                    class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <!-- DUA KOLOM: PESANAN TERAKHIR & RINGKASAN BELANJA -->
                <div class="content-body-grid">

                    <!-- KOLOM KIRI: PESANAN TERAKHIR & BANNER PENERBITAN -->
                    <div>
                        <div class="card-box">
                            <div class="card-box-header">
                                <h3 class="card-box-title">Pesanan Terakhir</h3>
                                <a href="{{ route('customer.orders.index') }}" class="link-view-all">Lihat Semua</a>
                            </div>

                            @forelse($latestOrders as $order)
                                @php $firstItem = $order->items->first(); @endphp
                                <div class="order-item">
                                    <div class="order-book-details">
                                        <img src="{{ $firstItem && $firstItem->book && $firstItem->book->cover_image ? asset('storage/' . $firstItem->book->cover_image) : 'https://placehold.co/100x140/23085A/FFFFFF/png?text=Buku' }}"
                                            class="order-book-cover" alt="Cover">
                                        <div class="order-book-info">
                                            <div class="order-book-title-wrapper">
                                                <h4>{{ $firstItem ? $firstItem->book_title : 'Pesanan #' . $order->order_number }}
                                                </h4>
                                                <span
                                                    class="status-badge badge-{{ strtolower($order->status) }}">{{ $order->status }}</span>
                                            </div>
                                            <p>{{ $firstItem && $firstItem->book && $firstItem->book->author ? $firstItem->book->author->name : 'IGAKERTA' }}
                                            </p>
                                            <div class="order-meta">No. Pesanan: {{ $order->order_number }} &bull;
                                                {{ $order->created_at->format('d M Y') }}</div>
                                        </div>
                                    </div>
                                    <div class="order-right">
                                        <div class="order-price">Rp {{ number_format($order->grand_total, 0, ',', '.') }}
                                        </div>
                                        <a href="#" class="btn-detail">Lihat Detail</a>
                                    </div>
                                </div>
                            @empty
                                <div style="text-align: center; padding: 20px 0; color: #64748B; font-size: 0.85rem;">
                                    Belum ada transaksi pesanan.
                                </div>
                            @endforelse
                        </div>

                        <!-- BANNER PENERBITAN BUKU (OPSI 2) -->
                        <div class="banner-community">
                            <div class="banner-content">
                                <i class="fa-solid fa-book-bookmark banner-icon"></i>
                                <div class="banner-text">
                                    <h5>Punya Naskah & Ingin Diterbitkan?</h5>
                                    <p>Terbitkan buku ajar, monograf, atau karya ilmiah Anda secara profesional bersama
                                        Penerbit IGAKERTA.</p>
                                </div>
                            </div>
                            <a href="https://wa.me/6285124157382?text=Halo%20Admin%20IGAKERTA,%20saya%20inikgin%20konsultasi%20menerbitkan%20buku."
                                target="_blank" class="btn-banner">
                                <i class="fa-brands fa-whatsapp"></i> Konsultasi Penerbitan
                            </a>
                        </div>
                    </div>

                    <!-- KOLOM KANAN: RINGKASAN & REKOMENDASI -->
                    <div>
                        <!-- RINGKASAN BELANJA DINAMIS -->
                        <div class="card-box">
                            <h3 class="card-box-title" style="margin-bottom: 14px;">Ringkasan Belanja</h3>
                            <ul class="summary-list">
                                <li class="summary-item">
                                    <span>Total Belanja</span>
                                    <strong>Rp {{ number_format($totalSpent, 0, ',', '.') }}</strong>
                                </li>
                                <li class="summary-item discount">
                                    <span>Total Penghematan</span>
                                    <strong>Rp {{ number_format($totalDiscount, 0, ',', '.') }}</strong>
                                </li>
                                <li class="summary-item">
                                    <span>Buku yang Dibeli</span>
                                    <strong>{{ $physicalBooksBought }}</strong>
                                </li>
                                <li class="summary-item">
                                    <span>Ebook yang Dibeli</span>
                                    <strong>{{ $myEbooksCount }}</strong>
                                </li>
                            </ul>
                            <a href="{{ route('catalog.index') }}" class="btn-shop-now">Belanja Sekarang</a>
                        </div>

                        <!-- REKOMENDASI BUKU DINAMIS -->
                        <div class="card-box">
                            <div class="card-box-header">
                                <h3 class="card-box-title">Rekomendasi untuk Anda</h3>
                                <a href="{{ route('catalog.index') }}" class="link-view-all">Lihat Semua</a>
                            </div>

                            <div class="recommendation-grid">
                                @foreach ($recommendedBooks as $book)
                                    <div class="book-card-mini">
                                        <a href="{{ route('books.show', $book->id) }}"
                                            style="text-decoration: none; color: inherit;">
                                            <img src="{{ $book->cover_image ? asset('storage/' . $book->cover_image) : 'https://placehold.co/120x160/23085A/FFFFFF/png?text=Buku' }}"
                                                alt="{{ $book->title }}">
                                            <h5>{{ $book->title }}</h5>
                                            <div class="price">Rp {{ number_format($book->price, 0, ',', '.') }}</div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>
            </main>

        </div>
    </div>
@endsection
