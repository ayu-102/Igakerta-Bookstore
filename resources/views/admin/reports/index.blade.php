@extends('admin.app')

@section('title', 'Laporan Penjualan')

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

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 12px;
            padding: 18px;
        }

        .stat-card .label {
            font-size: 0.75rem;
            font-weight: 700;
            color: #64748B;
            text-transform: uppercase;
        }

        .stat-card .value {
            font-size: 1.35rem;
            font-weight: 800;
            color: #0F172A;
            margin-top: 6px;
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

        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.83rem;
        }

        .data-table th {
            background: #F8FAFC;
            padding: 12px 16px;
            text-align: left;
            color: #475569;
            font-weight: 700;
            font-size: 0.75rem;
            text-transform: uppercase;
            border-bottom: 1px solid #E2E8F0;
        }

        .data-table td {
            padding: 14px 16px;
            border-bottom: 1px solid #F1F5F9;
            color: #1E293B;
            vertical-align: middle;
        }

        @media print {

            .sidebar,
            .topbar,
            .filter-card,
            .btn-print,
            .admin-footer {
                display: none !important;
            }

            .main-wrapper {
                margin: 0 !important;
                padding: 0 !important;
            }

            .main-content {
                padding: 0 !important;
            }
        }
    </style>
@endpush

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h2>Laporan Penjualan</h2>
            <p>Ringkasan transaksi dan pendapatan toko buku Anda</p>
        </div>
        <button onclick="window.print()" class="btn-print"
            style="padding: 10px 18px; background: var(--primary-medium); color: white; border: none; border-radius: 8px; font-weight: 700; cursor: pointer; font-size: 0.83rem;">
            <i class="fa-solid fa-print"></i> Cetak Laporan
        </button>
    </div>

    <!-- STATISTIK RINGKASAN -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="label">Total Pendapatan</div>
            <div class="value" style="color: #059669;">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
        </div>
        <div class="stat-card">
            <div class="label">Total Pesanan</div>
            <div class="value">{{ $totalOrders }}</div>
        </div>
        <div class="stat-card">
            <div class="label">Pesanan Lunas/Selesai</div>
            <div class="value" style="color: #2563EB;">{{ $paidOrders }}</div>
        </div>
        <div class="stat-card">
            <div class="label">Pending</div>
            <div class="value" style="color: #D97706;">{{ $pendingOrders }}</div>
        </div>
    </div>

    <!-- FILTER TANGGAL & STATUS -->
    <div class="filter-card">
        <form action="{{ route('admin.reports.index') }}" method="GET"
            style="display: flex; gap: 12px; align-items: flex-end;">
            <div style="flex: 1;">
                <label
                    style="display: block; font-size: 0.75rem; font-weight: 700; color: #475569; margin-bottom: 4px;">Dari
                    Tanggal</label>
                <input type="date" name="start_date" value="{{ $startDate }}"
                    style="width: 100%; padding: 8px 12px; border: 1px solid #CBD5E1; border-radius: 8px; font-size: 0.83rem;">
            </div>
            <div style="flex: 1;">
                <label
                    style="display: block; font-size: 0.75rem; font-weight: 700; color: #475569; margin-bottom: 4px;">Sampai
                    Tanggal</label>
                <input type="date" name="end_date" value="{{ $endDate }}"
                    style="width: 100%; padding: 8px 12px; border: 1px solid #CBD5E1; border-radius: 8px; font-size: 0.83rem;">
            </div>
            <div style="flex: 1;">
                <label
                    style="display: block; font-size: 0.75rem; font-weight: 700; color: #475569; margin-bottom: 4px;">Status
                    Pesanan</label>
                <select name="status"
                    style="width: 100%; padding: 8px 12px; border: 1px solid #CBD5E1; border-radius: 8px; font-size: 0.83rem;">
                    <option value="all" {{ $status == 'all' ? 'selected' : '' }}>Semua Status</option>
                    <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="paid" {{ $status == 'paid' ? 'selected' : '' }}>Dibayar (Paid)</option>
                    <option value="completed" {{ $status == 'completed' ? 'selected' : '' }}>Selesai (Completed)</option>
                </select>
            </div>
            <button type="submit"
                style="padding: 9px 20px; background: #0F172A; color: white; border: none; border-radius: 8px; font-weight: 700; cursor: pointer; font-size: 0.83rem;">
                <i class="fa-solid fa-filter"></i> Filter
            </button>
        </form>
    </div>

    <!-- TABEL LAPORAN -->
    <div class="table-card">
        <table class="data-table">
            <thead>
                <tr>
                    <th>No. Nota / Pesanan</th>
                    <th>Tanggal</th>
                    <th>Nama Pelanggan</th>
                    <th>Status</th>
                    <th style="text-align: right;">Total Bayar</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td style="font-weight: 700;">#{{ $order->order_number }}</td>
                        <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                        <td>{{ $order->recipient_name }}</td>
                        <td>
                            <span
                                style="font-weight: 700; font-size: 0.72rem; padding: 4px 8px; border-radius: 4px; background: #F1F5F9; color: #334155;">
                                {{ strtoupper($order->status) }}
                            </span>
                        </td>
                        <td style="text-align: right; font-weight: 700;">
                            Rp {{ number_format($order->grand_total, 0, ',', '.') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 30px; color: #94A3B8;">
                            Tidak ada transaksi ditemukan pada rentang tanggal ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
