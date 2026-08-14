@extends('layouts.app')

@section('title', 'Keranjang Belanja - IGAKERTA Book Store')

@push('styles')
    <!-- CDN SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        .cart-page-container {
            padding: 25px 6%;
            background-color: #F8FAFC;
        }

        /* BREADCRUMB */
        .breadcrumb-wrap {
            font-size: 0.8rem;
            color: #64748B;
            margin-bottom: 20px;
        }

        .breadcrumb-wrap a {
            color: #475569;
            text-decoration: none;
        }

        .page-header-title {
            font-size: 1.6rem;
            font-weight: 800;
            color: #1E0A3C;
            margin-bottom: 20px;
        }

        /* MAIN LAYOUT GRID */
        .cart-main-grid {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 25px;
            align-items: start;
        }

        /* LEFT SIDE - CART TABLE CARD */
        .cart-table-card {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
        }

        .cart-table {
            width: 100%;
            border-collapse: collapse;
        }

        .cart-table th {
            text-align: left;
            font-size: 0.8rem;
            font-weight: 700;
            color: #1E0A3C;
            padding-bottom: 15px;
            border-bottom: 1px solid #F1F5F9;
        }

        .cart-table td {
            padding: 20px 0;
            border-bottom: 1px solid #F1F5F9;
            vertical-align: middle;
        }

        .custom-checkbox {
            width: 17px;
            height: 17px;
            accent-color: #1E0A3C;
            cursor: pointer;
            border-radius: 4px;
        }

        .item-info-flex {
            display: flex;
            gap: 15px;
            align-items: flex-start;
        }

        .item-info-flex img {
            width: 70px;
            height: 95px;
            object-fit: cover;
            border-radius: 6px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.08);
        }

        .item-title {
            font-weight: 700;
            font-size: 0.9rem;
            color: #1E0A3C;
            margin-bottom: 3px;
            line-height: 1.3;
        }

        .item-author {
            font-size: 0.75rem;
            color: #64748B;
            margin-bottom: 6px;
        }

        .item-stock-tag {
            font-size: 0.72rem;
            color: #16A34A;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .item-quick-actions {
            display: flex;
            gap: 12px;
            font-size: 0.72rem;
            color: #94A3B8;
        }

        .item-quick-actions button,
        .item-quick-actions a {
            background: none;
            border: none;
            color: #94A3B8;
            cursor: pointer;
            text-decoration: none;
            padding: 0;
            font-size: 0.72rem;
        }

        .item-quick-actions button:hover,
        .item-quick-actions a:hover {
            color: #1E0A3C;
            text-decoration: underline;
        }

        .price-text {
            font-size: 0.85rem;
            font-weight: 700;
            color: #1E0A3C;
        }

        /* QTY CONTROLLER */
        .qty-control-box {
            display: inline-flex;
            align-items: center;
            background: #F8FAFC;
            border: 1px solid #E2E8F0;
            border-radius: 6px;
            overflow: hidden;
        }

        .qty-btn-sub {
            width: 28px;
            height: 28px;
            background: transparent;
            border: none;
            cursor: pointer;
            font-size: 0.8rem;
            font-weight: 700;
            color: #1E0A3C;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .qty-val-input {
            width: 32px;
            height: 28px;
            border: none;
            background: transparent;
            text-align: center;
            font-size: 0.8rem;
            font-weight: 700;
            color: #1E0A3C;
            outline: none;
        }

        .btn-trash-action {
            background: none;
            border: none;
            color: #64748B;
            cursor: pointer;
            font-size: 0.9rem;
            transition: color 0.2s;
        }

        .btn-trash-action:hover {
            color: #EF4444;
        }

        /* CART BOTTOM CONTROL */
        .cart-bottom-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 15px;
        }

        .bulk-select-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.8rem;
            font-weight: 600;
            color: #1E0A3C;
        }

        .btn-delete-selected {
            background: none;
            border: none;
            color: #EF4444;
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
            margin-left: 15px;
        }

        .btn-continue-shop {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border: 1px solid #CBD5E1;
            border-radius: 6px;
            background: white;
            color: #1E0A3C;
            font-size: 0.8rem;
            font-weight: 700;
            text-decoration: none;
            margin-top: 20px;
        }

        /* RIGHT SIDE - SUMMARY CARD */
        .summary-card {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
            margin-bottom: 20px;
        }

        .summary-card-title {
            font-size: 0.95rem;
            font-weight: 800;
            color: #1E0A3C;
            margin-bottom: 15px;
        }

        .summary-item-row {
            display: flex;
            justify-content: space-between;
            font-size: 0.8rem;
            color: #475569;
            margin-bottom: 12px;
        }

        .summary-item-row strong {
            color: #1E0A3C;
        }

        .shipping-section {
            border-top: 1px solid #F1F5F9;
            padding-top: 12px;
            margin-top: 12px;
        }

        .select-city-dropdown {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #E2E8F0;
            border-radius: 6px;
            font-size: 0.78rem;
            color: #334155;
            background: #F8FAFC;
            margin-top: 6px;
            outline: none;
        }

        .voucher-section {
            border-top: 1px solid #F1F5F9;
            padding-top: 12px;
            margin-top: 12px;
        }

        .voucher-input-group {
            display: flex;
            gap: 8px;
            margin-top: 6px;
        }

        .voucher-input-group input {
            flex: 1;
            padding: 8px 12px;
            border: 1px solid #E2E8F0;
            border-radius: 6px;
            font-size: 0.78rem;
            outline: none;
        }

        .btn-apply-voucher {
            background: #EDE9FE;
            color: #1E0A3C;
            border: none;
            padding: 8px 14px;
            border-radius: 6px;
            font-size: 0.78rem;
            font-weight: 700;
            cursor: pointer;
        }

        .total-final-row {
            border-top: 1px dashed #E2E8F0;
            padding-top: 15px;
            margin-top: 15px;
        }

        .total-summary-lines {
            display: flex;
            flex-direction: column;
            gap: 6px;
            margin-bottom: 12px;
        }

        .total-final-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .total-final-title {
            font-size: 0.85rem;
            font-weight: 700;
            color: #1E0A3C;
        }

        .total-final-price {
            font-size: 1.25rem;
            font-weight: 800;
            color: #1E0A3C;
        }

        .btn-checkout-primary {
            width: 100%;
            background: #FFC000;
            color: #1E0A3C;
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-weight: 800;
            font-size: 0.85rem;
            cursor: pointer;
            margin-top: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-checkout-primary:disabled {
            background: #CBD5E1;
            cursor: not-allowed;
            color: #64748B;
        }

        /* SECURITY WIDGET */
        .security-widget {
            background: white;
            border: 1px solid #E2E8F0;
            border-radius: 12px;
            padding: 18px;
        }

        .security-widget-title {
            font-size: 0.82rem;
            font-weight: 800;
            color: #1E0A3C;
            margin-bottom: 12px;
        }

        .security-item {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 0.78rem;
            color: #334155;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .security-item:last-child {
            margin-bottom: 0;
        }

        .security-item i {
            color: #1E0A3C;
            font-size: 0.95rem;
            width: 18px;
        }

        /* FEATURES BANNER */
        .features-banner {
            margin-top: 40px;
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 12px;
            padding: 20px;
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 15px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .feature-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            border: 1px solid #E2E8F0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            color: #1E0A3C;
            flex-shrink: 0;
        }

        .feature-title {
            font-size: 0.75rem;
            font-weight: 700;
            color: #1E0A3C;
        }

        .feature-desc {
            font-size: 0.68rem;
            color: #64748B;
        }

        /* RECOMMENDATIONS */
        .recommendation-section {
            margin-top: 40px;
        }

        .recommendation-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .recommendation-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 15px;
        }

        .book-card {
            background: white;
            border: 1px solid #E2E8F0;
            border-radius: 10px;
            padding: 10px;
            position: relative;
        }

        .book-card img {
            width: 100%;
            aspect-ratio: 1/1;
            object-fit: cover;
            border-radius: 6px;
            margin-bottom: 8px;
        }

        .book-card-title {
            font-size: 0.78rem;
            font-weight: 700;
            color: #1E0A3C;
            line-height: 1.2;
            margin-bottom: 4px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            height: 30px;
        }

        .book-card-author {
            font-size: 0.68rem;
            color: #64748B;
            margin-bottom: 6px;
        }

        .book-card-price {
            font-size: 0.8rem;
            font-weight: 800;
            color: #1E0A3C;
            margin-bottom: 4px;
        }

        .book-card-stars {
            font-size: 0.65rem;
            color: #FFC000;
            display: flex;
            align-items: center;
            gap: 2px;
        }

        .book-card-btn-cart {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background: #1E0A3C;
            color: white;
            border: none;
            width: 26px;
            height: 26px;
            border-radius: 6px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
        }

        /* NEWSLETTER FOOTER BANNER */
        .newsletter-banner {
            margin-top: 50px;
            background: #120326;
            border-radius: 16px;
            padding: 30px 40px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .newsletter-input-wrap {
            display: flex;
            gap: 10px;
            background: white;
            padding: 4px;
            border-radius: 8px;
            width: 420px;
        }

        .newsletter-input-wrap input {
            border: none;
            padding: 8px 12px;
            font-size: 0.8rem;
            flex: 1;
            outline: none;
        }

        .btn-subscribe {
            background: #FFC000;
            color: #1E0A3C;
            border: none;
            padding: 8px 20px;
            border-radius: 6px;
            font-weight: 800;
            font-size: 0.8rem;
            cursor: pointer;
        }

        @media (max-width: 992px) {
            .cart-main-grid {
                grid-template-columns: 1fr;
            }

            .recommendation-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .features-banner {
                grid-template-columns: 1fr;
            }

            .newsletter-banner {
                flex-direction: column;
                gap: 20px;
                text-align: center;
            }

            .newsletter-input-wrap {
                width: 100%;
            }
        }
    </style>
@endpush

@section('content')
    <div class="cart-page-container">

        <!-- BREADCRUMB -->
        <div class="breadcrumb-wrap">
            <a href="{{ route('home') }}">Beranda</a> &rsaquo; <span>Keranjang Belanja</span>
        </div>

        <h1 class="page-header-title">Keranjang Belanja</h1>

        @if (!empty($cart) && count($cart) > 0)
            @php $subtotalTotal = 0; @endphp
            <div class="cart-main-grid">

                <!-- KANAN ATAS / TABEL BUKU -->
                <div>
                    <div class="cart-table-card">
                        <table class="cart-table">
                            <colgroup>
                                <col style="width: 40px;"> <!-- Checkbox -->
                                <col style="width: auto;"> <!-- Produk -->
                                <col style="width: 120px;"> <!-- Harga -->
                                <col style="width: 120px;"> <!-- Jumlah -->
                                <col style="width: 130px;"> <!-- Subtotal -->
                                <col style="width: 50px;"> <!-- Aksi -->
                            </colgroup>

                            <thead>
                                <tr>
                                    <th style="text-align: center;">

                                    </th>
                                    <th style="text-align: left;">Produk</th>
                                    <th style="text-align: right;">Harga</th>
                                    <th style="text-align: center;">Jumlah</th>
                                    <th style="text-align: right;">Subtotal</th>
                                    <th style="text-align: center;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cart as $id => $item)
                                    @php
                                        $itemSubtotal = $item['price'] * $item['quantity'];
                                        $subtotalTotal += $itemSubtotal;
                                    @endphp
                                    <tr>
                                        <!-- Checkbox dengan data-price dan data-id -->
                                        <td style="text-align: center;">
                                            <input type="checkbox" class="custom-checkbox item-check"
                                                data-id="{{ $id }}" data-price="{{ $itemSubtotal }}" checked>
                                        </td>

                                        <!-- Produk -->
                                        <td>
                                            <div class="item-info-flex">
                                                <img src="{{ $item['cover_image'] ? asset('storage/' . $item['cover_image']) : 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?q=80&w=300' }}"
                                                    alt="{{ $item['title'] }}">
                                                <div>
                                                    <div class="item-title">{{ $item['title'] }}</div>
                                                    @php
                                                        $authorName = 'Penulis';
                                                        if (!empty($item['author'])) {
                                                            $authorName = is_array($item['author'])
                                                                ? $item['author']['name'] ?? 'Penulis'
                                                                : $item['author'];
                                                        }
                                                    @endphp

                                                    <div class="item-author">{{ $authorName }}</div>
                                                    <div class="item-stock-tag">• Tersedia</div>
                                                    <div class="item-quick-actions">
                                                        <form action="{{ route('wishlist.toggle', $id) }}" method="POST"
                                                            style="display:inline;">
                                                            @csrf

                                                        </form>

                                                        <form action="{{ route('cart.remove', $id) }}" method="POST"
                                                            style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')

                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Harga -->
                                        <td style="text-align: right;" class="price-text">
                                            Rp {{ number_format($item['price'], 0, ',', '.') }}
                                        </td>

                                        <!-- Jumlah (QTY) -->
                                        <td style="text-align: center;">
                                            <form action="{{ route('cart.update', $id) }}" method="POST"
                                                id="qty-form-{{ $id }}">
                                                @csrf
                                                <div class="qty-control-box">
                                                    <button type="button" class="qty-btn-sub"
                                                        onclick="updateQty('{{ $id }}', -1)">-</button>
                                                    <input type="text" name="quantity"
                                                        id="qty-input-{{ $id }}" value="{{ $item['quantity'] }}"
                                                        class="qty-val-input" readonly>
                                                    <button type="button" class="qty-btn-sub"
                                                        onclick="updateQty('{{ $id }}', 1)">+</button>
                                                </div>
                                            </form>
                                        </td>

                                        <!-- Subtotal -->
                                        <td style="text-align: right;" class="price-text">
                                            Rp {{ number_format($itemSubtotal, 0, ',', '.') }}
                                        </td>

                                        <!-- Aksi (Ikon Hapus) -->
                                        <td style="text-align: center;">
                                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-trash-action" title="Hapus">
                                                    <i class="fa-regular fa-trash-can"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="cart-bottom-actions">
                            <div class="bulk-select-wrap">
                                <input type="checkbox" class="custom-checkbox" id="check-all-bottom" checked>
                                <label for="check-all-bottom">Pilih Semua</label>

                            </div>
                        </div>
                    </div>

                    <a href="{{ route('catalog.index') }}" class="btn-continue-shop">
                        <i class="fa-solid fa-arrow-left"></i> Lanjut Belanja
                    </a>
                </div>

                <!-- KANAN: RINGKASAN BELANJA -->
                <div>
                    <div class="summary-card">
                        <h3 class="summary-card-title">Ringkasan Belanja</h3>

                        <div class="summary-item-row">
                            <span>Subtotal (<span id="selected-count">{{ count($cart) }}</span> produk)</span>
                            <strong id="summary-subtotal">Rp {{ number_format($subtotalTotal, 0, ',', '.') }}</strong>
                        </div>

                        <div class="shipping-section">
                            <div class="summary-item-row" style="margin-bottom: 4px;">
                                <span style="font-size: 0.78rem; font-weight: 700;">Pengiriman</span>
                            </div>
                            <span style="font-size: 0.72rem; color: #64748B;">Kota Tujuan</span>
                            <select class="select-city-dropdown">
                                <option>Kota Depok, Jawa Barat</option>
                                <option>Jakarta Selatan, DKI Jakarta</option>
                                <option>Bandung, Jawa Barat</option>
                            </select>
                            <div class="summary-item-row" style="margin-top: 10px; margin-bottom: 0;">
                                <span style="font-size: 0.78rem; color: #64748B;">Ongkos Kirim</span>
                                <span style="font-size: 0.78rem; color: #16A34A; font-weight: 700;" id="summary-shipping">Rp
                                    15.000</span>
                            </div>
                        </div>

                        <div class="voucher-section">
                            <span style="font-size: 0.78rem; font-weight: 700; color: #1E0A3C;">Voucher</span>

                            @if (session()->has('voucher'))
                                <!-- Tampilan Jika Voucher Sudah Terpasang -->
                                <div
                                    style="display: flex; justify-content: space-between; align-items: center; background: #F1F5F9; padding: 8px 12px; border-radius: 6px; margin-top: 6px;">
                                    <span style="font-size: 0.8rem; font-weight: 700; color: #16A34A;">
                                        <i class="fa-solid fa-ticket"></i> {{ session('voucher')['code'] }}
                                    </span>
                                    <form action="{{ route('cart.remove-voucher') }}" method="POST" style="margin: 0;">
                                        @csrf
                                        <button type="submit"
                                            style="background: none; border: none; color: #EF4444; font-size: 0.75rem; cursor: pointer; font-weight: 700;">Hapus</button>
                                    </form>
                                </div>
                            @else
                                <!-- Form Input Voucher -->
                                <form action="{{ route('cart.apply-voucher') }}" method="POST">
                                    @csrf
                                    <div class="voucher-input-group">
                                        <input type="text" name="code" placeholder="Masukkan kode voucher"
                                            required>
                                        <button type="submit" class="btn-apply-voucher">Terapkan</button>
                                    </div>
                                </form>
                            @endif
                        </div>

                        @php
                            $discountAmount = 0;
                            if (session()->has('voucher')) {
                                $v = session('voucher');
                                $vType = strtolower($v['type'] ?? ($v['discount_type'] ?? 'fixed'));
                                $vVal = $v['discount'] ?? ($v['discount_amount'] ?? ($v['nominal'] ?? 0));

                                if (in_array($vType, ['percent', 'percentage', 'persentase'])) {
                                    $discountAmount = ($subtotalTotal * $vVal) / 100;
                                } else {
                                    $discountAmount = $vVal;
                                }
                            }
                        @endphp

                        <!-- TOTAL AKHIR -->
                        <div class="total-final-row">
                            <div class="total-summary-lines">
                                <div class="summary-item-row" style="margin:0;">
                                    <span style="font-size: 0.75rem; color: #64748B;">Total Belanja (<span
                                            id="selected-count-total">{{ count($cart) }}</span> produk)</span>
                                    <span style="font-size: 0.75rem; font-weight: 600;" id="summary-subtotal-lines">Rp
                                        {{ number_format($subtotalTotal, 0, ',', '.') }}</span>
                                </div>
                                <div class="summary-item-row" style="margin:0;">
                                    <span style="font-size: 0.75rem; color: #64748B;">Ongkos Kirim</span>
                                    <span style="font-size: 0.75rem; font-weight: 600;" id="summary-shipping-lines">Rp
                                        15.000</span>
                                </div>
                                @if (session()->has('voucher'))
                                    <div class="summary-item-row" style="margin:0;">
                                        <span style="font-size: 0.75rem; color: #16A34A; font-weight: 600;">Diskon
                                            Voucher</span>
                                        <span style="font-size: 0.75rem; font-weight: 600; color: #16A34A;"
                                            id="summary-discount-lines">- Rp
                                            {{ number_format($discountAmount, 0, ',', '.') }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="total-final-header">
                                <div class="total-final-title">Total Akhir</div>
                                <div class="total-final-price" id="summary-grand-total">
                                    Rp {{ number_format(max(0, $subtotalTotal + 15000 - $discountAmount), 0, ',', '.') }}
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('checkout.index') }}" class="btn-checkout-primary" id="btn-checkout">
                            <i class="fa-solid fa-bolt"></i> Checkout (<span
                                id="btn-checkout-count">{{ count($cart) }}</span>)
                        </a>
                    </div>

                    <!-- KEAMANAN BELANJA -->
                    <div class="security-widget">
                        <div class="security-widget-title">Keamanan Belanja</div>
                        <div class="security-item">
                            <i class="fa-solid fa-shield-halved"></i>
                            <span>Transaksi 100% Aman</span>
                        </div>
                        <div class="security-item">
                            <i class="fa-solid fa-clock-rotate-left"></i>
                            <span>Garansi Uang Kembali</span>
                        </div>
                        <div class="security-item">
                            <i class="fa-solid fa-truck-fast"></i>
                            <span>Pengiriman Cepat</span>
                        </div>
                    </div>
                </div>

            </div>
        @else
            <!-- STATE KOSONG -->
            <div
                style="background: white; padding: 60px; border-radius: 12px; text-align: center; border: 1px solid #E2E8F0;">
                <i class="fa-solid fa-cart-shopping" style="font-size: 3rem; color: #CBD5E1; margin-bottom: 15px;"></i>
                <h3 style="color: #1E0A3C; font-weight: 800;">Keranjang Belanja Anda Kosong</h3>
                <p style="color: #64748B; font-size: 0.85rem; margin-top: 5px;">Sepertinya Anda belum menambahkan buku
                    apapun ke keranjang.</p>
                <a href="{{ route('catalog.index') }}" class="btn-checkout-primary"
                    style="display: inline-flex; width: auto; padding: 10px 24px; margin-top: 20px;">
                    Mulai Belanja Sekarang
                </a>
            </div>
        @endif

        <!-- FEATURES BANNER -->
        <div class="features-banner">
            <div class="feature-item">
                <div class="feature-icon"><i class="fa-solid fa-shield-halved"></i></div>
                <div>
                    <div class="feature-title">Buku Original</div>
                    <div class="feature-desc">100% buku original dan berkualitas</div>
                </div>
            </div>
            <div class="feature-item">
                <div class="feature-icon"><i class="fa-solid fa-truck-fast"></i></div>
                <div>
                    <div class="feature-title">Pengiriman Cepat</div>
                    <div class="feature-desc">Dikirim ke seluruh Indonesia</div>
                </div>
            </div>
            <div class="feature-item">
                <div class="feature-icon"><i class="fa-solid fa-lock"></i></div>
                <div>
                    <div class="feature-title">Pembayaran Aman</div>
                    <div class="feature-desc">Transaksi aman dengan berbagai metode</div>
                </div>
            </div>
            <div class="feature-item">
                <div class="feature-icon"><i class="fa-solid fa-headset"></i></div>
                <div>
                    <div class="feature-title">Layanan 24/7</div>
                    <div class="feature-desc">Customer service siap membantu Anda</div>
                </div>
            </div>
            <div class="feature-item">
                <div class="feature-icon"><i class="fa-solid fa-box-archive"></i></div>
                <div>
                    <div class="feature-title">Garansi Buku</div>
                    <div class="feature-desc">Garansi ganti buku jika terjadi kerusakan</div>
                </div>
            </div>
        </div>

        <!-- REKOMENDASI UNTUK ANDA -->
        <div class="recommendation-section">
            <div class="recommendation-header">
                <h3 style="font-size: 1.1rem; font-weight: 800; color: #1E0A3C;">Rekomendasi untuk Anda</h3>
                <a href="{{ route('catalog.index') }}"
                    style="font-size: 0.78rem; font-weight: 700; color: #1E0A3C; text-decoration: none;">
                    Lihat Semua <i class="fa-solid fa-chevron-right"></i>
                </a>
            </div>

            <div class="recommendation-grid">
                @forelse ($recommendations as $book)
                    <div class="book-card">
                        <a href="{{ route('books.show', $book->id) }}" style="text-decoration: none; color: inherit;">
                            <img src="{{ $book->cover_image ? asset('storage/' . $book->cover_image) : 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?q=80&w=300' }}"
                                alt="{{ $book->title }}">
                            <div class="book-card-title">{{ $book->title }}</div>
                            <div class="book-card-author">{{ $book->author->name ?? 'Penulis Tidak Diketahui' }}</div>
                            <div class="book-card-price">
                                Rp {{ number_format($book->discount_price ?? $book->price, 0, ',', '.') }}
                            </div>
                        </a>
                        <div class="book-card-stars">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <span style="color:#64748B;">(5.0)</span>
                        </div>

                        <!-- Form Tambah ke Keranjang -->
                        <form action="{{ route('cart.add', $book->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="book-card-btn-cart" title="Tambah ke Keranjang">
                                <i class="fa-solid fa-cart-shopping"></i>
                            </button>
                        </form>
                    </div>
                @empty
                    <p style="grid-column: 1 / -1; font-size: 0.85rem; color: #64748B;">Belum ada rekomendasi buku saat
                        ini.</p>
                @endforelse
            </div>
        </div>

        <!-- NEWSLETTER BANNER -->
        <div class="newsletter-banner">
            <div>
                <h3 style="font-size: 1.1rem; font-weight: 800; margin-bottom: 4px;">Dapatkan Info Terbaru & Promo
                    Eksklusif</h3>
                <p style="font-size: 0.78rem; opacity: 0.8;">Berlangganan newsletter kami dan dapatkan informasi terbaru
                    seputar buku, promo, dan event menarik dari IGAKERTA.</p>
            </div>
            <div class="newsletter-input-wrap">
                <input type="email" placeholder="Masukkan email Anda">
                <button type="button" class="btn-subscribe">Langganan &rsaquo;</button>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <!-- CDN SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function updateQty(id, change) {
            let input = document.getElementById('qty-input-' + id);
            let val = parseInt(input.value) || 1;
            let newVal = val + change;

            if (newVal >= 1) {
                input.value = newVal;
                document.getElementById('qty-form-' + id).submit();
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Setup Toast Mixin SweetAlert2
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

            // Tampilkan Toast jika ada session
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

            const checkAllTop = document.getElementById('check-all-top');
            const checkAllBottom = document.getElementById('check-all-bottom');
            const itemCheckboxes = document.querySelectorAll('.item-check');
            const shippingCost = 15000;
            const voucherInfo = @json(session('voucher', null));

            function formatRupiah(number) {
                return 'Rp ' + new Intl.NumberFormat('id-ID').format(number);
            }

            function updateCartSummary() {
                let totalSubtotal = 0;
                let count = 0;

                itemCheckboxes.forEach(cb => {
                    if (cb.checked) {
                        totalSubtotal += parseFloat(cb.getAttribute('data-price')) || 0;
                        count++;
                    }
                });

                const currentShipping = count > 0 ? shippingCost : 0;

                let discountAmount = 0;
                if (voucherInfo && count > 0) {
                    let vType = (voucherInfo.type || voucherInfo.discount_type || 'fixed').toLowerCase();
                    let vVal = parseFloat(voucherInfo.discount || voucherInfo.discount_amount || voucherInfo
                        .nominal) || 0;

                    if (['percent', 'percentage', 'persentase'].includes(vType)) {
                        discountAmount = (totalSubtotal * vVal) / 100;
                    } else {
                        discountAmount = vVal;
                    }
                }

                const grandTotal = Math.max(0, totalSubtotal + currentShipping - discountAmount);

                // Update UI Teks
                document.getElementById('selected-count').innerText = count;
                document.getElementById('selected-count-total').innerText = count;
                document.getElementById('btn-checkout-count').innerText = count;

                document.getElementById('summary-subtotal').innerText = formatRupiah(totalSubtotal);
                document.getElementById('summary-subtotal-lines').innerText = formatRupiah(totalSubtotal);

                document.getElementById('summary-shipping').innerText = formatRupiah(currentShipping);
                document.getElementById('summary-shipping-lines').innerText = formatRupiah(currentShipping);

                const discountElement = document.getElementById('summary-discount-lines');
                if (discountElement) {
                    discountElement.innerText = '- ' + formatRupiah(discountAmount);
                }

                document.getElementById('summary-grand-total').innerText = formatRupiah(grandTotal);

                // Disable / Enable Tombol Checkout
                const btnCheckout = document.getElementById('btn-checkout');
                if (btnCheckout) {
                    if (count === 0) {
                        btnCheckout.setAttribute('disabled', 'disabled');
                        btnCheckout.style.pointerEvents = 'none';
                        btnCheckout.style.opacity = '0.5';
                    } else {
                        btnCheckout.removeAttribute('disabled');
                        btnCheckout.style.pointerEvents = 'auto';
                        btnCheckout.style.opacity = '1';
                    }
                }
            }

            // Sync Checkbox Master (Top & Bottom)
            function toggleAll(isChecked) {
                itemCheckboxes.forEach(cb => cb.checked = isChecked);
                if (checkAllTop) checkAllTop.checked = isChecked;
                if (checkAllBottom) checkAllBottom.checked = isChecked;
                updateCartSummary();
            }

            if (checkAllTop) {
                checkAllTop.addEventListener('change', function() {
                    toggleAll(this.checked);
                });
            }

            if (checkAllBottom) {
                checkAllBottom.addEventListener('change', function() {
                    toggleAll(this.checked);
                });
            }

            // Event listener untuk checkbox tiap item
            itemCheckboxes.forEach(cb => {
                cb.addEventListener('change', function() {
                    const allChecked = Array.from(itemCheckboxes).every(item => item.checked);
                    if (checkAllTop) checkAllTop.checked = allChecked;
                    if (checkAllBottom) checkAllBottom.checked = allChecked;
                    updateCartSummary();
                });
            });

            // Inisialisasi perhitungan awal
            updateCartSummary();
        });
    </script>
@endpush
