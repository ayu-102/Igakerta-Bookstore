@extends('admin.app')

@section('content')
    <style>
        /* PAGE HEADER */
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .page-title {
            font-size: 1.35rem;
            font-weight: 800;
            color: var(--primary-dark);
        }

        /* TAB NAVIGATION */
        .catalog-tabs {
            display: flex;
            gap: 8px;
            border-bottom: 2px solid var(--border-color);
            margin-bottom: 20px;
        }

        .tab-btn {
            padding: 10px 20px;
            font-size: 0.88rem;
            font-weight: 700;
            color: var(--text-muted);
            background: transparent;
            border: none;
            border-bottom: 3px solid transparent;
            cursor: pointer;
            transition: all 0.2s;
            margin-bottom: -2px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .tab-btn:hover {
            color: var(--primary-medium);
        }

        .tab-btn.active {
            color: var(--primary-medium);
            border-bottom-color: var(--primary-medium);
        }

        /* FILTER & SEARCH BAR */
        .table-toolbar {
            background: #FFFFFF;
            padding: 16px;
            border-radius: 12px;
            border: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 20px;
        }

        .search-box {
            position: relative;
            flex-grow: 1;
            max-width: 350px;
        }

        .search-box i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 0.85rem;
        }

        .search-input {
            width: 100%;
            padding: 8px 12px 8px 36px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 0.85rem;
            outline: none;
            transition: border 0.2s;
        }

        .search-input:focus {
            border-color: var(--primary-medium);
        }

        .filter-group {
            display: flex;
            gap: 10px;
        }

        .filter-select {
            padding: 8px 12px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 0.85rem;
            color: var(--primary-dark);
            outline: none;
            background: #FFFFFF;
        }

        /* BUTTON ACTION */
        .btn-primary-custom {
            background: var(--primary-medium);
            color: #FFFFFF;
            padding: 9px 16px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            text-decoration: none;
            transition: opacity 0.2s;
        }

        .btn-primary-custom:hover {
            opacity: 0.9;
        }

        /* DATA TABLE DESIGN */
        .table-container {
            background: #FFFFFF;
            border-radius: 12px;
            border: 1px solid var(--border-color);
            overflow: hidden;
        }

        .custom-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .custom-table th {
            background: #F8FAFC;
            padding: 14px 18px;
            font-size: 0.78rem;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--text-muted);
            letter-spacing: 0.5px;
            border-bottom: 1px solid var(--border-color);
        }

        .custom-table td {
            padding: 14px 18px;
            font-size: 0.85rem;
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
        }

        .custom-table tbody tr:hover {
            background: #F8FAFC;
        }

        /* BOOK INFO FLEX & IMAGE CUSTOMIZATION */
        .book-cell {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .book-cover-img {
            width: 44px;
            height: 60px;
            border-radius: 6px;
            object-fit: cover;
            flex-shrink: 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border: 1px solid #E2E8F0;
        }

        .book-cover-placeholder {
            width: 44px;
            height: 60px;
            background: #F1F5F9;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #94A3B8;
            font-size: 1.1rem;
            flex-shrink: 0;
            border: 1px solid #E2E8F0;
        }

        .book-title {
            font-weight: 700;
            color: var(--primary-dark);
            line-height: 1.2;
            margin-bottom: 3px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .book-isbn {
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        /* BADGES */
        .badge-type {
            padding: 2px 8px;
            border-radius: 6px;
            font-size: 0.7rem;
            font-weight: 700;
        }

        .badge-type-physical {
            background: #F1F5F9;
            color: #475569;
        }

        .badge-type-ebook {
            background: #E0E7FF;
            color: #4338CA;
        }

        .badge-stock {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .badge-success {
            background: #DCFCE7;
            color: #166534;
        }

        .badge-danger {
            background: #FEE2E2;
            color: #991B1B;
        }

        /* ACTION BUTTONS IN TABLE */
        .action-btns {
            display: flex;
            gap: 6px;
        }

        .btn-icon {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            border: 1px solid var(--border-color);
            background: #FFFFFF;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-icon:hover {
            border-color: var(--primary-medium);
            color: var(--primary-medium);
            background: #F1F5F9;
        }

        .btn-icon.delete:hover {
            border-color: #EF4444;
            color: #EF4444;
            background: #FEF2F2;
        }

        /* TAB CONTENT WRAPPER */
        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .toolbar-form {
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

    <!-- PAGE HEADER -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Kelola Buku & Ebook</h1>
        </div>
        <a href="{{ route('admin.books.create') }}" class="btn-primary-custom">
            <i class="fa-solid fa-plus"></i> Tambah Buku/Ebook Baru
        </a>
    </div>

    <!-- TAB NAVIGATION -->
    <div class="catalog-tabs">
        <a href="{{ route('admin.books.index') }}" class="tab-btn {{ request()->routeIs('admin.books.*') ? 'active' : '' }}">
            <i class="fa-solid fa-book"></i> Daftar Buku & Ebook
        </a>

        <a href="{{ route('admin.authors.index') }}"
            class="tab-btn {{ request()->routeIs('admin.authors.*') ? 'active' : '' }}">
            <i class="fa-solid fa-user-pen"></i> Penulis & Penulis Pilihan
        </a>

        <a href="{{ route('admin.publishers.index') }}"
            class="tab-btn {{ request()->routeIs('admin.publishers.*') ? 'active' : '' }}">
            <i class="fa-solid fa-building"></i> Penerbit
        </a>
    </div>

    <!-- TAB 1: DAFTAR BUKU -->
    <div id="tab-buku" class="tab-content active">
        <!-- TOOLBAR & FILTER -->
        <!-- FILTER & SEARCH BAR -->
        <div class="table-toolbar">
            <form action="{{ route('admin.books.index') }}" method="GET" class="toolbar-form">
                <!-- Input Search -->
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" name="search" value="{{ request('search') }}" class="search-input"
                        placeholder="Cari judul buku, ISBN, atau penulis..." onchange="this.form.submit()">
                </div>

                <!-- Filter Dropdown & Reset Button -->
                <div class="filter-group">
                    <select name="type" class="filter-select" onchange="this.form.submit()">
                        <option value="">Semua Format</option>
                        <option value="physical" {{ request('type') == 'physical' ? 'selected' : '' }}>Buku Fisik</option>
                        <option value="ebook" {{ request('type') == 'ebook' ? 'selected' : '' }}>E-Book</option>
                    </select>

                    <select name="category_id" class="filter-select" onchange="this.form.submit()">
                        <option value="">Semua Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>

                    <!-- TOMBOL RESET (Hanya tampil jika ada filter/search yang terisi) -->
                    @if (request('search') || request('type') || request('category_id'))
                        <a href="{{ route('admin.books.index') }}" class="btn-reset" title="Reset Filter">
                            <i class="fa-solid fa-rotate-right"></i> Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- TABLE BUKU -->
        <div class="table-container">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Informasi Buku</th>
                        <th>Kategori</th>
                        <th>Penulis</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th style="text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($books as $book)
                        <tr>
                            <td>
                                <div class="book-cell">
                                    <!-- PENANGANAN FOTO SAMPUL -->
                                    @if ($book->cover_image)
                                        <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}"
                                            class="book-cover-img">
                                    @else
                                        <div class="book-cover-placeholder"
                                            style="{{ $book->type == 'ebook' ? 'background: #EEF2FF; color: #4F46E5;' : '' }}">
                                            <i
                                                class="fa-solid {{ $book->type == 'ebook' ? 'fa-file-pdf' : 'fa-book-open' }}"></i>
                                        </div>
                                    @endif

                                    <div>
                                        <div class="book-title">
                                            {{ $book->title }}
                                            <span
                                                class="badge-type {{ $book->type == 'ebook' ? 'badge-type-ebook' : 'badge-type-physical' }}">
                                                {{ $book->type == 'ebook' ? 'E-Book' : 'Fisik' }}
                                            </span>
                                        </div>
                                        <div class="book-isbn">
                                            {{ $book->type == 'ebook' ? 'File Digital' : 'ISBN: ' . ($book->isbn ?? '-') }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td><span style="font-weight: 600;">{{ $book->category->name ?? 'Uncategorized' }}</span></td>
                            <td>{{ is_object($book->author) ? $book->author->name : $book->author ?? '-' }}</td>
                            <td><strong style="color: var(--primary-dark);">Rp
                                    {{ number_format($book->price, 0, ',', '.') }}</strong></td>
                            <td>
                                @if ($book->type == 'ebook')
                                    <span class="badge-stock badge-success">Digital (Unlimited)</span>
                                @else
                                    <span class="badge-stock {{ $book->stock > 0 ? 'badge-success' : 'badge-danger' }}">
                                        {{ $book->stock }} Pcs
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="action-btns" style="justify-content: center;">
                                    <a href="{{ route('admin.books.edit', $book->id) }}" class="btn-icon" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST"
                                        style="display:inline;"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-icon delete" title="Hapus">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
