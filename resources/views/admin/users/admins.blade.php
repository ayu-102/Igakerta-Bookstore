@extends('admin.app')

@section('title', 'Kelola Admin')

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

        .admin-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
        }

        .table-card,
        .form-card {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 12px;
            padding: 20px;
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

        .form-group {
            margin-bottom: 14px;
        }

        .form-group label {
            display: block;
            font-size: 0.78rem;
            font-weight: 700;
            color: #475569;
            margin-bottom: 6px;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #CBD5E1;
            border-radius: 8px;
            font-size: 0.83rem;
            outline: none;
        }

        .btn-submit {
            width: 100%;
            padding: 10px;
            background: var(--primary-medium);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            cursor: pointer;
            font-size: 0.83rem;
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
    </style>
@endpush

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h2>Kelola Administrator</h2>
            <p>Atur akun pengelola yang memiliki akses ke panel admin ini</p>
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
            <i class="fa-solid fa-triangle-exclamation" style="margin-right: 6px;"></i> {{ session('error') }}
        </div>
    @endif

    <div class="admin-grid">
        <!-- TABEL DAFTAR ADMIN -->
        <div class="table-card" style="padding: 0; overflow: hidden;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Nama Administrator</th>
                        <th>Email</th>
                        <th style="text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($admins as $admin)
                        <tr>
                            <td>
                                <div style="font-weight: 700; color: #0F172A;">{{ $admin->name }}</div>
                                <span
                                    style="font-size: 0.7rem; background: #F1F5F9; padding: 2px 6px; border-radius: 4px; font-weight: 700;">Super
                                    Admin</span>
                            </td>
                            <td>{{ $admin->email }}</td>
                            <td style="text-align: center;">
                                @if (auth()->id() != $admin->id)
                                    <form action="{{ route('admin.users.destroy', $admin->id) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus admin ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                @else
                                    <span style="font-size: 0.75rem; color: #94A3B8; font-style: italic;">Akun Anda</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- FORM TAMBAH ADMIN -->
        <div class="form-card">
            <h3 style="font-size: 0.95rem; font-weight: 800; margin-bottom: 16px; color: #0F172A;">Tambah Admin Baru</h3>
            <form action="{{ route('admin.admins.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="name" required placeholder="Contoh: Admin Store">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" required placeholder="admin@igakerta.com">
                </div>
                <div class="form-group">
                    <label>No. HP / WhatsApp (Opsional)</label>
                    <input type="text" name="phone" placeholder="08xxxxxxxxxx">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required placeholder="Minimal 6 karakter">
                </div>
                <button type="submit" class="btn-submit">
                    <i class="fa-solid fa-user-plus" style="margin-right: 6px;"></i> Simpan Admin
                </button>
            </form>
        </div>
    </div>
@endsection
