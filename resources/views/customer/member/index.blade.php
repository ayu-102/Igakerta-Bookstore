@extends('layouts.app')

@section('title', 'Member & Poin Saya - IGAKERTA Book Store')

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

        /* SIDEBAR STYLES */
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

        /* HEADER & MEMBER CARDS */
        .page-header {
            margin-bottom: 24px;
        }

        .page-title {
            font-size: 1.5rem;
            font-weight: 800;
            color: #0F172A;
            margin: 0;
        }

        .page-subtitle {
            font-size: 0.85rem;
            color: #64748B;
            margin-top: 4px;
        }

        .member-card-wrapper {
            display: grid;
            grid-template-columns: 1.3fr 0.7fr;
            gap: 20px;
            margin-bottom: 28px;
        }

        @media (max-width: 992px) {
            .member-card-wrapper {
                grid-template-columns: 1fr;
            }
        }

        /* KARTU MEMBER DIGITAL */
        .loyalty-card {
            background: linear-gradient(135deg, #23085A 0%, #4A1996 100%);
            border-radius: 16px;
            padding: 24px;
            color: #FFFFFF;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(35, 8, 90, 0.2);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 200px;
        }

        .loyalty-card::after {
            content: '';
            position: absolute;
            top: -40px;
            right: -40px;
            width: 180px;
            height: 180px;
            background: rgba(255, 255, 255, 0.06);
            border-radius: 50%;
            pointer-events: none;
        }

        .card-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .brand-name {
            font-weight: 800;
            font-size: 1rem;
            letter-spacing: 1px;
            color: #FFC000;
        }

        .tier-badge {
            background: rgba(255, 255, 255, 0.18);
            backdrop-filter: blur(8px);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.72rem;
            font-weight: 700;
            border: 1px solid rgba(255, 255, 255, 0.2);
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .card-middle {
            margin: 20px 0;
        }

        .user-member-name {
            font-size: 1.25rem;
            font-weight: 800;
            margin: 0;
            letter-spacing: 0.5px;
        }

        .member-id {
            font-size: 0.75rem;
            opacity: 0.8;
            margin-top: 2px;
        }

        .card-bottom {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            border-top: 1px solid rgba(255, 255, 255, 0.15);
            padding-top: 12px;
        }

        .points-label {
            font-size: 0.7rem;
            opacity: 0.8;
            display: block;
            text-transform: uppercase;
        }

        .points-value {
            font-size: 1.6rem;
            font-weight: 800;
            color: #FFC000;
            line-height: 1;
            margin-top: 2px;
        }

        /* BOX POIN INFO */
        .info-box-card {
            background: #FFFFFF;
            border-radius: 16px;
            padding: 20px;
            border: 1px solid #E2E8F0;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .info-header h4 {
            font-size: 0.92rem;
            font-weight: 800;
            color: #0F172A;
            margin: 0 0 6px 0;
        }

        .info-header p {
            font-size: 0.76rem;
            color: #64748B;
            margin: 0;
            line-height: 1.4;
        }

        .progress-title {
            display: flex;
            justify-content: space-between;
            font-size: 0.74rem;
            font-weight: 700;
            color: #334155;
            margin-bottom: 6px;
        }

        .progress-bar-bg {
            background: #F1F5F9;
            height: 8px;
            border-radius: 10px;
            overflow: hidden;
        }

        .progress-bar-fill {
            background: #23085A;
            height: 100%;
            border-radius: 10px;
        }

        /* SECTION BOX */
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
            font-size: 1rem;
            font-weight: 800;
            color: #0F172A;
            margin: 0;
        }

        .use-points-banner {
            background: #F8FAFC;
            border: 1px dashed #CBD5E1;
            border-radius: 10px;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .use-points-banner i {
            font-size: 2rem;
            color: #FFC000;
        }

        .use-points-text h4 {
            font-size: 0.9rem;
            font-weight: 700;
            color: #0F172A;
            margin: 0 0 4px 0;
        }

        .use-points-text p {
            font-size: 0.78rem;
            color: #64748B;
            margin: 0;
        }

        /* TABEL RIWAYAT POIN */
        .history-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.8rem;
        }

        .history-table th {
            text-align: left;
            padding: 10px 12px;
            background: #F8FAFC;
            color: #475569;
            font-weight: 700;
            border-bottom: 1px solid #E2E8F0;
        }

        .history-table td {
            padding: 12px;
            border-bottom: 1px solid #F1F5F9;
            color: #334155;
        }

        .badge-plus {
            color: #16A34A;
            font-weight: 800;
        }

        .badge-minus {
            color: #DC2626;
            font-weight: 800;
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

            <!-- KONTEN UTAMA MEMBER & POIN -->
            <main>
                <div class="page-header">
                    <h1 class="page-title">Member & Poin Saya</h1>
                    <p class="page-subtitle">Kumpulkan poin dari setiap pembelian buku dan gunakan sebagai potongan belanja
                        saat checkout!</p>
                </div>

                <!-- TAMPILAN KARTU MEMBER DIGITAL & DOKUMEN STATUS -->
                <div class="member-card-wrapper">
                    <!-- KARTU MEMBER -->
                    <div class="loyalty-card">
                        <div class="card-top">
                            <span class="brand-name">IGAKERTA CLUB</span>
                            <span class="tier-badge">{{ $memberTier ?? 'Bronze Tier' }}</span>
                        </div>
                        <div class="card-middle">
                            <h2 class="user-member-name">{{ Auth::user()->name }}</h2>
                            <div class="member-id">ID Member: #IGK-{{ str_pad(Auth::user()->id, 5, '0', STR_PAD_LEFT) }}
                            </div>
                        </div>
                        <div class="card-bottom">
                            <div>
                                <span class="points-label">Total Poin Aktif</span>
                                <div class="points-value">{{ number_format(Auth::user()->points ?? 0, 0, ',', '.') }}
                                    <small style="font-size: 0.8rem;">Pts</small>
                                </div>
                            </div>
                            <i class="fa-solid fa-gem" style="font-size: 2rem; opacity: 0.4;"></i>
                        </div>
                    </div>

                    <!-- PROGRESS PROMOSI LEVEL -->
                    <div class="info-box-card">
                        <div class="info-header">
                            <h4>Cara Mendapatkan Poin</h4>
                            <p>Setiap belanja kelipatan <strong>Rp 10.000</strong>, Anda mendapatkan <strong>1
                                    Poin</strong>.</p>
                        </div>
                        <div style="margin-top: 16px;">
                            @php
                                $currentPoints = Auth::user()->points ?? 0;
                                $targetPoints = 500;
                                $nextTier = 'Gold Member';

                                if ($currentPoints >= 1000) {
                                    $targetPoints = 1000;
                                    $nextTier = 'Platinum Top Level';
                                } elseif ($currentPoints >= 500) {
                                    $targetPoints = 1000;
                                    $nextTier = 'Platinum Member';
                                }

                                $percentage = min(100, ($currentPoints / $targetPoints) * 100);
                            @endphp
                            <div class="progress-title">
                                <span>Progres ke {{ $nextTier }}</span>
                                <span>{{ $currentPoints }} / {{ $targetPoints }} Pts</span>
                            </div>
                            <div class="progress-bar-bg">
                                <div class="progress-bar-fill" style="width: {{ $percentage }}%;"></div>
                            </div>
                            <p style="font-size: 0.7rem; color: #94A3B8; margin-top: 6px;">Kumpulkan {{ $targetPoints }}
                                Poin untuk membuka keuntungan {{ $nextTier }}!</p>
                        </div>
                    </div>
                </div>

                <!-- CARA PENGGUNAAN POIN BANNER -->
                <div class="card-box">
                    <div class="use-points-banner">
                        <i class="fa-solid fa-coins"></i>
                        <div class="use-points-text">
                            <h4>Gunakan Poin Langsung Saat Checkout</h4>
                            <p>Anda tidak perlu menukar voucher secara manual. Cukup centang opsi <strong>"Gunakan
                                    Poin"</strong> saat halaman checkout untuk mendapatkan potongan harga secara otomatis.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- RIWAYAT POIN -->
                <div class="card-box">
                    <div class="card-box-header">
                        <h3 class="card-box-title">Riwayat Aktivitas Poin</h3>
                    </div>

                    <table class="history-table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Keterangan</th>
                                <th>Jenis</th>
                                <th style="text-align: right;">Jumlah Poin</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pointHistories ?? [] as $history)
                                <tr>
                                    <td>{{ $history->created_at ? $history->created_at->format('d M Y') : date('d M Y') }}
                                    </td>
                                    <td>{{ $history->title }}</td>
                                    <td>
                                        @if (in_array($history->type, ['earned', 'Perolehan']))
                                            <span class="badge-plus">Perolehan</span>
                                        @else
                                            <span class="badge-minus">Penggunaan</span>
                                        @endif
                                    </td>
                                    <td style="text-align: right;"
                                        class="{{ in_array($history->type, ['earned', 'Perolehan']) ? 'badge-plus' : 'badge-minus' }}">
                                        {{ in_array($history->type, ['earned', 'Perolehan']) ? '+' : '-' }}{{ $history->points }}
                                        Pts
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td>{{ date('d M Y') }}</td>
                                    <td>Bonus Poin Registrasi Akun Baru</td>
                                    <td><span class="badge-plus">Perolehan</span></td>
                                    <td style="text-align: right;" class="badge-plus">
                                        +{{ Auth::user()->points ?? 0 }} Pts
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </main>

        </div>
    </div>
@endsection
