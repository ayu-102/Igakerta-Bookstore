@extends('admin.app')

@section('title', 'Kelola Kategori Buku')

@section('content')
    <style>
        .page-container {
            padding: 24px;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            color: #1E293B;
        }

        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 16px;
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
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
        }

        .btn-add:hover {
            background-color: #1E0D3D;
        }

        .search-container {
            background: #FFFFFF;
            border-radius: 12px;
            border: 1px solid #E2E8F0;
            padding: 16px 20px;
            margin-bottom: 24px;
            display: flex;
            gap: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
        }

        .search-input {
            width: 100%;
            /* <--- Tambahkan ini agar memanjang penuh */
            box-sizing: border-box;
            padding: 9px 14px;
            border: 1px solid #CBD5E1;
            border-radius: 8px;
            font-size: 0.875rem;
            outline: none;
        }

        .search-input:focus {
            border-color: #2D1558;
        }

        .btn-search {
            background-color: #F1F5F9;
            color: #475569;
            border: 1px solid #CBD5E1;
            padding: 9px 18px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
        }

        .table-card {
            background: #FFFFFF;
            border-radius: 16px;
            border: 1px solid #E2E8F0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .table-custom {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 0.875rem;
        }

        .table-custom th {
            background-color: #F8FAFC;
            color: #475569;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            padding: 14px 20px;
            border-bottom: 1px solid #E2E8F0;
        }

        .table-custom td {
            padding: 16px 20px;
            border-bottom: 1px solid #F1F5F9;
            vertical-align: middle;
        }

        .table-custom tbody tr:hover {
            background-color: #F8FAFC;
        }

        .badge-slug {
            background: #F1F5F9;
            color: #475569;
            padding: 4px 10px;
            border-radius: 6px;
            font-family: monospace;
            font-size: 0.8rem;
        }

        .badge-count {
            background: #F5EFFF;
            color: #2D1558;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.78rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .action-btns {
            display: flex;
            gap: 8px;
            justify-content: center;
        }

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

        .alert-success {
            background-color: #ECFDF5;
            color: #065F46;
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-weight: 600;
            font-size: 0.875rem;
            border: 1px solid #A7F3D0;
        }

        .alert-error {
            background-color: #FEF2F2;
            color: #991B1B;
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-weight: 600;
            font-size: 0.875rem;
            border: 1px solid #FECACA;
        }

        .search-form {
            display: flex;
            width: 100%;
            gap: 12px;
            align-items: center;
        }

        .search-input-wrapper {
            flex: 1;
        }

        .button-group {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .btn-search {
            background-color: #2D1558;
            color: #FFFFFF;
            border: none;
            padding: 9px 18px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: background 0.2s;
        }

        .btn-search:hover {
            background-color: #1E0D3D;
        }

        .btn-reset {
            padding: 9px 14px;
            border: 1px solid #CBD5E1;
            border-radius: 8px;
            font-size: 0.875rem;
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
            <div>
                <h1 class="page-title">Kategori Buku</h1>
                <p style="margin: 4px 0 0 0; color: #64748B; font-size: 0.85rem;">Kelola pengelompokan jenis dan genre buku
                    dalam sistem.</p>
            </div>
            <a href="{{ route('admin.categories.create') }}" class="btn-add">
                <i class="fa-solid fa-plus"></i> Tambah Kategori
            </a>
        </div>

        <!-- ALERTS -->
        @if (session('success'))
            <div class="alert-success">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif

        @if ($errors->has('error'))
            <div class="alert-error">
                <i class="fa-solid fa-triangle-exclamation"></i> {{ $errors->first('error') }}
            </div>
        @endif

        <!-- SEARCH BAR -->
        <div class="search-container">
            <form action="{{ route('admin.categories.index') }}" method="GET" class="search-form">
                <div class="search-input-wrapper">
                    <input type="text" name="search" class="search-input" placeholder="Cari nama kategori..."
                        value="{{ request('search') }}">
                </div>
                <div class="button-group">
                    <button type="submit" class="btn-search">
                        <i class="fa-solid fa-magnifying-glass"></i> Cari
                    </button>
                    @if (request('search'))
                        <a href="{{ route('admin.categories.index') }}" class="btn-reset" title="Reset Pencarian">
                            <i class="fa-solid fa-rotate-right"></i> Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- TABLE DATA -->
        <div class="table-card">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th style="width: 60px; text-align: center;">#</th>
                        <th>Nama Kategori</th>
                        <th>Slug URL</th>
                        <th style="text-align: center;">Jumlah Buku</th>
                        <th style="width: 120px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td style="text-align: center; font-weight: 600; color: #64748B;">
                                {{ $loop->iteration + ($categories->currentPage() - 1) * $categories->perPage() }}
                            </td>
                            <td>
                                <strong style="color: #0F172A; font-size: 0.925rem;">{{ $category->name }}</strong>
                            </td>
                            <td>
                                <span class="badge-slug">{{ $category->slug }}</span>
                            </td>
                            <td style="text-align: center;">
                                <span class="badge-count">
                                    <i class="fa-solid fa-book"></i> {{ $category->books_count ?? 0 }} Buku
                                </span>
                            </td>
                            <td>
                                <div class="action-btns">
                                    <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn-action-edit"
                                        title="Edit Kategori">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori {{ $category->name }}?')"
                                        style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action-delete" title="Hapus Kategori">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 40px 20px; color: #64748B;">
                                <i class="fa-solid fa-tags"
                                    style="font-size: 2.5rem; margin-bottom: 12px; color: #CBD5E1; display: block;"></i>
                                Belum ada data kategori. Silakan klik tombol <strong>"Tambah Kategori"</strong>!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- PAGINASI -->
        <div style="margin-top: 24px; display: flex; justify-content: center;">
            {{ $categories->links() }}
        </div>
    </div>
@endsection
