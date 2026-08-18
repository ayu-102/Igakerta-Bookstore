@extends('admin.app')

@section('title', 'Kelola Pesanan')

@push('styles')
    <style>
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .page-title h2 {
            font-size: 1.35rem;
            font-weight: 800;
            color: #0F172A;
            margin: 0 0 4px 0;
        }

        .page-title p {
            font-size: 0.85rem;
            color: #64748B;
            margin: 0;
        }

        .status-tabs {
            display: flex;
            gap: 8px;
            margin-bottom: 20px;
            border-bottom: 1px solid #E2E8F0;
            padding-bottom: 12px;
            overflow-x: auto;
        }

        .tab-item {
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 0.825rem;
            font-weight: 600;
            text-decoration: none;
            color: #64748B;
            background: #F1F5F9;
            transition: all 0.2s;
            white-space: nowrap;
        }

        .tab-item:hover {
            background: #E2E8F0;
            color: #1E293B;
        }

        .tab-item.active {
            background: var(--primary-medium, #4F46E5);
            color: #FFFFFF;
        }

        .tab-count {
            background: rgba(255, 255, 255, 0.2);
            padding: 2px 6px;
            border-radius: 12px;
            font-size: 0.72rem;
            margin-left: 4px;
        }

        .filter-card {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 20px;
        }

        .table-card {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 12px;
            overflow: hidden;
        }

        .order-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.83rem;
        }

        .order-table th {
            background: #F8FAFC;
            padding: 12px 16px;
            text-align: left;
            color: #475569;
            font-weight: 700;
            font-size: 0.75rem;
            text-transform: uppercase;
            border-bottom: 1px solid #E2E8F0;
        }

        .order-table td {
            padding: 14px 16px;
            border-bottom: 1px solid #F1F5F9;
            color: #1E293B;
            vertical-align: middle;
        }

        .badge-status {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.72rem;
            font-weight: 700;
            display: inline-block;
            text-transform: capitalize;
        }

        .badge-pending {
            background: #FEF3C7;
            color: #D97706;
            border: 1px solid #FDE68A;
        }

        .badge-paid {
            background: #E0F2FE;
            color: #0284C7;
            border: 1px solid #BAE6FD;
        }

        .badge-shipped {
            background: #F5EFFF;
            color: #2D1558;
            border: 1px solid #DDD6FE;
        }

        .badge-completed {
            background: #ECFDF5;
            color: #10B981;
            border: 1px solid #A7F3D0;
        }

        .badge-cancelled {
            background: #FEF2F2;
            color: #EF4444;
            border: 1px solid #FECACA;
        }

        .btn-detail {
            padding: 6px 12px;
            background: #F1F5F9;
            color: var(--primary-medium, #4F46E5);
            border-radius: 6px;
            font-weight: 700;
            text-decoration: none;
            font-size: 0.78rem;
            transition: all 0.2s;
        }

        .btn-detail:hover {
            background: var(--primary-medium, #4F46E5);
            color: white;
        }

        .btn-sync {
            padding: 6px 12px;
            background: #E0F2FE;
            color: #0284C7;
            border-radius: 6px;
            font-weight: 700;
            text-decoration: none;
            font-size: 0.78rem;
            transition: all 0.2s;
            margin-left: 4px;
        }

        .btn-sync:hover {
            background: #0284C7;
            color: white;
        }

        /* STYLING KHUSUS FIX PAGINATION TUMPANG TINDIH */
        .pagination-container {
            margin-top: 24px;
            background: #FFFFFF;
            padding: 14px 20px;
            border-radius: 12px;
            border: 1px solid #E2E8F0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .pagination {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
            gap: 6px;
            align-items: center;
        }

        .pagination .page-item .page-link {
            padding: 8px 14px;
            font-size: 0.82rem;
            font-weight: 600;
            color: #475569;
            background: #F8FAFC;
            border: 1px solid #E2E8F0;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.2s;
            display: inline-block;
        }

        .pagination .page-item.active .page-link {
            background: var(--primary-medium, #4F46E5);
            color: #FFFFFF;
            border-color: var(--primary-medium, #4F46E5);
        }

        .pagination .page-item.disabled .page-link {
            color: #CBD5E1;
            background: #F1F5F9;
            border-color: #E2E8F0;
            cursor: not-allowed;
        }

        .pagination .page-item .page-link:hover:not(.disabled) {
            background: var(--primary-medium, #4F46E5);
            color: #FFFFFF;
            border-color: var(--primary-medium, #4F46E5);
        }

        .btn-reset {
            padding: 10px 16px;
            border: 1px solid #CBD5E1;
            border-radius: 8px;
            font-size: 0.83rem;
            font-weight: 600;
            color: #64748B;
            background: #F8FAFC;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
            white-space: nowrap;
        }

        .btn-reset:hover {
            background: #F1F5F9;
            color: #EF4444;
            border-color: #FECACA;
        }
    </style>
@endpush

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h2>Kelola Pesanan</h2>
            <p>Pantau dan perbarui status transaksi masuk dari pembeli</p>
        </div>
    </div>

    @if (session('success'))
        <div
            style="padding: 12px 16px; background: #ECFDF5; border: 1px solid #A7F3D0; color: #065F46; border-radius: 8px; margin-bottom: 20px; font-size: 0.85rem;">
            <i class="fa-solid fa-circle-check" style="margin-right: 6px;"></i> {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div
            style="padding: 12px 16px; background: #FEF2F2; border: 1px solid #FECACA; color: #991B1B; border-radius: 8px; margin-bottom: 20px; font-size: 0.85rem;">
            <i class="fa-solid fa-circle-xmark" style="margin-right: 6px;"></i> {{ session('error') }}
        </div>
    @endif

    @if (session('info'))
        <div
            style="padding: 12px 16px; background: #FEF3C7; border: 1px solid #FDE68A; color: #92400E; border-radius: 8px; margin-bottom: 20px; font-size: 0.85rem;">
            <i class="fa-solid fa-circle-info" style="margin-right: 6px;"></i> {{ session('info') }}
        </div>
    @endif

    <!-- TAB STATUS FILTER -->
    <div class="status-tabs">
        <a href="{{ route('admin.orders.index') }}"
            class="tab-item {{ !request('status') || request('status') == 'all' ? 'active' : '' }}">
            Semua Pesanan <span class="tab-count">{{ $counts['all'] }}</span>
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}"
            class="tab-item {{ request('status') == 'pending' ? 'active' : '' }}">
            Menunggu Pembayaran <span class="tab-count">{{ $counts['pending'] }}</span>
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'paid']) }}"
            class="tab-item {{ request('status') == 'paid' ? 'active' : '' }}">
            Perlu Dikirim <span class="tab-count">{{ $counts['paid'] }}</span>
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'shipped']) }}"
            class="tab-item {{ request('status') == 'shipped' ? 'active' : '' }}">
            Dikirim <span class="tab-count">{{ $counts['shipped'] }}</span>
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'completed']) }}"
            class="tab-item {{ request('status') == 'completed' ? 'active' : '' }}">
            Selesai <span class="tab-count">{{ $counts['completed'] }}</span>
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'cancelled']) }}"
            class="tab-item {{ request('status') == 'cancelled' ? 'active' : '' }}">
            Dibatalkan <span class="tab-count">{{ $counts['cancelled'] }}</span>
        </a>
    </div>

    <!-- SEARCH BAR -->
    <div class="filter-card">
        <form action="{{ route('admin.orders.index') }}" method="GET" style="display: flex; gap: 12px; width: 100%;">
            @if (request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif

            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Cari No. Pesanan, Nama Penerima, atau No. WA..."
                style="flex: 1; padding: 10px 14px; border: 1px solid #CBD5E1; border-radius: 8px; font-size: 0.83rem; outline: none;">

            <button type="submit"
                style="padding: 10px 20px; background: var(--primary-medium, #4F46E5); color: white; border: none; border-radius: 8px; font-weight: 700; cursor: pointer; font-size: 0.83rem; display: inline-flex; align-items: center; gap: 6px;">
                <i class="fa-solid fa-magnifying-glass"></i> Cari
            </button>

            @if (request('search'))
                <a href="{{ route('admin.orders.index', request('status') ? ['status' => request('status')] : []) }}"
                    class="btn-reset" title="Reset Pencarian">
                    <i class="fa-solid fa-rotate-right"></i> Reset
                </a>
            @endif
        </form>
    </div>

    <!-- TABEL PESANAN -->
    <div class="table-card">
        <table class="order-table">
            <thead>
                <tr>
                    <th>No. Pesanan</th>
                    <th>Tanggal</th>
                    <th>Penerima</th>
                    <th>Total Tagihan</th>
                    <th>Metode Bayar</th>
                    <th>Status</th>
                    <th style="text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>
                            <strong style="color: var(--primary-dark, #312E81);">{{ $order->order_number }}</strong>
                        </td>
                        <td>{{ $order->created_at->format('d M Y, H:i') }}</td>
                        <td>
                            <div style="font-weight: 700;">{{ $order->recipient_name }}</div>
                            <div style="font-size: 0.75rem; color: #64748B;">{{ $order->phone_number }}</div>
                        </td>
                        <td style="font-weight: 800; color: #0F172A;">
                            Rp {{ number_format($order->grand_total, 0, ',', '.') }}
                        </td>
                        <td>
                            <span
                                style="font-size: 0.78rem; background: #F1F5F9; padding: 2px 8px; border-radius: 4px; font-weight: 600;">
                                {{ strtoupper($order->payment_method) }}
                            </span>
                        </td>
                        <td>
                            @php
                                $statusClasses = [
                                    'pending' => 'badge-pending',
                                    'paid' => 'badge-paid',
                                    'shipped' => 'badge-shipped',
                                    'completed' => 'badge-completed',
                                    'cancelled' => 'badge-cancelled',
                                ];
                                $statusLabels = [
                                    'pending' => 'Menunggu Pembayaran',
                                    'paid' => 'Perlu Dikirim',
                                    'shipped' => 'Dikirim',
                                    'completed' => 'Selesai',
                                    'cancelled' => 'Dibatalkan',
                                ];
                            @endphp
                            <span class="badge-status {{ $statusClasses[$order->status] ?? 'badge-pending' }}">
                                {{ $statusLabels[$order->status] ?? $order->status }}
                            </span>
                        </td>
                        <td style="text-align: center;">
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn-detail">
                                <i class="fa-solid fa-eye"></i> Detail
                            </a>

                            @if ($order->status == 'pending')
                                <a href="{{ route('admin.orders.checkStatus', $order->id) }}" class="btn-sync"
                                    title="Cek Status Pembayaran ke Midtrans">
                                    <i class="fa-solid fa-rotate"></i> Cek Status
                                </a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 30px; color: #94A3B8;">
                            <i class="fa-solid fa-inbox" style="font-size: 2rem; margin-bottom: 8px; display: block;"></i>
                            Belum ada data pesanan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- PAGINATION RAPI (TANPA TUMPANG TINDIH) -->
    @if ($orders->hasPages())
        <div class="pagination-container">
            {{ $orders->links('pagination::bootstrap-4') }}
        </div>
    @endif
@endsection
