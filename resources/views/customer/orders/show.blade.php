@extends('layouts.app')

@section('title', 'Detail Pesanan #' . $order->order_number . ' - IGAKERTA Book Store')

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

        /* HEADER STYLING */
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

        .btn-back-dashboard {
            font-size: 0.78rem;
            font-weight: 600;
            padding: 8px 16px;
            border: 1px solid #CBD5E1;
            border-radius: 8px;
            color: #334155;
            background: #FFFFFF;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
        }

        .btn-back-dashboard:hover {
            background: #F1F5F9;
            border-color: #94A3B8;
            color: #0F172A;
        }

        /* CARD BOX STYLING */
        .card-box {
            background: #FFFFFF;
            border-radius: 12px;
            padding: 24px;
            border: 1px solid #E2E8F0;
            margin-bottom: 24px;
        }

        .card-box-title {
            font-size: 0.98rem;
            font-weight: 800;
            color: #0F172A;
            margin: 0 0 16px 0;
        }

        /* SUMMARY BANNER */
        .order-summary-banner {
            background: #F8FAFC;
            border: 1px solid #E2E8F0;
            border-radius: 10px;
            padding: 16px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .summary-label {
            font-size: 0.75rem;
            color: #64748B;
            display: block;
            margin-bottom: 2px;
        }

        .summary-value {
            font-size: 0.88rem;
            font-weight: 700;
            color: #0F172A;
        }

        /* STATUS BADGES */
        .status-badge {
            font-size: 0.72rem;
            font-weight: 700;
            padding: 4px 12px;
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

        /* TABLE STYLING */
        .table-custom {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table-custom th {
            background: #F8FAFC;
            color: #475569;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 10px 14px;
            border-top: 1px solid #E2E8F0;
            border-bottom: 1px solid #E2E8F0;
            text-transform: uppercase;
        }

        .table-custom td {
            padding: 14px;
            border-bottom: 1px solid #F1F5F9;
            font-size: 0.82rem;
            color: #334155;
            vertical-align: middle;
        }

        .table-custom tr:last-child td {
            border-bottom: none;
        }

        .order-book-cover {
            width: 44px;
            height: 62px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid #E2E8F0;
        }

        .book-title {
            font-size: 0.85rem;
            font-weight: 700;
            color: #0F172A;
            margin-bottom: 2px;
        }

        .book-type {
            font-size: 0.72rem;
            color: #64748B;
        }

        /* INFO BOXES */
        .info-card {
            background: #F8FAFC;
            border: 1px solid #E2E8F0;
            border-radius: 10px;
            padding: 16px;
            height: 100%;
        }

        .info-card h6 {
            font-size: 0.82rem;
            font-weight: 700;
            color: #0F172A;
            margin-bottom: 10px;
        }

        .info-card p {
            font-size: 0.78rem;
            color: #475569;
            margin-bottom: 4px;
        }

        .payment-summary-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .payment-summary-item {
            display: flex;
            justify-content: space-between;
            font-size: 0.8rem;
            padding: 8px 0;
            color: #475569;
            border-bottom: 1px dashed #E2E8F0;
        }

        .payment-summary-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .payment-summary-item.grand-total {
            font-size: 0.92rem;
            font-weight: 800;
            color: #0F172A;
            padding-top: 12px;
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
                        <a href="{{ route('ebook.index') }}"
                            class="{{ request()->routeIs('ebook.index') ? 'active' : '' }}">
                            <i class="fa-solid fa-book"></i>
                            <span>Ebook Saya</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('wishlist.index') }}"
                            class="{{ request()->routeIs('wishlist.index') ? 'active' : '' }}">
                            <i class="fa-regular fa-heart"></i>
                            <span>Wishlist</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('promo.index') }}"
                            class="{{ request()->routeIs('promo.index') ? 'active' : '' }}">
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

            <!-- KONTEN UTAMA DETAIL PESANAN -->
            <main>
                <div class="dashboard-header">
                    <div>
                        <h1 class="dashboard-title">Detail Pesanan</h1>
                        <p class="dashboard-welcome">Nomor Transaksi: #{{ $order->order_number }}</p>
                    </div>
                    <a href="{{ route('customer.orders.index') }}" class="btn-back-dashboard">
                        <i class="fa-solid fa-arrow-left"></i> Kembali
                    </a>
                </div>

                <div class="card-box">
                    <!-- BANNER RINGKASAN WAKTU & STATUS -->
                    <div class="order-summary-banner">
                        <div>
                            <span class="summary-label">Tanggal Transaksi</span>
                            <span class="summary-value">{{ $order->created_at->format('d M Y, H:i WIB') }}</span>
                        </div>
                        <div class="text-end">
                            <span class="summary-label">Status Pesanan</span>
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

                    <!-- TABEL DIBELI -->
                    <h3 class="card-box-title">Item Yang Dibeli</h3>
                    <div class="table-responsive mb-4">
                        <table class="table-custom">
                            <thead>
                                <tr>
                                    <th>Buku</th>
                                    <th>Harga</th>
                                    <th class="text-center">Jumlah</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->items as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <img src="{{ $item->book && $item->book->cover_image ? asset('storage/' . $item->book->cover_image) : 'https://placehold.co/100x140/23085A/FFFFFF/png?text=Buku' }}"
                                                    alt="{{ $item->book->title ?? 'Buku' }}" class="order-book-cover">
                                                <div>
                                                    <div class="book-title">
                                                        {{ $item->book->title ?? ($item->book_title ?? 'Buku') }}</div>
                                                    <div class="book-type">{{ ucfirst($item->book->type ?? 'Fisik') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                        <td class="text-center"><strong>{{ $item->quantity }}</strong></td>
                                        <td class="text-end" style="font-weight: 700; color: #23085A;">
                                            Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- INFORMASI PENERIMA & RINCIAN PEMBAYARAN -->
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="info-card">
                                <h6>Informasi Penerima</h6>
                                <p style="font-weight: 700; color: #0F172A;">
                                    {{ $order->recipient_name ?? Auth::user()->name }}</p>
                                <p>{{ $order->phone_number ?? Auth::user()->phone }}</p>
                                <p style="margin-top: 8px;">{{ $order->shipping_address ?? 'Tidak ada alamat pengiriman' }}
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-card">
                                <h6>Rincian Pembayaran</h6>
                                <ul class="payment-summary-list">
                                    <li class="payment-summary-item">
                                        <span>Total Harga Produk</span>
                                        <strong>Rp
                                            {{ number_format($order->subtotal ?? $order->grand_total, 0, ',', '.') }}</strong>
                                    </li>
                                    @if (($order->discount ?? 0) > 0)
                                        <li class="payment-summary-item" style="color: #16A34A;">
                                            <span>Diskon / Voucher</span>
                                            <strong>- Rp {{ number_format($order->discount, 0, ',', '.') }}</strong>
                                        </li>
                                    @endif
                                    <li class="payment-summary-item grand-total">
                                        <span>Grand Total</span>
                                        <span style="color: #23085A;">Rp
                                            {{ number_format($order->grand_total, 0, ',', '.') }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </main>

        </div>
    </div>
@endsection
