@extends('admin.app')

@section('title', 'Kelola Pelanggan')

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

        .btn-reset-theme {
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

        .btn-reset-theme:hover {
            background: #F1F5F9;
            color: #EF4444;
            border-color: #FECACA;
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

        /* TOMBOL AKSI MODERN & CLEAN */
        .action-btn-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 34px;
            height: 34px;
            border-radius: 8px;
            border: 1px solid #E2E8F0;
            background: #F8FAFC;
            color: #64748B;
            cursor: pointer;
            transition: all 0.2s ease;
            font-size: 0.88rem;
        }

        .action-btn-icon.delete:hover {
            background: #FEF2F2;
            color: #EF4444;
            border-color: #FECACA;
            transform: translateY(-1px);
        }

        .btn-search-theme {
            padding: 10px 20px;
            background: var(--primary-medium, #23085A);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            cursor: pointer;
            font-size: 0.83rem;
            transition: all 0.2s;
        }

        .btn-search-theme:hover {
            background: var(--primary-dark, #18003C);
        }
    </style>
@endpush

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h2>Daftar Pelanggan</h2>
            <p>Kelola seluruh akun pengguna terdaftar di toko buku Anda</p>
        </div>
    </div>

    @if (session('success'))
        <div
            style="padding: 12px 16px; background: #ECFDF5; border: 1px solid #A7F3D0; color: #065F46; border-radius: 8px; margin-bottom: 20px; font-size: 0.85rem;">
            <i class="fa-solid fa-circle-check" style="margin-right: 6px;"></i> {{ session('success') }}
        </div>
    @endif

    <div class="filter-card">
        <form action="{{ route('admin.customers.index') }}" method="GET" style="display: flex; gap: 12px; width: 100%;">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Cari Nama, Email, atau No. WA Pelanggan..."
                style="flex: 1; padding: 10px 14px; border: 1px solid #CBD5E1; border-radius: 8px; font-size: 0.83rem; outline: none;">

            <button type="submit" class="btn-search-theme" style="display: inline-flex; align-items: center; gap: 6px;">
                <i class="fa-solid fa-magnifying-glass"></i> Cari
            </button>

            @if (request('search'))
                <a href="{{ route('admin.customers.index') }}" class="btn-reset-theme" title="Reset Pencarian">
                    <i class="fa-solid fa-rotate-right"></i> Reset
                </a>
            @endif
        </form>
    </div>

    <div class="table-card">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Pelanggan</th>
                    <th>Kontak (WA/Telp)</th>
                    <th>Tanggal Bergabung</th>
                    <th style="text-align: center; width: 100px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $customer)
                    <tr>
                        <td>
                            <div style="font-weight: 700; color: #0F172A;">{{ $customer->name }}</div>
                            <div style="font-size: 0.78rem; color: #64748B;">{{ $customer->email }}</div>
                        </td>
                        <td>{{ $customer->phone ?? '-' }}</td>
                        <td>{{ $customer->created_at->format('d M Y') }}</td>
                        <td style="text-align: center;">
                            <form action="{{ route('admin.users.destroy', $customer->id) }}" method="POST"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun pelanggan ini?')"
                                style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn-icon delete" title="Hapus Pelanggan">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 30px; color: #94A3B8;">
                            Belum ada pelanggan terdaftar.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 20px;">
        {{ $customers->links() }}
    </div>
@endsection
