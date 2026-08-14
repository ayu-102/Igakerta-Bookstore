@extends('admin.app')

@section('title', 'Kelola Voucher')

@push('styles')
    <style>
        .voucher-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .voucher-header h2 {
            font-size: 1.4rem;
            font-weight: 800;
            color: var(--primary-dark);
            margin: 0;
        }

        .btn-add-voucher {
            background: var(--primary-medium);
            color: #FFFFFF;
            padding: 9px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 0.83rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
        }

        .btn-add-voucher:hover {
            background: var(--primary-dark);
            color: var(--accent-yellow);
        }

        .card-voucher {
            background: #FFFFFF;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
        }

        .table-voucher {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.83rem;
        }

        .table-voucher thead {
            background: #F8FAFC;
            border-bottom: 1px solid var(--border-color);
        }

        .table-voucher th {
            padding: 12px 16px;
            text-align: left;
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-muted);
            font-weight: 700;
        }

        .table-voucher td {
            padding: 14px 16px;
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
            color: var(--text-main);
        }

        .table-voucher tr:last-child td {
            border-bottom: none;
        }

        .badge-code {
            background: var(--primary-medium);
            color: var(--accent-yellow);
            font-family: monospace;
            font-size: 0.85rem;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 6px;
            letter-spacing: 0.5px;
            display: inline-block;
        }

        .badge-type {
            background: #F1F5F9;
            color: #475569;
            font-size: 0.72rem;
            font-weight: 700;
            padding: 4px 8px;
            border-radius: 4px;
            text-transform: uppercase;
        }

        /* --- STYLE STATUS MODERN --- */
        .btn-status-toggle {
            border: 1px solid transparent;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-status-active {
            background: #ECFDF5;
            color: #059669;
            border-color: #A7F3D0;
        }

        .btn-status-active:hover {
            background: #D1FAE5;
        }

        .btn-status-inactive {
            background: #F1F5F9;
            color: #64748B;
            border-color: #CBD5E1;
        }

        .btn-status-inactive:hover {
            background: #E2E8F0;
        }

        .status-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            display: inline-block;
        }

        .btn-status-active .status-dot {
            background-color: #10B981;
        }

        .btn-status-inactive .status-dot {
            background-color: #94A3B8;
        }

        /* --- STYLE AKSI MODERN --- */
        .btn-action-edit {
            color: #64748B;
            background: transparent;
            width: 34px;
            height: 34px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-action-edit:hover {
            background: #F1F5F9;
            color: #0F172A;
        }

        .btn-action-delete {
            color: #64748B;
            background: transparent;
            width: 34px;
            height: 34px;
            border-radius: 8px;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-action-delete:hover {
            background: #F1F5F9;
            color: #0F172A;
        }

        .alert-custom-success {
            background: #ECFDF5;
            border: 1px solid #A7F3D0;
            color: #065F46;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 0.83rem;
            font-weight: 600;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
@endpush

@section('content')
    <div>
        <!-- HEADER -->
        <div class="voucher-header">
            <div>
                <h2>Kelola Voucher</h2>
                <p style="font-size: 0.8rem; color: var(--text-muted); margin-top: 2px;">Kelola kode diskon dan kupon promo
                    untuk pelanggan toko buku.</p>
            </div>
            <a href="{{ route('admin.vouchers.create') }}" class="btn-add-voucher">
                <i class="fa-solid fa-plus"></i> Tambah Voucher
            </a>
        </div>

        <!-- NOTIFIKASI SUKSES -->
        @if (session('success'))
            <div class="alert-custom-success">
                <div>
                    <i class="fa-solid fa-circle-check" style="margin-right: 6px;"></i>
                    {{ session('success') }}
                </div>
                <button type="button" onclick="this.parentElement.remove()"
                    style="background:none; border:none; color:#065F46; cursor:pointer; font-weight:bold;">&times;</button>
            </div>
        @endif

        <!-- TABEL VOUCHER -->
        <div class="card-voucher">
            <div style="overflow-x: auto;">
                <table class="table-voucher">
                    <thead>
                        <tr>
                            <th>Kode Voucher</th>
                            <th>Judul Promo</th>
                            <th>Tipe</th>
                            <th>Nominal / %</th>
                            <th>Min. Belanja</th>
                            <th>Tgl Kadaluarsa</th>
                            <th>Status</th>
                            <th style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($vouchers as $voucher)
                            <tr>
                                <td>
                                    <span class="badge-code">{{ $voucher->code }}</span>
                                </td>
                                <td>
                                    <strong>{{ $voucher->title }}</strong>
                                </td>
                                <td>
                                    <span class="badge-type">
                                        {{ $voucher->type == 'percentage' ? 'Persentase' : 'Nominal' }}
                                    </span>
                                </td>
                                <td>
                                    <strong style="color: var(--primary-medium);">
                                        {{ $voucher->type == 'percentage' ? (int) $voucher->amount . '%' : 'Rp ' . number_format($voucher->amount, 0, ',', '.') }}
                                    </strong>
                                </td>
                                <td>Rp {{ number_format($voucher->min_purchase, 0, ',', '.') }}</td>
                                <td>
                                    @if ($voucher->expiry_date)
                                        <i class="fa-regular fa-calendar-days"
                                            style="color: var(--text-muted); margin-right: 4px;"></i>
                                        {{ \Carbon\Carbon::parse($voucher->expiry_date)->format('d M Y') }}
                                    @else
                                        <span style="color: var(--text-muted);">-</span>
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('admin.vouchers.toggleStatus', $voucher->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="btn-status-toggle {{ $voucher->is_active ? 'btn-status-active' : 'btn-status-inactive' }}">
                                            <span class="status-dot"></span>
                                            {{ $voucher->is_active ? 'Aktif' : 'Non-Aktif' }}
                                        </button>
                                    </form>
                                </td>
                                <td style="text-align: center;">
                                    <div style="display: flex; gap: 8px; justify-content: center;">
                                        <a href="{{ route('admin.vouchers.edit', $voucher->id) }}" class="btn-action-edit"
                                            title="Edit Voucher">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <form action="{{ route('admin.vouchers.destroy', $voucher->id) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus voucher ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action-delete" title="Hapus Voucher">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" style="text-align: center; padding: 40px; color: var(--text-muted);">
                                    <i class="fa-solid fa-ticket"
                                        style="font-size: 2rem; margin-bottom: 10px; display: block; opacity: 0.3;"></i>
                                    Belum ada data voucher yang ditambahkan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- PAGINASI -->
        <div style="margin-top: 20px;">
            {{ $vouchers->links() }}
        </div>
    </div>
@endsection
