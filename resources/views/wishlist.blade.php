@extends('layouts.app')

@section('title', 'Wishlist Saya - IGAKERTA Book Store')

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

        /* LEFT SIDE - TABLE CARD */
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

        /* BOTTOM CONTROL */
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
            <a href="{{ route('home') }}">Beranda</a> &rsaquo; <span>Wishlist Saya</span>
        </div>

        <h1 class="page-header-title">Wishlist Saya</h1>

        @if (!empty($wishlist) && count($wishlist) > 0)
            <div class="cart-main-grid">

                <!-- KIRI: TABEL WISHLIST -->
                <div>
                    <div class="cart-table-card">
                        <table class="cart-table">
                            <colgroup>
                                <col style="width: 40px;"> <!-- Checkbox -->
                                <col style="width: auto;"> <!-- Produk -->
                                <col style="width: 140px;"> <!-- Harga -->
                                <col style="width: 50px;"> <!-- Aksi -->
                            </colgroup>

                            <thead>
                                <tr>

                                    <th style="text-align: left;">Produk</th>
                                    <th style="text-align: right;">Harga</th>
                                    <th style="text-align: center;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($wishlist as $id => $item)
                                    @php
                                        $itemPrice = $item['price'] ?? 0;
                                    @endphp
                                    <tr data-id="{{ $id }}">
                                        <!-- Checkbox -->
                                        <td style="text-align: center;">
                                            <input type="checkbox" class="custom-checkbox item-check"
                                                data-price="{{ $itemPrice }}" checked>
                                        </td>

                                        <!-- Produk -->
                                        <td>
                                            <div class="item-info-flex">
                                                <img src="{{ !empty($item['cover_image']) ? asset('storage/' . $item['cover_image']) : 'https://via.placeholder.com/150x200?text=No+Cover' }}"
                                                    alt="{{ $item['title'] ?? 'Judul Buku' }}">
                                                <div>
                                                    <div class="item-title">{{ $item['title'] ?? 'Judul Buku' }}</div>
                                                    <div class="item-author">{{ $item['author'] ?? 'Penulis Buku' }}</div>
                                                    <div class="item-stock-tag">• Tersedia</div>
                                                    <div class="item-quick-actions">
                                                        <form action="{{ route('wishlist.moveToCart', $id) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            <button type="submit">Pindahkan ke Keranjang</button>
                                                        </form>
                                                        <span>|</span>
                                                        <form action="{{ route('wishlist.remove', $id) }}" method="POST"
                                                            style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit">Hapus</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Harga -->
                                        <td style="text-align: right;" class="price-text">
                                            Rp {{ number_format($itemPrice, 0, ',', '.') }}
                                        </td>

                                        <!-- Aksi (Ikon Hapus) -->
                                        <td style="text-align: center;">
                                            <form action="{{ route('wishlist.remove', $id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-trash-action" title="Hapus dari Wishlist">
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

                <!-- KANAN: RINGKASAN WISHLIST -->
                <div>
                    <div class="summary-card">
                        <h3 class="summary-card-title">Ringkasan Wishlist</h3>

                        <div class="summary-item-row">
                            <span>Total Barang</span>
                            <strong id="summary-total-items">0 produk</strong>
                        </div>

                        <div class="summary-item-row">
                            <span>Total Estimasi</span>
                            <strong id="summary-total-price">Rp 0</strong>
                        </div>

                        <a href="{{ route('catalog.index') }}" class="btn-checkout-primary">
                            <i class="fa-solid fa-cart-plus"></i> Tambah Lebih Banyak
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
                <i class="fa-solid fa-heart-crack" style="font-size: 3rem; color: #CBD5E1; margin-bottom: 15px;"></i>
                <h3 style="color: #1E0A3C; font-weight: 800;">Wishlist Kamu Masih Kosong</h3>
                <p style="color: #64748B; font-size: 0.85rem; margin-top: 5px;">Simpan buku impianmu di sini untuk dibeli
                    nanti!</p>
                <a href="{{ route('catalog.index') }}" class="btn-checkout-primary"
                    style="display: inline-flex; width: auto; padding: 10px 24px; margin-top: 20px;">
                    Jelajahi Katalog
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
                            <img src="{{ $book->cover_image ? asset('storage/' . $book->cover_image) : 'https://via.placeholder.com/300x300?text=No+Cover' }}"
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

            // Tampilkan SweetAlert Toast jika ada flash session dari Controller
            @if (session('success'))
                Toast.fire({
                    icon: 'success',
                    title: "{!! session('success') !!}"
                });
            @endif

            @if (session('info'))
                Toast.fire({
                    icon: 'info',
                    title: "{!! session('info') !!}"
                });
            @endif

            @if (session('error'))
                Toast.fire({
                    icon: 'error',
                    title: "{!! session('error') !!}"
                });
            @endif

            // Element Selectors
            const checkAllTop = document.getElementById('check-all-top');
            const checkAllBottom = document.getElementById('check-all-bottom');
            const itemCheckboxes = document.querySelectorAll('.item-check');
            const summaryTotalItems = document.getElementById('summary-total-items');
            const summaryTotalPrice = document.getElementById('summary-total-price');
            const btnDeleteBulk = document.getElementById('btn-delete-bulk');

            // Format Rupiah
            function formatRupiah(number) {
                return 'Rp ' + number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }

            // Hitung Ulang Ringkasan Wishlist (Real-time)
            function updateSummary() {
                let totalItems = 0;
                let totalPrice = 0;

                itemCheckboxes.forEach(cb => {
                    if (cb.checked) {
                        totalItems++;
                        totalPrice += parseFloat(cb.getAttribute('data-price')) || 0;
                    }
                });

                if (summaryTotalItems) summaryTotalItems.textContent = `${totalItems} produk`;
                if (summaryTotalPrice) summaryTotalPrice.textContent = formatRupiah(totalPrice);

                // Update master checkbox status
                const allChecked = itemCheckboxes.length > 0 && Array.from(itemCheckboxes).every(cb => cb.checked);
                if (checkAllTop) checkAllTop.checked = allChecked;
                if (checkAllBottom) checkAllBottom.checked = allChecked;
            }

            // Event listener checkbox Select All
            function toggleAll(isChecked) {
                itemCheckboxes.forEach(cb => {
                    cb.checked = isChecked;
                });
                if (checkAllTop) checkAllTop.checked = isChecked;
                if (checkAllBottom) checkAllBottom.checked = isChecked;
                updateSummary();
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

            itemCheckboxes.forEach(cb => {
                cb.addEventListener('change', updateSummary);
            });

            // Jalankan hitung awal
            updateSummary();

            // Aksi Hapus yang Dipilih (Bulk Delete)
            if (btnDeleteBulk) {
                btnDeleteBulk.addEventListener('click', function() {
                    const selectedCheckboxes = document.querySelectorAll('.item-check:checked');

                    if (selectedCheckboxes.length === 0) {
                        Toast.fire({
                            icon: 'warning',
                            title: 'Pilih setidaknya satu buku untuk dihapus.'
                        });
                        return;
                    }

                    Swal.fire({
                        title: 'Hapus dari Wishlist?',
                        text: `Anda yakin ingin menghapus ${selectedCheckboxes.length} buku yang dipilih?`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#1E0A3C',
                        cancelButtonColor: '#CBD5E1',
                        confirmButtonText: 'Ya, Hapus',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Eksekusi submit hapus untuk baris tercentang
                            selectedCheckboxes.forEach(cb => {
                                const row = cb.closest('tr');
                                const deleteForm = row.querySelector(
                                    'form[action*="wishlist.remove"]');
                                if (deleteForm) {
                                    deleteForm.submit();
                                }
                            });
                        }
                    });
                });
            }
        });
    </script>
@endpush
