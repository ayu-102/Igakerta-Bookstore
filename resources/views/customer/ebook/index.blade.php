@extends('layouts.app')

@section('title', 'Ebook Saya - IGAKERTA Book Store')

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

        /* MAIN CONTENT AREA */
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

        /* SEARCH BOX */
        .ebook-search-box {
            position: relative;
            max-width: 280px;
            width: 100%;
        }

        .ebook-search-box input {
            width: 100%;
            padding: 8px 36px 8px 14px;
            border: 1px solid #CBD5E1;
            border-radius: 8px;
            font-size: 0.82rem;
            outline: none;
            box-sizing: border-box;
            background: #F8FAFC;
            transition: all 0.2s;
        }

        .ebook-search-box input:focus {
            background: #FFFFFF;
            border-color: #23085A;
        }

        .ebook-search-box i {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #94A3B8;
            font-size: 0.85rem;
        }

        /* EBOOK GRID STYLING */
        .ebook-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(210px, 1fr));
            gap: 20px;
        }

        .ebook-card-item {
            border: 1px solid #E2E8F0;
            border-radius: 12px;
            overflow: hidden;
            background: #FFFFFF;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .ebook-card-item:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
        }

        .ebook-cover-wrapper {
            position: relative;
            width: 100%;
            height: 200px;
            background: #FAF5FF;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border-bottom: 1px solid #F1F5F9;
        }

        .ebook-cover-wrapper img {
            max-height: 85%;
            max-width: 85%;
            object-fit: contain;
            border-radius: 4px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.08);
        }

        .badge-format {
            position: absolute;
            top: 10px;
            left: 10px;
            background: #23085A;
            color: #FFFFFF;
            font-size: 0.62rem;
            font-weight: 800;
            padding: 3px 8px;
            border-radius: 4px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .ebook-info {
            padding: 14px;
            flex-grow: 1;
        }

        .ebook-title {
            font-size: 0.88rem;
            font-weight: 700;
            color: #0F172A;
            margin-bottom: 4px;
            line-height: 1.3;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .ebook-author {
            font-size: 0.74rem;
            color: #64748B;
        }

        .ebook-actions {
            padding: 0 14px 14px 14px;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .btn-read-online {
            background: #23085A;
            color: #FFFFFF;
            text-decoration: none;
            text-align: center;
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 0.76rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            transition: background 0.2s;
        }

        .btn-read-online:hover {
            background: #1A0644;
            color: #FFFFFF;
        }

        .btn-download-pdf {
            background: #FFFFFF;
            color: #334155;
            text-decoration: none;
            text-align: center;
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 0.76rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            border: 1px solid #CBD5E1;
            transition: all 0.2s;
        }

        .btn-download-pdf:hover {
            background: #F8FAFC;
            border-color: #94A3B8;
            color: #0F172A;
        }

        /* EMPTY STATE */
        .empty-ebook-state {
            text-align: center;
            padding: 50px 20px;
        }

        .empty-ebook-state i {
            font-size: 3rem;
            color: #CBD5E1;
            margin-bottom: 14px;
        }

        .empty-ebook-state h3 {
            font-size: 1.05rem;
            font-weight: 700;
            color: #0F172A;
            margin-bottom: 6px;
        }

        .empty-ebook-state p {
            font-size: 0.8rem;
            color: #64748B;
            margin-bottom: 20px;
        }

        .btn-browse-ebook {
            background: #23085A;
            color: #FFFFFF;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 0.82rem;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: background 0.2s;
        }

        .btn-browse-ebook:hover {
            background: #1A0644;
            color: #FFFFFF;
        }

        /* Memastikan ukuran ikon di dalam tombol tidak membengkak */
        .btn-browse-ebook i {
            font-size: 0.9rem !important;
            margin: 0 !important;
            color: #FFFFFF !important;
        }

        @media (max-width: 640px) {
            .dashboard-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 14px;
            }

            .ebook-search-box {
                max-width: 100%;
            }
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

            <!-- KONTEN UTAMA PERPUSTAKAAN EBOOK -->
            <main class="card-box">
                <div class="dashboard-header">
                    <div>
                        <h1 class="dashboard-title">Perpustakaan Ebook Saya</h1>
                        <p class="dashboard-welcome">Akses dan baca seluruh e-book digital yang telah Anda beli.</p>
                    </div>

                    <!-- SEARCH BAR -->
                    <form action="{{ route('customer.ebooks') }}" method="GET" class="ebook-search-box">
                        <input type="text" name="search" placeholder="Cari di perpustakaan..."
                            value="{{ request('search') }}">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </form>
                </div>

                <!-- LIST EBOOK ATAU EMPTY STATE -->
                @if (isset($myEbooks) && $myEbooks->count() > 0)
                    <div class="ebook-grid">
                        @foreach ($myEbooks as $item)
                            @php
                                $book = $item->book ?? $item;
                            @endphp
                            <div class="ebook-card-item">
                                <div>
                                    <div class="ebook-cover-wrapper">
                                        <span class="badge-format">PDF / EPUB</span>
                                        <img src="{{ $book->cover_image ? asset('storage/' . $book->cover_image) : 'https://placehold.co/150x200/23085A/FFFFFF/png?text=Cover' }}"
                                            alt="{{ $book->title }}">
                                    </div>
                                    <div class="ebook-info">
                                        <div class="ebook-title" title="{{ $book->title }}">{{ $book->title }}</div>
                                        <div class="ebook-author">
                                            {{ is_object($book->author) ? $book->author->name : $book->author ?? '-' }}
                                        </div>
                                    </div>
                                </div>

                                <div class="ebook-actions">
                                    @if ($book->file_pdf)
                                        <a href="{{ asset('storage/' . $book->file_pdf) }}" target="_blank"
                                            class="btn-read-online">
                                            <i class="fa-solid fa-book-open"></i> Baca Online
                                        </a>
                                        <a href="{{ asset('storage/' . $book->file_pdf) }}" download
                                            class="btn-download-pdf">
                                            <i class="fa-solid fa-download"></i> Unduh File
                                        </a>
                                    @else
                                        <button disabled class="btn-download-pdf"
                                            style="opacity: 0.6; cursor: not-allowed;">
                                            <i class="fa-solid fa-circle-exclamation"></i> Belum Ada File
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if (method_exists($myEbooks, 'links'))
                        <div style="margin-top: 30px; display: flex; justify-content: center;">
                            {{ $myEbooks->links() }}
                        </div>
                    @endif
                @else
                    <div class="empty-ebook-state">
                        <i class="fa-solid fa-book-bookmark"></i>
                        <h3>Belum Ada Ebook yang Dimiliki</h3>
                        <p>Anda belum membeli e-book digital apapun. Jelajahi katalog e-book kami untuk mulai membaca.</p>
                        <a href="{{ route('ebook.index') }}" class="btn-browse-ebook">
                            <i class="fa-solid fa-magnifying-glass" style="margin-right: 6px;"></i> Jelajahi Katalog Ebook
                        </a>
                    </div>
                @endif
            </main>

        </div>
    </div>
@endsection
