@extends('layouts.app')

@section('title', 'Daftar Penulis - IGAKERTA Book Store')

@push('styles')
    <style>
        /* BANNER HEADER DESIGN */
        .authors-header {
            background: linear-gradient(90deg, #18003C 0%, #290858 55%, rgba(41, 8, 88, 0.45) 100%),
                url('https://images.unsplash.com/photo-1463320726281-696a485928c7?q=80&w=1200&auto=format&fit=crop') center / cover no-repeat;
            border-radius: 16px;
            color: white;
            padding: 35px 45px;
            margin: 1% 6% 25px 6%;
            width: auto;
            position: relative;
            overflow: hidden;
            box-sizing: border-box;
        }

        .authors-header-content {
            max-width: 650px;
            position: relative;
            z-index: 2;
        }

        .breadcrumb-item {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 10px;
        }

        .breadcrumb-item a {
            color: #FFC000;
            text-decoration: none;
            font-weight: 600;
        }

        .authors-header h1 {
            font-size: 1.85rem;
            font-weight: 800;
            margin-bottom: 8px;
            color: #FFFFFF;
            letter-spacing: -0.5px;
        }

        .authors-header p {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.85);
            line-height: 1.5;
            margin: 0;
        }

        /* TOOLBAR PENCARIAN TERPISAH */
        .search-toolbar-wrapper {
            padding: 0 6%;
            margin-bottom: 30px;
            display: flex;
            justify-content: flex-end;
        }

        .author-search-box {
            width: 100%;
            max-width: 380px;
            display: flex;
            align-items: center;
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 10px;
            padding: 4px 6px 4px 14px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            transition: all 0.2s ease;
        }

        .author-search-box:focus-within {
            border-color: #23085A;
            box-shadow: 0 4px 12px rgba(35, 8, 90, 0.1);
        }

        .author-search-box input {
            flex: 1;
            border: none;
            outline: none;
            font-size: 0.83rem;
            color: #1E293B;
            background: transparent;
        }

        .author-search-box button {
            background: #23085A;
            color: #FFFFFF;
            border: none;
            padding: 8px 16px;
            border-radius: 7px;
            font-weight: 600;
            cursor: pointer;
            font-size: 0.8rem;
            transition: background 0.2s ease;
        }

        .author-search-box button:hover {
            background: #4A1996;
        }

        .authors-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(270px, 1fr));
            gap: 25px;
            padding: 0 6%;
            margin-bottom: 60px;
        }

        /* CARD PEMBUNGKUS UTAMA SEBAGAI TAUTAN LINK */
        .author-card {
            background: white;
            border: 1px solid #EEF2F6;
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
            display: flex;
            flex-direction: column;
            position: relative;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
            text-decoration: none;
            cursor: pointer;
        }

        .author-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 16px 30px rgba(35, 8, 90, 0.09);
            border-color: #E2E8F0;
        }

        .author-card-header {
            height: 85px;
            background: linear-gradient(135deg, #F5EFFF 0%, #EDE9FE 100%);
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .author-cover-preview {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.15;
            filter: blur(2px);
        }

        .author-avatar-wrapper {
            position: absolute;
            bottom: -36px;
            left: 50%;
            transform: translateX(-50%);
        }

        .author-avatar-img {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid white;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
        }

        .author-avatar-initial {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            background: linear-gradient(135deg, #23085A 0%, #4A1996 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            font-weight: 800;
            border: 4px solid white;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
        }

        .author-card-body {
            padding: 48px 20px 20px 20px;
            text-align: center;
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
        }

        .author-name {
            font-weight: 700;
            font-size: 1.05rem;
            color: #1E293B;
            margin-bottom: 2px;
            line-height: 1.3;
        }

        .author-title-text {
            font-size: 0.78rem;
            color: #64748B;
            margin-bottom: 8px;
        }

        .author-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #F8FAFC;
            border: 1px solid #E2E8F0;
            color: #64748B;
            font-size: 0.75rem;
            padding: 4px 14px;
            border-radius: 20px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .btn-view-profile {
            background: #F5EFFF;
            color: #23085A;
            width: 100%;
            padding: 10px 0;
            border-radius: 10px;
            font-size: 0.82rem;
            font-weight: 700;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .author-card:hover .btn-view-profile {
            background: #23085A;
            color: white;
        }
    </style>
@endpush

@section('content')
    <!-- BANNER HEADER -->
    <div class="authors-header">
        <div class="authors-header-content">
            <div class="breadcrumb-item">
                <a href="{{ route('home') }}">Beranda</a> &gt; <span>Penulis & Kreator</span>
            </div>
            <h1>Penulis & Kreator</h1>
            <p>Jelajahi ide, pemikiran, dan karya terbaik dari para penulis berbakat favorit Anda di IGAKERTA Book Store.
            </p>
        </div>
    </div>

    <!-- TOOLBAR PENCARIAN TERPISAH -->
    <div class="search-toolbar-wrapper">
        <form action="{{ route('authors.index') }}" method="GET" class="author-search-box">
            <input type="text" name="search" placeholder="Cari nama penulis..." value="{{ request('search') }}">
            <button type="submit"><i class="fa-solid fa-magnifying-glass"></i> Cari</button>
        </form>
    </div>

    <!-- CONTAINER PENULIS -->
    <div class="authors-grid">
        @forelse($authors as $author)
            @php
                $authorName = $author->name ?? ($author->author ?? 'Penulis');
                $authorPhoto = $author->photo ?? ($author->avatar ?? null);
                $authorTitle = $author->title ?? ($author->degree ?? null);
                $booksCount = $author->books_count ?? ($author->total_books ?? count($author->books ?? []));
                $authorId = $author->id ?? null;
            @endphp

            <!-- TAG A MEMBUNGKUS SELURUH KARTU PENULIS -->
            <a href="{{ $authorId ? route('authors.show', $authorId) : route('catalog.index', ['author_id' => $authorId]) }}"
                class="author-card">

                <!-- Header Card -->
                <div class="author-card-header">
                    @if (!empty($author->sample_cover))
                        <img src="{{ asset('storage/' . $author->sample_cover) }}" class="author-cover-preview"
                            alt="Sample Cover">
                    @endif

                    <div class="author-avatar-wrapper">
                        @if ($authorPhoto)
                            <img src="{{ asset('storage/' . $authorPhoto) }}" class="author-avatar-img"
                                alt="{{ $authorName }}">
                        @else
                            <div class="author-avatar-initial">
                                {{ strtoupper(substr($authorName, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                </div>

                <div class="author-card-body">
                    <div>
                        <div class="author-name">{{ $authorName }}</div>

                        @if ($authorTitle)
                            <div class="author-title-text">{{ $authorTitle }}</div>
                        @endif

                        <div class="author-badge">
                            <i class="fa-solid fa-book-bookmark" style="color: #23085A;"></i>
                            {{ $booksCount }} Karya Buku
                        </div>
                    </div>

                    <!-- Visual Indikator Tombol -->
                    <div class="btn-view-profile">
                        Lihat Profil & Karya <i class="fa-solid fa-arrow-right" style="font-size: 0.75rem;"></i>
                    </div>
                </div>
            </a>
        @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 60px 0; color: #64748B;">
                <i class="fa-solid fa-user-slash" style="font-size: 3.5rem; margin-bottom: 15px; color: #CBD5E1;"></i>
                <h3 style="font-size: 1.1rem; color: #1E293B; margin-bottom: 6px;">Penulis Tidak Ditemukan</h3>
                <p style="font-size: 0.85rem;">Tidak menemukan penulis dengan kata kunci "{{ request('search') }}".</p>
                @if (request('search'))
                    <a href="{{ route('authors.index') }}"
                        style="color: #23085A; font-weight: 700; font-size: 0.85rem; text-decoration: underline; margin-top: 12px; display: inline-block;">
                        <i class="fa-solid fa-rotate-left"></i> Reset Tampilkan Semua
                    </a>
                @endif
            </div>
        @endforelse
    </div>

    <!-- PAGINASI -->
    <div style="padding: 0 6%; margin-bottom: 50px; display: flex; justify-content: center;">
        {{ $authors->links() }}
    </div>
@endsection
