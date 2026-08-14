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

        .publisher-name {
            font-weight: 700;
            color: #0F172A;
            font-size: 0.875rem;
        }

        .text-sub {
            font-size: 0.825rem;
            color: #64748B;
        }

        /* ACTION BUTTONS */
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
    </style>

    <div class="page-container">
        <!-- HEADER -->
        <div class="page-header">
            <h1 class="page-title">Kelola Penerbit</h1>
            <a href="{{ route('admin.publishers.create') }}" class="btn-add">
                <i class="fa-solid fa-plus"></i> Tambah Penerbit Baru
            </a>
        </div>

        <!-- TABS -->
        <div class="nav-tabs">
            <a href="{{ route('admin.books.index') }}" class="tab-item">
                <i class="fa-solid fa-book"></i> Daftar Buku & Ebook
            </a>
            <a href="{{ route('admin.authors.index') }}" class="tab-item">
                <i class="fa-solid fa-user-pen"></i> Penulis & Penulis Pilihan
            </a>
            <a href="{{ route('admin.publishers.index') }}" class="tab-item active">
                <i class="fa-solid fa-building"></i> Penerbit
            </a>
        </div>

        <!-- SEARCH BAR -->
        <div class="filter-card">
            <div class="search-box">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" class="search-input" placeholder="Cari nama penerbit...">
            </div>
        </div>

        <!-- TABLE CARD -->
        <div class="table-card">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>NAMA PENERBIT</th>
                        <th>NO. TELEPON</th>
                        <th>ALAMAT</th>
                        <th>JUMLAH BUKU</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($publishers as $publisher)
                        <tr>
                            <td>
                                <div class="publisher-name">{{ $publisher->name }}</div>
                            </td>
                            <td>
                                <span class="text-sub">{{ $publisher->phone ?? '-' }}</span>
                            </td>
                            <td>
                                <span class="text-sub">{{ $publisher->address ?? '-' }}</span>
                            </td>
                            <td>
                                <span class="text-sub">{{ $publisher->books_count ?? 0 }} Buku</span>
                            </td>
                            <td>
                                <div class="action-btns">
                                    <a href="{{ route('admin.publishers.edit', $publisher->id) }}" class="btn-icon-square"
                                        title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ route('admin.publishers.destroy', $publisher->id) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus penerbit ini?');"
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
                            <td colspan="5" style="text-align: center; color: #94A3B8; padding: 30px;">
                                Belum ada data penerbit.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 16px;">
            {{ $publishers->links() }}
        </div>
    </div>
@endsection
