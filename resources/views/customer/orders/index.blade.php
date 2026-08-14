@extends('layouts.app')

@section('title', 'Pesanan Saya - IGAKERTA Book Store')

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

        /* SIDEBAR STYLING */
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

        /* HEADER & CARD BOX STYLING */
        .dashboard-header {
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

        .card-box {
            background: #FFFFFF;
            border-radius: 12px;
            padding: 20px;
            border: 1px solid #E2E8F0;
            margin-bottom: 24px;
        }

        /* FILTER STATUS & FILTER SEARCH */
        .order-filter-btn {
            font-size: 0.78rem;
            font-weight: 600;
            color: #475569;
            background: #F8FAFC;
            border: 1px solid #E2E8F0;
            padding: 6px 14px;
            border-radius: 20px;
            text-decoration: none;
            transition: all 0.2s;
            display: inline-block;
        }

        .order-filter-btn:hover {
            background: #F1F5F9;
            color: #23085A;
        }

        .order-filter-btn.active {
            background: #23085A;
            color: #FFFFFF;
            border-color: #23085A;
        }

        .search-input-group {
            display: flex;
            gap: 6px;
        }

        .search-input-group input {
            font-size: 0.82rem;
            border-radius: 8px;
            border: 1px solid #CBD5E1;
            padding: 6px 12px;
        }

        .search-input-group input:focus {
            border-color: #23085A;
            box-shadow: 0 0 0 2px rgba(35, 8, 90, 0.1);
        }

        .btn-purple-search {
            background: #23085A;
            color: #FFFFFF;
            border-radius: 8px;
            border: none;
            padding: 0 14px;
            font-size: 0.82rem;
            transition: background 0.2s;
        }

        .btn-purple-search:hover {
            background: #1A0644;
            color: #FFFFFF;
        }

        /* LIST PESANAN STYLING */
        .order-card-item {
            border: 1px solid #E2E8F0;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 16px;
            background: #FFFFFF;
            transition: border-color 0.2s;
        }

        .order-card-item:hover {
            border-color: #CBD5E1;
        }

        .order-card-header {
            background: #F8FAFC;
            padding: 10px 16px;
            border-bottom: 1px solid #E2E8F0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .order-number {
            font-size: 0.85rem;
            font-weight: 700;
            color: #0F172A;
        }

        .order-date {
            font-size: 0.75rem;
            color: #64748B;
            margin-left: 8px;
        }

        .order-card-body {
            padding: 16px;
        }

        .order-product-item {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 12px;
        }

        .order-product-item:last-child {
            margin-bottom: 0;
        }

        .order-cover-img {
            width: 48px;
            height: 68px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid #E2E8F0;
        }

        .order-product-title {
            font-size: 0.85rem;
            font-weight: 700;
            color: #0F172A;
            margin: 0 0 2px 0;
        }

        .order-product-qty {
            font-size: 0.75rem;
            color: #64748B;
        }

        .order-product-price {
            font-size: 0.85rem;
            font-weight: 700;
            color: #23085A;
        }

        /* STATUS BADGES */
        .status-badge {
            font-size: 0.7rem;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 12px;
            display: inline-block;
        }

        .badge-pending {
            background: #FFFBEB;
            color: #D97706;
        }

        .badge-paid {
            background: #F0F9FF;
            color: #0284C7;
        }

        .badge-shipped {
            background: #EEF2FF;
            color: #4F46E5;
        }

        .badge-completed,
        .badge-selesai {
            background: #F0FDF4;
            color: #16A34A;
        }

        .badge-cancelled {
            background: #FEF2F2;
            color: #EF4444;
        }

        /* FOOTER ORDER CARD */
        .order-card-footer {
            border-top: 1px solid #F1F5F9;
            padding-top: 12px;
            margin-top: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .total-price-label {
            font-size: 0.72rem;
            color: #64748B;
            display: block;
        }

        .total-price-amount {
            font-size: 0.95rem;
            font-weight: 800;
            color: #0F172A;
            margin: 0;
        }

        .btn-pay-now {
            font-size: 0.75rem;
            font-weight: 700;
            padding: 6px 16px;
            border: 1px solid #D97706;
            background: #D97706;
            color: #FFFFFF;
            border-radius: 20px;
            transition: all 0.2s;
            cursor: pointer;
        }

        .btn-pay-now:hover {
            background: #B45309;
            color: #FFFFFF;
        }

        .btn-detail-order {
            font-size: 0.75rem;
            font-weight: 700;
            padding: 6px 16px;
            border: 1px solid #23085A;
            color: #23085A;
            border-radius: 20px;
            text-decoration: none;
            background: transparent;
            transition: all 0.2s;
        }

        .btn-detail-order:hover {
            background: #23085A;
            color: #FFFFFF;
        }

        .btn-review-order {
            font-size: 0.75rem;
            font-weight: 700;
            padding: 6px 16px;
            border: 1px solid #16A34A;
            background: #16A34A;
            color: #FFFFFF;
            border-radius: 20px;
            transition: all 0.2s;
        }

        .btn-review-order:hover {
            background: #15803D;
            color: #FFFFFF;
        }

        /* STYLING BINTANG RATING */
        .star-rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: flex-end;
            gap: 4px;
        }

        .star-rating input {
            display: none;
        }

        .star-rating label {
            font-size: 1.4rem;
            color: #CBD5E1;
            cursor: pointer;
            transition: color 0.2s;
        }

        .star-rating input:checked~label,
        .star-rating label:hover,
        .star-rating label:hover~label {
            color: #F59E0B;
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

            <!-- KONTEN UTAMA PESANAN SAYA -->
            <main>
                <div class="dashboard-header">
                    <h1 class="dashboard-title">Pesanan Saya</h1>
                    <p class="dashboard-welcome">Kelola dan pantau status transaksi pemesanan buku Anda.</p>
                </div>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                        <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card-box">
                    <!-- FILTER STATUS & PENCARIAN -->
                    <form action="{{ route('customer.orders.index') }}" method="GET" class="mb-4">
                        <div class="row g-3 align-items-center">
                            <div class="col-lg-8">
                                <div class="d-flex flex-wrap gap-2">
                                    <a href="{{ route('customer.orders.index', ['status' => 'all']) }}"
                                        class="order-filter-btn {{ request('status', 'all') == 'all' ? 'active' : '' }}">
                                        Semua ({{ $counts['all'] ?? 0 }})
                                    </a>
                                    <a href="{{ route('customer.orders.index', ['status' => 'pending']) }}"
                                        class="order-filter-btn {{ request('status') == 'pending' ? 'active' : '' }}">
                                        Menunggu ({{ $counts['pending'] ?? 0 }})
                                    </a>
                                    <a href="{{ route('customer.orders.index', ['status' => 'paid']) }}"
                                        class="order-filter-btn {{ request('status') == 'paid' ? 'active' : '' }}">
                                        Dibayar ({{ $counts['paid'] ?? 0 }})
                                    </a>
                                    <a href="{{ route('customer.orders.index', ['status' => 'shipped']) }}"
                                        class="order-filter-btn {{ request('status') == 'shipped' ? 'active' : '' }}">
                                        Dikirim ({{ $counts['shipped'] ?? 0 }})
                                    </a>
                                    <a href="{{ route('customer.orders.index', ['status' => 'completed']) }}"
                                        class="order-filter-btn {{ request('status') == 'completed' ? 'active' : '' }}">
                                        Selesai ({{ $counts['completed'] ?? 0 }})
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="search-input-group">
                                    <input type="text" name="search" class="form-control"
                                        placeholder="Cari No. Pesanan..." value="{{ request('search') }}">
                                    <button class="btn-purple-search" type="submit">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- DAFTAR PESANAN -->
                    @if ($orders->count() > 0)
                        @foreach ($orders as $order)
                            <div class="order-card-item">
                                <div class="order-card-header">
                                    <div>
                                        <span class="order-number">#{{ $order->order_number }}</span>
                                        <span class="order-date"><i
                                                class="fa-regular fa-clock me-1"></i>{{ $order->created_at->format('d M Y, H:i') }}</span>
                                    </div>
                                    <div>
                                        @if ($order->status == 'pending')
                                            <span class="status-badge badge-pending">Menunggu Pembayaran</span>
                                        @elseif($order->status == 'paid')
                                            <span class="status-badge badge-paid">Diproses</span>
                                        @elseif($order->status == 'shipped')
                                            <span class="status-badge badge-shipped">Dikirim</span>
                                        @elseif(in_array($order->status, ['completed', 'selesai']))
                                            <span class="status-badge badge-completed">Selesai</span>
                                        @else
                                            <span class="status-badge badge-cancelled">Dibatalkan</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="order-card-body">
                                    @foreach ($order->items as $item)
                                        <div class="order-product-item">
                                            <img src="{{ $item->book && $item->book->cover_image ? asset('storage/' . $item->book->cover_image) : 'https://placehold.co/100x140/23085A/FFFFFF/png?text=Buku' }}"
                                                alt="{{ $item->book->title ?? 'Buku' }}" class="order-cover-img">
                                            <div class="flex-grow-1">
                                                <h4 class="order-product-title">
                                                    {{ $item->book->title ?? ($item->book_title ?? 'Judul Buku Tidak Tersedia') }}
                                                </h4>
                                                <div class="order-product-qty">
                                                    {{ $item->quantity }}x @ Rp
                                                    {{ number_format($item->price, 0, ',', '.') }}
                                                </div>
                                            </div>
                                            <div class="text-end order-product-price">
                                                Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                            </div>
                                        </div>
                                    @endforeach

                                    <div class="order-card-footer">
                                        <div>
                                            <span class="total-price-label">Total Pembayaran</span>
                                            <h5 class="total-price-amount">Rp
                                                {{ number_format($order->grand_total, 0, ',', '.') }}</h5>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <!-- TOMBOL BAYAR SEKARANG (JIKA PENDING DAN MEMILIKI SNAP TOKEN) -->
                                            @if ($order->status == 'pending' && isset($order->snap_token))
                                                <button type="button" class="btn-pay-now"
                                                    onclick="payOrder('{{ $order->snap_token }}')">
                                                    <i class="fa-solid fa-wallet me-1"></i> Bayar Sekarang
                                                </button>
                                            @endif

                                            <!-- TOMBOL ULASAN (JIKA SELESAI) -->
                                            @if (in_array($order->status, ['completed', 'selesai']))
                                                <button type="button" class="btn btn-review-order" data-bs-toggle="modal"
                                                    data-bs-target="#reviewModal{{ $order->id }}">
                                                    <i class="fa-solid fa-star me-1"></i> Beri Ulasan
                                                </button>
                                            @endif

                                            <a href="{{ route('customer.orders.show', $order->id) }}"
                                                class="btn-detail-order">
                                                Detail Pesanan
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- MODAL ULASAN PESANAN -->
                            @if (in_array($order->status, ['completed', 'selesai']))
                                <div class="modal fade" id="reviewModal{{ $order->id }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content" style="border-radius: 12px; border: none;">
                                            <form action="{{ route('customer.reviews.store', $order->id) }}"
                                                method="POST">
                                                @csrf
                                                <div class="modal-header" style="border-bottom: 1px solid #E2E8F0;">
                                                    <h5 class="modal-title font-weight-bold"
                                                        style="font-size: 1.1rem; color: #0F172A;">
                                                        Beri Ulasan - Pesanan #{{ $order->order_number }}
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body p-4" style="max-height: 70vh; overflow-y: auto;">

                                                    <!-- 1. ULASAN PELAYANAN TOKO -->
                                                    <div class="p-3 mb-4"
                                                        style="background: #F8FAFC; border-radius: 10px; border: 1px solid #E2E8F0;">
                                                        <h6 class="fw-bold mb-2" style="color: #23085A;">
                                                            <i class="fa-solid fa-store me-2"></i> Rating Pelayanan Toko
                                                        </h6>
                                                        <p class="text-muted small mb-2">Bagaimana pengalaman belanja Anda
                                                            di toko kami?</p>

                                                        <div class="star-rating mb-3">
                                                            <input type="radio" id="store_star5_{{ $order->id }}"
                                                                name="store_rating" value="5" required />
                                                            <label for="store_star5_{{ $order->id }}"><i
                                                                    class="fa-solid fa-star"></i></label>
                                                            <input type="radio" id="store_star4_{{ $order->id }}"
                                                                name="store_rating" value="4" />
                                                            <label for="store_star4_{{ $order->id }}"><i
                                                                    class="fa-solid fa-star"></i></label>
                                                            <input type="radio" id="store_star3_{{ $order->id }}"
                                                                name="store_rating" value="3" />
                                                            <label for="store_star3_{{ $order->id }}"><i
                                                                    class="fa-solid fa-star"></i></label>
                                                            <input type="radio" id="store_star2_{{ $order->id }}"
                                                                name="store_rating" value="2" />
                                                            <label for="store_star2_{{ $order->id }}"><i
                                                                    class="fa-solid fa-star"></i></label>
                                                            <input type="radio" id="store_star1_{{ $order->id }}"
                                                                name="store_rating" value="1" />
                                                            <label for="store_star1_{{ $order->id }}"><i
                                                                    class="fa-solid fa-star"></i></label>
                                                        </div>

                                                        <textarea name="store_comment" class="form-control" rows="2"
                                                            placeholder="Tuliskan testimoni Anda tentang layanan toko..." style="font-size: 0.85rem; border-radius: 8px;"></textarea>
                                                    </div>

                                                    <!-- 2. ULASAN TIAP BUKU -->
                                                    <h6 class="fw-bold mb-3" style="color: #0F172A;">
                                                        <i class="fa-solid fa-book me-2"></i> Ulasan Produk Buku
                                                    </h6>

                                                    @foreach ($order->items as $item)
                                                        @if ($item->book_id)
                                                            <div class="mb-4 pb-3 border-bottom">
                                                                <div class="d-flex align-items-center gap-3 mb-2">
                                                                    <img src="{{ $item->book && $item->book->cover_image ? asset('storage/' . $item->book->cover_image) : 'https://placehold.co/100x140/23085A/FFFFFF/png?text=Buku' }}"
                                                                        style="width: 40px; height: 56px; object-fit: cover; border-radius: 4px;">
                                                                    <div>
                                                                        <div class="fw-bold text-dark"
                                                                            style="font-size: 0.88rem;">
                                                                            {{ $item->book->title ?? $item->book_title }}
                                                                        </div>
                                                                        <div class="text-muted small">Beri penilaian untuk
                                                                            buku ini:</div>
                                                                    </div>
                                                                </div>

                                                                <div class="star-rating mb-2">
                                                                    <input type="radio"
                                                                        id="star5_{{ $order->id }}_{{ $item->book_id }}"
                                                                        name="book_ratings[{{ $item->book_id }}]"
                                                                        value="5" required />
                                                                    <label
                                                                        for="star5_{{ $order->id }}_{{ $item->book_id }}"><i
                                                                            class="fa-solid fa-star"></i></label>
                                                                    <input type="radio"
                                                                        id="star4_{{ $order->id }}_{{ $item->book_id }}"
                                                                        name="book_ratings[{{ $item->book_id }}]"
                                                                        value="4" />
                                                                    <label
                                                                        for="star4_{{ $order->id }}_{{ $item->book_id }}"><i
                                                                            class="fa-solid fa-star"></i></label>
                                                                    <input type="radio"
                                                                        id="star3_{{ $order->id }}_{{ $item->book_id }}"
                                                                        name="book_ratings[{{ $item->book_id }}]"
                                                                        value="3" />
                                                                    <label
                                                                        for="star3_{{ $order->id }}_{{ $item->book_id }}"><i
                                                                            class="fa-solid fa-star"></i></label>
                                                                    <input type="radio"
                                                                        id="star2_{{ $order->id }}_{{ $item->book_id }}"
                                                                        name="book_ratings[{{ $item->book_id }}]"
                                                                        value="2" />
                                                                    <label
                                                                        for="star2_{{ $order->id }}_{{ $item->book_id }}"><i
                                                                            class="fa-solid fa-star"></i></label>
                                                                    <input type="radio"
                                                                        id="star1_{{ $order->id }}_{{ $item->book_id }}"
                                                                        name="book_ratings[{{ $item->book_id }}]"
                                                                        value="1" />
                                                                    <label
                                                                        for="star1_{{ $order->id }}_{{ $item->book_id }}"><i
                                                                            class="fa-solid fa-star"></i></label>
                                                                </div>

                                                                <textarea name="book_comments[{{ $item->book_id }}]" class="form-control" rows="2"
                                                                    placeholder="Bagikan ulasan Anda tentang isi buku ini..." style="font-size: 0.85rem; border-radius: 8px;"></textarea>
                                                            </div>
                                                        @endif
                                                    @endforeach

                                                </div>
                                                <div class="modal-footer" style="border-top: 1px solid #E2E8F0;">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal"
                                                        style="font-size: 0.82rem;">Batal</button>
                                                    <button type="submit" class="btn btn-primary"
                                                        style="background: #23085A; border: none; font-size: 0.82rem;">Kirim
                                                        Ulasan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach

                        <div class="d-flex justify-content-center mt-4">
                            {{ $orders->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fa-regular fa-folder-open fa-3x mb-3" style="color: #CBD5E1;"></i>
                            <h5 style="font-size: 0.95rem; font-weight: 700; color: #475569;">Belum Ada Pesanan</h5>
                            <p class="text-muted" style="font-size: 0.8rem;">Pesanan yang Anda buat akan muncul di sini.
                            </p>
                        </div>
                    @endif
                </div>
            </main>

        </div>
    </div>
@endsection

@push('scripts')
    <!-- MIDTRANS SNAP JS -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    <script>
        function payOrder(snapToken) {
            snap.pay(snapToken, {
                onSuccess: function(result) {
                    window.location.href = "{{ route('checkout.success') }}";
                },
                onPending: function(result) {
                    window.location.reload();
                },
                onError: function(result) {
                    alert("Pembayaran gagal!");
                },
                onClose: function() {
                    alert('Pop-up pembayaran ditutup.');
                }
            });
        }
    </script>
@endpush
