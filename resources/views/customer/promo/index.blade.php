@extends('layouts.app')

@section('title', 'Voucher Saya - IGAKERTA Book Store')

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

        /* SIDEBAR CARD */
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

        /* CARD MAIN CONTAINER */
        .card-box {
            background: #FFFFFF;
            border-radius: 12px;
            padding: 24px;
            border: 1px solid #E2E8F0;
        }

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 1px solid #F1F5F9;
        }

        .dashboard-title {
            font-size: 1.35rem;
            font-weight: 800;
            color: #0F172A;
            margin: 0;
        }

        .dashboard-welcome {
            font-size: 0.82rem;
            color: #64748B;
            margin-top: 4px;
        }

        /* VOUCHER GRID & CARDS */
        .voucher-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .voucher-card {
            border: 1px solid #E2E8F0;
            border-radius: 12px;
            background: #FFFFFF;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .voucher-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.04);
        }

        .voucher-top {
            background: linear-gradient(135deg, #23085A 0%, #3B118C 100%);
            color: #FFFFFF;
            padding: 16px;
            display: flex;
            align-items: center;
            gap: 14px;
            position: relative;
        }

        .voucher-icon {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: #FFC000;
            flex-shrink: 0;
        }

        .voucher-title-info h4 {
            margin: 0;
            font-size: 0.95rem;
            font-weight: 800;
            color: #FFFFFF;
        }

        .voucher-title-info span {
            font-size: 0.72rem;
            color: #E2E8F0;
            display: block;
            margin-top: 2px;
        }

        .voucher-body {
            padding: 16px;
            flex-grow: 1;
        }

        .voucher-code-wrapper {
            background: #F8FAFC;
            border: 1px dashed #CBD5E1;
            border-radius: 8px;
            padding: 10px 14px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .voucher-code {
            font-size: 0.9rem;
            font-weight: 800;
            letter-spacing: 1px;
            color: #23085A;
            font-family: monospace;
        }

        .btn-copy {
            background: #23085A;
            color: #FFFFFF;
            border: none;
            border-radius: 6px;
            padding: 5px 10px;
            font-size: 0.72rem;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-copy:hover {
            background: #1A0644;
        }

        .voucher-meta {
            font-size: 0.74rem;
            color: #64748B;
            line-height: 1.5;
        }

        .voucher-meta i {
            width: 16px;
            color: #94A3B8;
        }

        .voucher-footer {
            padding: 12px 16px;
            background: #FAF5FF;
            border-top: 1px solid #F1F5F9;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.72rem;
            color: #64748B;
        }

        .badge-active {
            background: #F0FDF4;
            color: #16A34A;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 12px;
            border: 1px solid #DCFCE7;
        }

        /* EMPTY STATE */
        .empty-voucher-state {
            text-align: center;
            padding: 50px 20px;
        }

        .empty-voucher-state i {
            font-size: 3rem;
            color: #CBD5E1;
            margin-bottom: 14px;
        }

        .empty-voucher-state h3 {
            font-size: 1.05rem;
            font-weight: 700;
            color: #0F172A;
            margin-bottom: 6px;
        }

        .empty-voucher-state p {
            font-size: 0.8rem;
            color: #64748B;
            margin-bottom: 20px;
        }

        .btn-shop-now {
            background: #23085A;
            color: #FFFFFF;
            padding: 9px 18px;
            border-radius: 8px;
            font-size: 0.78rem;
            font-weight: 700;
            text-decoration: none;
            display: inline-block;
            transition: background 0.2s;
        }

        .btn-shop-now:hover {
            background: #1A0644;
            color: #FFFFFF;
        }
    </style>
@endpush

@section('content')
    <div class="dashboard-container">
        <div class="dashboard-grid">

            <!-- SIDEBAR NAVIGASI INTEGRATED -->
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

            <!-- KONTEN UTAMA VOUCHER SAYA -->
            <main class="card-box">
                <div class="dashboard-header">
                    <div>
                        <h1 class="dashboard-title">Voucher & Promo Saya</h1>
                        <p class="dashboard-welcome">Gunakan kode voucher promo di bawah saat checkout untuk mendapatkan
                            potongan harga.</p>
                    </div>
                </div>

                @if (isset($vouchers) && $vouchers->count() > 0)
                    <div class="voucher-grid">
                        @foreach ($vouchers as $voucher)
                            <div class="voucher-card">
                                <div class="voucher-top">
                                    <div class="voucher-icon">
                                        <i class="fa-solid fa-percent"></i>
                                    </div>
                                    <div class="voucher-title-info">
                                        <!-- Menampilkan Diskon % atau Rp -->
                                        <h4>Diskon
                                            {{ $voucher->type == 'percentage' ? number_format($voucher->amount, 0) . '%' : 'Rp ' . number_format($voucher->amount, 0, ',', '.') }}
                                        </h4>
                                        <!-- Menampilkan Title dari database -->
                                        <span>{{ $voucher->title }}</span>
                                    </div>
                                </div>

                                <div class="voucher-body">
                                    <div class="voucher-code-wrapper">
                                        <span class="voucher-code"
                                            id="code-{{ $voucher->id }}">{{ $voucher->code }}</span>
                                        <button type="button" class="btn-copy"
                                            onclick="copyVoucherCode('code-{{ $voucher->id }}', this)">
                                            Salin Kode
                                        </button>
                                    </div>

                                    <div class="voucher-meta">
                                        <div><i class="fa-regular fa-circle-check"></i> Min. Belanja: <strong>Rp
                                                {{ number_format($voucher->min_purchase ?? 0, 0, ',', '.') }}</strong>
                                        </div>

                                        <!-- Pengecekan kolom expiry_date yang benar -->
                                        @if ($voucher->expiry_date)
                                            <div><i class="fa-regular fa-clock"></i> Berlaku s/d:
                                                <strong>{{ \Carbon\Carbon::parse($voucher->expiry_date)->translatedFormat('d M Y') }}</strong>
                                            </div>
                                        @else
                                            <div><i class="fa-regular fa-clock"></i> Berlaku Tanpa Batas Waktu</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="voucher-footer">
                                    <span class="badge-active">Siap Digunakan</span>
                                    <a href="{{ route('catalog.index') }}"
                                        style="color: #23085A; text-decoration: none; font-weight: 700;">Pakai Voucher
                                        &rarr;</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-voucher-state">
                        <i class="fa-solid fa-ticket"></i>
                        <h3>Belum Ada Voucher Tersedia</h3>
                        <p>Saat ini belum ada voucher promo aktif untuk akun Anda. Nantikan promo menarik dari IGAKERTA!</p>
                        <a href="{{ route('catalog.index') }}" class="btn-shop-now">
                            Mulai Belanja Sekarang
                        </a>
                    </div>
                @endif
            </main>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function copyVoucherCode(elementId, btn) {
            const codeText = document.getElementById(elementId).innerText;
            navigator.clipboard.writeText(codeText).then(() => {
                const originalText = btn.innerText;
                btn.innerText = 'Tersalin!';
                btn.style.background = '#16A34A';

                setTimeout(() => {
                    btn.innerText = originalText;
                    btn.style.background = '#23085A';
                }, 2000);
            }).catch(err => {
                console.error('Gagal menyalin kode:', err);
            });
        }
    </script>
@endpush
