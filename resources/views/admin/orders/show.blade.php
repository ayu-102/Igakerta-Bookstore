@extends('admin.app')

@section('title', 'Detail Pesanan #' . $order->order_number)

@push('styles')
    <style>
        .detail-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
        }

        .card-box {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .card-title {
            font-size: 0.95rem;
            font-weight: 800;
            color: #0F172A;
            margin-bottom: 16px;
            border-bottom: 1px solid #F1F5F9;
            padding-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .item-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #F8FAFC;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 6px 0;
            font-size: 0.85rem;
            color: #475569;
        }

        .point-box {
            background: #EFF6FF;
            border: 1px solid #BFDBFE;
            border-radius: 8px;
            padding: 12px;
            margin-top: 12px;
            font-size: 0.8rem;
            color: #1E40AF;
        }
    </style>
@endpush

@section('content')
    <div style="margin-bottom: 20px;">
        <a href="{{ route('admin.orders.index') }}"
            style="text-decoration: none; color: var(--primary-medium); font-weight: 700; font-size: 0.83rem;">
            &larr; Kembali ke Daftar Pesanan
        </a>
    </div>

    <div class="detail-grid">
        <div>
            <!-- ITEM PESANAN -->
            <div class="card-box">
                <div class="card-title">
                    <span>Rincian Buku yang Dibelikan ({{ $order->items->count() }} item)</span>
                    <span style="font-size: 0.8rem; color: #64748B;">No: {{ $order->order_number }}</span>
                </div>
                @foreach ($order->items as $item)
                    <div class="item-row">
                        <div>
                            <strong style="color: #0F172A; font-size: 0.875rem;">{{ $item->book_title }}</strong>
                            <div style="font-size: 0.78rem; color: #64748B;">Rp
                                {{ number_format($item->price, 0, ',', '.') }} &times; {{ $item->quantity }} eksemplar</div>
                        </div>
                        <div style="font-weight: 800; color: #0F172A;">
                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                        </div>
                    </div>
                @endforeach

                <div style="margin-top: 20px; padding-top: 10px; border-top: 1px solid #E2E8F0;">
                    <div class="summary-row">
                        <span>Subtotal Produk</span>
                        <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="summary-row">
                        <span>Biaya Pengiriman ({{ $order->shipping_method }})</span>
                        <span>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                    </div>

                    {{-- DISKON VOUCHER --}}
                    @if ($order->discount > 0)
                        <div class="summary-row" style="color: #EF4444;">
                            <span>Diskon Voucher</span>
                            <span>- Rp {{ number_format($order->discount, 0, ',', '.') }}</span>
                        </div>
                    @endif

                    {{-- DISKON POTONGAN POIN --}}
                    @if ($order->points_discount > 0)
                        <div class="summary-row" style="color: #D97706; font-weight: 600;">
                            <span>Potongan Poin ({{ number_format($order->points_used) }} Pts)</span>
                            <span>- Rp {{ number_format($order->points_discount, 0, ',', '.') }}</span>
                        </div>
                    @endif

                    <div class="summary-row"
                        style="font-weight: 800; font-size: 1rem; color: var(--primary-dark); margin-top: 8px;">
                        <span>Total Pembayaran</span>
                        <span>Rp {{ number_format($order->grand_total, 0, ',', '.') }}</span>
                    </div>

                    {{-- ESTIMASI / PEROLEHAN POIN KONSUMEN --}}
                    @if ($order->points_earned > 0)
                        <div class="point-box">
                            <i class="fa-solid fa-coins me-1" style="color: #F59E0B;"></i>
                            <strong>Perolehan Poin:</strong> Pelanggan ini mendapatkan
                            <strong>+{{ number_format($order->points_earned) }} Poin</strong> dari transaksi ini.
                        </div>
                    @endif
                </div>
            </div>

            <!-- ALAMAT PENGIRIMAN -->
            <div class="card-box">
                <div class="card-title">Alamat & Informasi Pengiriman</div>
                <p style="margin: 0 0 6px 0; font-weight: 700; color: #0F172A;">{{ $order->recipient_name }}
                    ({{ $order->phone_number }})</p>
                <p style="margin: 0; color: #475569; font-size: 0.85rem; line-height: 1.5;">
                    {{ $order->address_detail }}<br>
                    {{ $order->city }}, {{ $order->province }} - {{ $order->postal_code }}
                </p>
                @if ($order->notes)
                    <div
                        style="margin-top: 12px; padding: 10px; background: #FFFBEB; border: 1px solid #FCD34D; border-radius: 6px; font-size: 0.8rem; color: #92400E;">
                        <strong>Catatan Pemesan:</strong> {{ $order->notes }}
                    </div>
                @endif
            </div>
        </div>

        <!-- UPDATE STATUS & INFORMASI -->
        <div>
            <div class="card-box">
                <div class="card-title">Update Status Pesanan</div>
                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div style="margin-bottom: 16px;">
                        <label
                            style="font-size: 0.78rem; font-weight: 700; color: #475569; display: block; margin-bottom: 6px;">Status
                            Saat Ini</label>
                        <select name="status"
                            style="width: 100%; padding: 10px; border: 1px solid #CBD5E1; border-radius: 8px; font-size: 0.83rem; font-weight: 600;">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Menunggu Pembayaran
                            </option>
                            <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>Sudah Dibayar (Proses
                                Packing)</option>
                            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Dikirim</option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Selesai
                            </option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Dibatalkan
                            </option>
                        </select>
                    </div>
                    <button type="submit"
                        style="width: 100%; padding: 10px; background: var(--primary-medium); color: white; border: none; border-radius: 8px; font-weight: 700; cursor: pointer; font-size: 0.83rem;">
                        Simpan Perubahan
                    </button>
                </form>
            </div>

            <div class="card-box">
                <div class="card-title">Metode Pembayaran</div>
                <p style="margin: 0; font-weight: 700; color: #0F172A; font-size: 0.9rem;">
                    {{ strtoupper($order->payment_method) }}
                </p>
            </div>
        </div>
    </div>
@endsection
