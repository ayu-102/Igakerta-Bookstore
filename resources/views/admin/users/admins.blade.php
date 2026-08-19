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
            transition: border-color 0.2s;
        }

        .form-group input:focus {
            border-color: var(--primary-medium, #23085A);
        }

        .btn-submit {
            width: 100%;
            padding: 10px;
            background: var(--primary-medium, #23085A);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            cursor: pointer;
            font-size: 0.83rem;
            transition: all 0.2s;
        }

        .btn-submit:hover {
            background: var(--primary-dark, #18003C);
            transform: translateY(-1px);
        }

        /* TOMBOL AKSI */
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
            text-decoration: none;
        }

        .action-btn-icon.edit:hover {
            background: #EFF6FF;
            color: #2563EB;
            border-color: #BFDBFE;
            transform: translateY(-1px);
        }

        .action-btn-icon.delete:hover {
            background: #FEF2F2;
            color: #EF4444;
            border-color: #FECACA;
            transform: translateY(-1px);
        }

        /* MODAL STYLES */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.5);
            z-index: 999;
            align-items: center;
            justify-content: center;
        }

        .modal.show {
            display: flex;
        }

        .modal-content {
            background: #FFFFFF;
            border-radius: 12px;
            width: 100%;
            max-width: 450px;
            padding: 24px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }

        .modal-header h3 {
            font-size: 1.05rem;
            font-weight: 800;
            color: #0F172A;
            margin: 0;
        }

        .close-btn {
            background: none;
            border: none;
            font-size: 1.2rem;
            color: #64748B;
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
                        <th style="text-align: center; width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($admins as $admin)
                        <tr>
                            <td>
                                <div style="font-weight: 700; color: #0F172A;">{{ $admin->name }}</div>
                                <span
                                    style="font-size: 0.7rem; background: #F1F5F9; padding: 2px 6px; border-radius: 4px; font-weight: 700; color: #475569;">
                                    Super Admin
                                </span>
                            </td>
                            <td>{{ $admin->email }}</td>
                            <td style="text-align: center; white-space: nowrap;">
                                <!-- Tombol Edit -->
                                <button type="button" class="action-btn-icon edit" title="Edit Admin"
                                    onclick="openEditModal({{ json_encode($admin) }})">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </button>

                                <!-- Tombol Hapus -->
                                @if (auth()->id() != $admin->id)
                                    <form action="{{ route('admin.users.destroy', $admin->id) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus admin ini?')"
                                        style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn-icon delete" title="Hapus Admin">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </button>
                                    </form>
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
            <form action="{{ route('admin.admins.store') }}" method="POST" autocomplete="off">
                @csrf
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="name" required placeholder="Contoh: Admin Store" autocomplete="off">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" required placeholder="admin@igakerta.com" autocomplete="off">
                </div>
                <div class="form-group">
                    <label>No. HP / WhatsApp (Opsional)</label>
                    <input type="text" name="phone" placeholder="08xxxxxxxxxx" autocomplete="off">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required placeholder="Minimal 6 karakter"
                        autocomplete="new-password">
                </div>
                <button type="submit" class="btn-submit">
                    <i class="fa-solid fa-user-plus" style="margin-right: 6px;"></i> Simpan Admin
                </button>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT ADMIN -->
    <div class="modal" id="editAdminModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Edit Administrator</h3>
                <button type="button" class="close-btn" onclick="closeEditModal()">&times;</button>
            </div>
            <form id="editForm" method="POST" autocomplete="off">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" id="edit_name" name="name" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" id="edit_email" name="email" required>
                </div>
                <div class="form-group">
                    <label>No. HP / WhatsApp (Opsional)</label>
                    <input type="text" id="edit_phone" name="phone">
                </div>
                <div class="form-group">
                    <label>Password Baru (Opsional)</label>
                    <input type="password" name="password" placeholder="Kosongkan jika tidak diganti">
                </div>
                <button type="submit" class="btn-submit">
                    <i class="fa-solid fa-floppy-disk" style="margin-right: 6px;"></i> Perbarui Admin
                </button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function openEditModal(admin) {
            document.getElementById('edit_name').value = admin.name;
            document.getElementById('edit_email').value = admin.email;
            document.getElementById('edit_phone').value = admin.phone || '';

            let form = document.getElementById('editForm');
            form.action = `/admin/admins/${admin.id}`;

            document.getElementById('editAdminModal').classList.add('show');
        }

        function closeEditModal() {
            document.getElementById('editAdminModal').classList.remove('show');
        }
    </script>
@endpush
