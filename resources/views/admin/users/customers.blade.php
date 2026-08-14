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

        .btn-delete {
            background: #FEF2F2;
            color: #EF4444;
            border: 1px solid #FECACA;
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 700;
            font-size: 0.75rem;
            cursor: pointer;
        }

        .btn-delete:hover {
            background: #EF4444;
            color: white;
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
        <form action="{{ route('admin.customers.index') }}" method="GET" style="display: flex; gap: 12px;">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Cari Nama, Email, atau No. WA Pelanggan..."
                style="flex: 1; padding: 10px 14px; border: 1px solid #CBD5E1; border-radius: 8px; font-size: 0.83rem; outline: none;">
            <button type="submit"
                style="padding: 10px 20px; background: var(--primary-medium); color: white; border: none; border-radius: 8px; font-weight: 700; cursor: pointer; font-size: 0.83rem;">
                <i class="fa-solid fa-magnifying-glass"></i> Cari
            </button>
        </form>
    </div>

    <div class="table-card">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Pelanggan</th>
                    <th>Kontak (WA/Telp)</th>
                    <th>Tanggal Bergabung</th>
                    <th style="text-align: center;">Aksi</th>
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
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun pelanggan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete">
                                    <i class="fa-solid fa-trash"></i> Hapus
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
