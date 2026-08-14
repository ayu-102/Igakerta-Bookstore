@extends('layouts.app')

@section('title', 'Promo & Kupon Spesial - IGAKERTA')

@push('styles')
    <style>
        /* BANNER HEADER DESIGN (HERO BACKGROUND STYLE) */
        .promo-header {
            background: linear-gradient(90deg, #18003C 0%, #290858 55%, rgba(41, 8, 88, 0.45) 100%),
                url('https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?q=80&w=1200&auto=format&fit=crop') center / cover no-repeat;
            border-radius: 16px;
            color: white;
            padding: 35px 45px;
            margin: 1% 6% 30px 6%;
            width: auto;
            position: relative;
            overflow: hidden;
            box-sizing: border-box;
            min-height: 160px;
            display: flex;
            align-items: center;
        }

        .promo-header-content {
            max-width: 650px;
            position: relative;
            z-index: 2;
        }

        .breadcrumb-item {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 8px;
        }

        .breadcrumb-item a {
            color: #FFC000;
            text-decoration: none;
            font-weight: 600;
        }

        .promo-subtitle-badge {
            color: #FFC000;
            font-size: 0.75rem;
            font-weight: 800;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            margin-bottom: 4px;
            display: inline-block;
        }

        .promo-header h1 {
            font-size: 1.85rem;
            font-weight: 800;
            margin-bottom: 8px;
            color: #FFFFFF;
            letter-spacing: -0.5px;
            line-height: 1.2;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .promo-header p {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.9);
            line-height: 1.5;
            margin: 0;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
        }

        /* CONTAINER KONTEN */
        .promo-container {
            padding: 0 6% 40px;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 800;
            color: #1E293B;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* VOUCHER GRID */
        .voucher-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 20px;
            margin-bottom: 45px;
        }

        .voucher-card {
            background: #FFFFFF;
            border: 2px dashed #CBD5E1;
            border-radius: 12px;
            padding: 18px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.03);
            transition: transform 0.2s, border-color 0.2s;
        }

        .voucher-card:hover {
            transform: translateY(-3px);
            border-color: #23085A;
        }

        .voucher-badge {
            font-size: 0.7rem;
            font-weight: 800;
            background: #EDE9FE;
            color: #23085A;
            padding: 3px 8px;
            border-radius: 4px;
            display: inline-block;
            margin-bottom: 6px;
        }

        .btn-copy-code {
            background: #23085A;
            color: white;
            border: none;
            padding: 8px 14px;
            border-radius: 8px;
            font-size: 0.78rem;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-copy-code:hover {
            background: #4A1996;
        }

        /* BOOK PROMO GRID */
        .books-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
        }

        .book-card {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 12px;
            padding: 14px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .book-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.06);
        }

        .book-thumb-box {
            position: relative;
            width: 100%;
            height: 200px;
            background: #F8FAFC;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 12px;
        }

        .book-thumb-box img {
            max-height: 90%;
            max-width: 90%;
            object-fit: contain;
        }

        .badge-diskon {
            position: absolute;
            top: 8px;
            left: 8px;
            background: #EF4444;
            color: white;
            font-size: 0.65rem;
            font-weight: 800;
            padding: 3px 7px;
            border-radius: 4px;
        }

        .card-price-main {
            font-size: 0.95rem;
            font-weight: 800;
            color: #1E293B;
        }

        .card-price-old {
            font-size: 0.72rem;
            color: #94A3B8;
            text-decoration: line-through;
            margin-left: 4px;
        }
    </style>
@endpush

@section('content')
    <!-- BANNER HEADER -->
    <div class="promo-header">
        <div class="promo-header-content">
            <div class="breadcrumb-item">
                <a href="{{ route('home') }}">Beranda</a> &gt; <span>Promo & Voucher</span>
            </div>
            <span class="promo-subtitle-badge">Penawaran Spesial</span>
            <h1>Promo & Voucher Belanja</h1>
            <p>Gunakan kode voucher dan nikmati harga spesial untuk buku-buku pilihan.</p>
        </div>
    </div>

    <div class="promo-container">
        <!-- VOUCHER SECTION -->
        <h2 class="section-title">
            <i class="fa-solid fa-ticket" style="color: #23085A;"></i> Voucher Belanja Aktif
        </h2>

        @if ($vouchers->count() > 0)
            <div class="voucher-grid">
                @foreach ($vouchers as $voucher)
                    <div class="voucher-card">
                        <div>
                            <span class="voucher-badge">
                                {{ $voucher->type == 'percentage' ? 'DISKON ' . (int) $voucher->amount . '%' : 'POTONGAN Rp ' . number_format($voucher->amount, 0, ',', '.') }}
                            </span>
                            <h3 style="font-size: 0.95rem; font-weight: 800; margin: 4px 0; color: #1E293B;">
                                {{ $voucher->title }}</h3>
                            <p style="font-size: 0.75rem; color: #64748B; margin: 0 0 6px 0;">Min. Belanja: Rp
                                {{ number_format($voucher->min_purchase, 0, ',', '.') }}</p>
                            @if ($voucher->expiry_date)
                                <small style="font-size: 0.7rem; color: #EF4444;"><i class="fa-regular fa-clock"></i> s.d.
                                    {{ $voucher->expiry_date->format('d M Y') }}</small>
                            @endif
                        </div>
                        <div>
                            <button class="btn-copy-code" onclick="copyVoucherCode(this, '{{ $voucher->code }}')">
                                {{ $voucher->code }}
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div
                style="background: #F8FAFC; border: 1px dashed #CBD5E1; padding: 20px; border-radius: 8px; text-align: center; margin-bottom: 40px; color: #64748B; font-size: 0.85rem;">
                Belum ada voucher aktif saat ini.
            </div>
        @endif

        <!-- BUKU DISKON SECTION -->
        <h2 class="section-title">
            <i class="fa-solid fa-tags" style="color: #23085A;"></i> Buku Harga Spesial
        </h2>

        @if ($promoBooks->count() > 0)
            <div class="books-grid">
                @foreach ($promoBooks as $book)
                    <div class="book-card">
                        <div>
                            <a href="{{ route('books.show', $book->id) }}">
                                <div class="book-thumb-box">
                                    <span class="badge-diskon">PROMO</span>
                                    <img src="{{ $book->cover_image ? asset('storage/' . $book->cover_image) : 'https://via.placeholder.com/150x200?text=No+Cover' }}"
                                        alt="{{ $book->title }}">
                                </div>
                            </a>
                            <h3 style="font-size: 0.85rem; font-weight: 700; margin-bottom: 4px; line-height: 1.3;">
                                <a href="{{ route('books.show', $book->id) }}"
                                    style="color: #1E293B; text-decoration: none;">{{ $book->title }}</a>
                            </h3>

                            <!-- PERBAIKAN DI SINI: panggil nama penulisnya saja -->
                            <div style="font-size: 0.72rem; color: #64748B; margin-bottom: 8px;">
                                {{ is_object($book->author) ? $book->author->name : $book->author }}
                            </div>
                        </div>

                        <div>
                            <div style="margin-bottom: 10px;">
                                <span class="card-price-main">Rp
                                    {{ number_format($book->discount_price ?? $book->price, 0, ',', '.') }}</span>
                                @if (isset($book->discount_price) && $book->discount_price < $book->price)
                                    <span class="card-price-old">Rp {{ number_format($book->price, 0, ',', '.') }}</span>
                                @endif
                            </div>

                            <form action="{{ route('cart.add', $book->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    style="width: 100%; background: #23085A; color: white; border: none; padding: 8px; border-radius: 6px; font-weight: 700; font-size: 0.8rem; cursor: pointer;">
                                    + Keranjang
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <div style="margin-top: 30px;">
                {{ $promoBooks->links() }}
            </div>
        @else
            <div
                style="background: #F8FAFC; border: 1px dashed #CBD5E1; padding: 30px; border-radius: 8px; text-align: center; color: #64748B; font-size: 0.85rem;">
                Belum ada buku promo saat ini.
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        function copyVoucherCode(buttonElement, code) {
            navigator.clipboard.writeText(code);
            const originalText = buttonElement.innerText;
            buttonElement.innerText = 'Tersalin! ✓';
            buttonElement.style.backgroundColor = '#16A34A';

            setTimeout(() => {
                buttonElement.innerText = originalText;
                buttonElement.style.backgroundColor = '';
            }, 2000);
        }
    </script>
@endpush
