@extends('admin.app')

@section('content')
    <style>
        .page-container {
            padding: 24px;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            color: #1E293B;
        }

        /* HEADER SECTION */
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .page-title {
            font-size: 1.35rem;
            font-weight: 800;
            color: #0F172A;
            margin: 0;
        }

        .btn-add {
            background-color: #2D1558;
            color: #FFFFFF;
            padding: 10px 18px;
            border-radius: 10px;
            font-size: 0.875rem;
            font-weight: 600;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .btn-add:hover {
            background-color: #1E0D3D;
            color: #FFFFFF;
        }

        /* NAVIGATION TABS */
        .nav-tabs {
            display: flex;
            align-items: center;
            gap: 24px;
            border-bottom: 1px solid #E2E8F0;
            margin-bottom: 20px;
            padding-bottom: 0;
        }

        .tab-item {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding-bottom: 12px;
            font-size: 0.875rem;
            font-weight: 600;
            color: #64748B;
            text-decoration: none;
            border-bottom: 2px solid transparent;
            transition: all 0.2s ease;
        }

        .tab-item:hover {
            color: #2D1558;
        }

        .tab-item.active {
            color: #2D1558;
            border-bottom-color: #2D1558;
            font-weight: 700;
        }

        /* FILTER & SEARCH CARD */
        .filter-card {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .search-box {
            position: relative;
            flex: 1;
            max-width: 320px;
        }

        .search-box i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #94A3B8;
            font-size: 0.875rem;
        }

        .search-input {
            width: 100%;
            padding: 9px 14px 9px 38px;
            background: #F8FAFC;
            border: 1px solid #E2E8F0;
            border-radius: 8px;
            font-size: 0.85rem;
            outline: none;
            box-sizing: border-box;
            color: #334155;
        }

        .search-input:focus {
            border-color: #6366F1;
            background: #FFFFFF;
        }

        .filter-select {
            padding: 9px 14px;
            background: #F8FAFC;
            border: 1px solid #E2E8F0;
            border-radius: 8px;
            font-size: 0.85rem;
            color: #475569;
            outline: none;
            cursor: pointer;
        }

        /* TABLE CARD */
        .table-card {
            background: #FFFFFF;
            border-radius: 12px;
            border: 1px solid #E2E8F0;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.02);
            overflow: hidden;
        }

        .custom-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .custom-table th {
            background: #F8FAFC;
            padding: 12px 20px;
            font-size: 0.725rem;
            font-weight: 700;
            text-transform: uppercase;
            color: #64748B;
            letter-spacing: 0.05em;
            border-bottom: 1px solid #E2E8F0;
        }

        .custom-table td {
            padding: 14px 20px;
            font-size: 0.875rem;
            border-bottom: 1px solid #E2E8F0;
            vertical-align: middle;
        }

        .custom-table tbody tr:hover {
            background: #F8FAFC;
        }

        /* AUTHOR AVATAR & CELL */
        .author-cell {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .author-avatar-img {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            object-fit: cover;
        }

        .author-avatar-initial {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #E0E7FF;
            color: #4338CA;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.875rem;
        }

        .author-name {
            font-weight: 700;
            color: #0F172A;
            font-size: 0.875rem;
        }

        .text-sub {
            font-size: 0.825rem;
            color: #64748B;
        }

        /* BADGES */
        .badge-featured {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            background: #FEF3C7;
            color: #D97706;
            border: 1px solid #FCD34D;
            cursor: pointer;
        }

        .badge-regular {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            background: #F1F5F9;
            color: #64748B;
            border: 1px solid #E2E8F0;
            cursor: pointer;
        }

        /* ACTION BUTTONS (Sama persis seperti di kelola buku) */
        .action-btns {
            display: flex;
            gap: 6px;
            justify-content: flex-start;
        }

        .btn-icon-square {
            width: 30px;
            height: 30px;
            border-radius: 6px;
            border: 1px solid #E2E8F0;
            background: #F8FAFC;
            color: #64748B;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            font-size: 0.8rem;
        }

        .btn-icon-square:hover {
            background: #FFFFFF;
            border-color: #CBD5E1;
            color: #0F172A;
        }

        /* MODAL STYLES */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.4);
            backdrop-filter: blur(4px);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        .modal-card {
            background: #FFFFFF;
            width: 100%;
            max-width: 500px;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .modal-title {
            font-size: 1.1rem;
            font-weight: 800;
            color: #0F172A;
            margin: 0;
        }

        .modal-close {
            background: transparent;
            border: none;
            font-size: 1.2rem;
            color: #94A3B8;
            cursor: pointer;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-label {
            display: block;
            font-size: 0.775rem;
            font-weight: 700;
            color: #475569;
            margin-bottom: 6px;
            text-transform: uppercase;
        }

        .form-control {
            width: 100%;
            padding: 9px 12px;
            border: 1px solid #CBD5E1;
            border-radius: 8px;
            font-size: 0.875rem;
            outline: none;
            box-sizing: border-box;
        }

        .form-control:focus {
            border-color: #2D1558;
        }

        .filter-form {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            gap: 16px;
        }

        .btn-reset {
            padding: 8px 14px;
            border: 1px solid #E2E8F0;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            color: #64748B;
            background: #F8FAFC;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
        }

        .btn-reset:hover {
            background: #F1F5F9;
            color: #EF4444;
            border-color: #FECACA;
        }
    </style>

    <div class="page-container">
        <!-- HEADER -->
        <div class="page-header">
            <h1 class="page-title">Kelola Penulis</h1>
            <a href="{{ route('admin.authors.create') }}" class="btn-add">
                <i class="fa-solid fa-plus"></i> Tambah Penulis Baru
            </a>
        </div>

        <!-- TABS -->
        <div class="nav-tabs">
            <a href="{{ route('admin.books.index') }}" class="tab-item">
                <i class="fa-solid fa-book"></i> Daftar Buku & Ebook
            </a>
            <a href="{{ route('admin.authors.index') }}" class="tab-item active">
                <i class="fa-solid fa-user-pen"></i> Penulis & Penulis Pilihan
            </a>
            <a href="{{ route('admin.publishers.index') }}"
                class="tab-item {{ request()->routeIs('admin.publishers.*') ? 'active' : '' }}">
                <i class="fa-solid fa-building"></i> Penerbit
            </a>
        </div>

        <!-- SEARCH & FILTER BAR -->
        <div class="filter-card">
            <form action="{{ route('admin.authors.index') }}" method="GET" class="filter-form">
                <!-- Input Search -->
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" name="search" value="{{ request('search') }}" class="search-input"
                        placeholder="Cari nama atau gelar penulis..." onchange="this.form.submit()">
                </div>

                <!-- Filter Dropdown & Reset Button -->
                <div style="display: flex; gap: 10px; align-items: center;">
                    <select name="status" class="filter-select" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="featured" {{ request('status') == 'featured' ? 'selected' : '' }}>Penulis Pilihan
                        </option>
                        <option value="regular" {{ request('status') == 'regular' ? 'selected' : '' }}>Reguler</option>
                    </select>

                    @if (request('search') || request('status'))
                        <a href="{{ route('admin.authors.index') }}" class="btn-reset" title="Reset Filter">
                            <i class="fa-solid fa-rotate-right"></i> Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- TABLE CARD -->
        <div class="table-card">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>PENULIS</th>
                        <th>GELAR / PERAN</th>
                        <th>STATUS FEATURED</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($authors as $author)
                        <tr>
                            <td>
                                <div class="author-cell">
                                    @if ($author->photo)
                                        <img src="{{ asset('storage/' . $author->photo) }}" class="author-avatar-img"
                                            alt="{{ $author->name }}">
                                    @else
                                        <div class="author-avatar-initial">
                                            {{ strtoupper(substr($author->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div class="author-name">{{ $author->name }}</div>
                                </div>
                            </td>
                            <td>
                                <span class="text-sub">{{ $author->title ?? '-' }}</span>
                            </td>
                            <td>
                                <form action="{{ route('admin.authors.toggleFeatured', $author->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    @if ($author->is_featured)
                                        <button type="submit" class="badge-featured" title="Klik untuk ubah ke Reguler">
                                            <i class="fa-solid fa-star"></i> Penulis Pilihan
                                        </button>
                                    @else
                                        <button type="submit" class="badge-regular"
                                            title="Klik untuk jadikan Penulis Pilihan">
                                            <i class="fa-regular fa-star"></i> Reguler
                                        </button>
                                    @endif
                                </form>
                            </td>
                            <td>
                                <div class="action-btns">
                                    <a href="{{ route('admin.authors.edit', $author->id) }}" class="btn-icon-square"
                                        title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ route('admin.authors.destroy', $author->id) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus penulis ini?');"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-icon-square" title="Hapus">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; color: #94A3B8; padding: 30px;">
                                Belum ada data penulis.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 16px;">
            {{ $authors->links() }}
        </div>
    </div>

    <!-- MODAL TAMBAH PENULIS -->
    <div class="modal-overlay" id="modalAddAuthor">
        <div class="modal-card">
            <div class="modal-header">
                <h3 class="modal-title">Tambah Penulis Baru</h3>
                <button class="modal-close" onclick="closeModal('modalAddAuthor')"><i
                        class="fa-solid fa-xmark"></i></button>
            </div>
            <form action="{{ route('admin.authors.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="form-label">Nama Lengkap <span>*</span></label>
                    <input type="text" name="name" class="form-control" placeholder="Contoh: Prof. Dr. Sugiyono"
                        required>
                </div>
                <div class="form-group">
                    <label class="form-label">Gelar / Sub-Judul</label>
                    <input type="text" name="title" class="form-control" placeholder="Contoh: Dosen & Peneliti Senior">
                </div>
                <div class="form-group">
                    <label class="form-label">Foto Profil</label>
                    <input type="file" name="photo" class="form-control" accept="image/*">
                </div>
                <div class="form-group">
                    <label class="form-label">Biografi Singkat</label>
                    <textarea name="bio" rows="3" class="form-control" placeholder="Tuliskan profil singkat penulis..."></textarea>
                </div>
                <div class="form-group" style="display: flex; align-items: center; gap: 8px;">
                    <input type="checkbox" name="is_featured" id="add_featured" value="1">
                    <label for="add_featured"
                        style="font-size: 0.85rem; font-weight: 600; color: #334155; cursor: pointer;">
                        Jadikan Penulis Pilihan (Featured)
                    </label>
                </div>
                <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                    <button type="button" class="btn-icon-square" style="width: auto; padding: 0 16px;"
                        onclick="closeModal('modalAddAuthor')">Batal</button>
                    <button type="submit" class="btn-add">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT PENULIS -->
    <div class="modal-overlay" id="modalEditAuthor">
        <div class="modal-card">
            <div class="modal-header">
                <h3 class="modal-title">Edit Data Penulis</h3>
                <button class="modal-close" onclick="closeModal('modalEditAuthor')"><i
                        class="fa-solid fa-xmark"></i></button>
            </div>
            <form id="formEditAuthor" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label class="form-label">Nama Lengkap <span>*</span></label>
                    <input type="text" name="name" id="edit_name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Gelar / Sub-Judul</label>
                    <input type="text" name="title" id="edit_title" class="form-control">
                </div>
                <div class="form-group">
                    <label class="form-label">Foto Profil Baru (Opsional)</label>
                    <input type="file" name="photo" class="form-control" accept="image/*">
                </div>
                <div class="form-group">
                    <label class="form-label">Biografi Singkat</label>
                    <textarea name="bio" id="edit_bio" rows="3" class="form-control"></textarea>
                </div>
                <div class="form-group" style="display: flex; align-items: center; gap: 8px;">
                    <input type="checkbox" name="is_featured" id="edit_featured" value="1">
                    <label for="edit_featured"
                        style="font-size: 0.85rem; font-weight: 600; color: #334155; cursor: pointer;">
                        Jadikan Penulis Pilihan (Featured)
                    </label>
                </div>
                <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                    <button type="button" class="btn-icon-square" style="width: auto; padding: 0 16px;"
                        onclick="closeModal('modalEditAuthor')">Batal</button>
                    <button type="submit" class="btn-add">Perbarui</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openAddModal() {
            document.getElementById('modalAddAuthor').style.display = 'flex';
        }

        function openEditModal(author) {
            const form = document.getElementById('formEditAuthor');
            form.action = `/admin/authors/${author.id}`;

            document.getElementById('edit_name').value = author.name;
            document.getElementById('edit_title').value = author.title || '';
            document.getElementById('edit_bio').value = author.bio || '';
            document.getElementById('edit_featured').checked = author.is_featured;

            document.getElementById('modalEditAuthor').style.display = 'flex';
        }

        function closeModal(id) {
            document.getElementById(id).style.display = 'none';
        }
    </script>
@endsection
