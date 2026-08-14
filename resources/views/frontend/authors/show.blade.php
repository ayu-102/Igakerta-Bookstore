@extends('layouts.app')

@section('title', $author->name . ' - Profil Penulis')

@push('styles')
    <style>
        .author-detail-container {
            padding: 0 6%;
            margin-top: 25px;
            margin-bottom: 60px;
        }

        /* HEADER IDENTITAS PENULIS */
        .author-profile-card {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 16px;
            padding: 35px;
            display: flex;
            gap: 30px;
            align-items: flex-start;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
            margin-bottom: 40px;
        }

        .author-profile-avatar-img {
            width: 130px;
            height: 130px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #F5EFFF;
            box-shadow: 0 6px 16px rgba(35, 8, 90, 0.1);
            flex-shrink: 0;
        }

        .author-profile-avatar-initial {
            width: 130px;
            height: 130px;
            border-radius: 50%;
            background: linear-gradient(135deg, #23085A 0%, #4A1996 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3.2rem;
            font-weight: 800;
            flex-shrink: 0;
            box-shadow: 0 6px 16px rgba(35, 8, 90, 0.1);
        }

        .author-info-wrapper {
            flex: 1;
        }

        .author-info-name {
            font-size: 1.65rem;
            font-weight: 800;
            color: #1E293B;
            margin-bottom: 4px;
        }

        .author-info-title {
            font-size: 0.9rem;
            color: #64748B;
            font-weight: 600;
            margin-bottom: 14px;
        }

        .author-info-bio {
            font-size: 0.88rem;
            color: #475569;
            line-height: 1.65;
            margin-bottom: 20px;
            background: #F8FAFC;
            padding: 16px 20px;
            border-radius: 10px;
            border-left: 4px solid #23085A;
        }

        .author-stats-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #F5EFFF;
            color: #23085A;
            padding: 8px 18px;
            border-radius: 20px;
            font-size: 0.82rem;
            font-weight: 700;
        }

        /* SECTION JUDUL KATALOG KARYA */
        .section-title-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            border-bottom: 2px solid #F1F5F9;
            padding-bottom: 12px;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 800;
            color: #1E293B;
        }

        /* GRID BUKU KARYA PENULIS */
        .books-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
        }

        .book-card {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 12px;
            padding: 14px;
            transition: all 0.2s;
            text-decoration: none;
            display: flex;
            flex-direction: column;
        }

        .book-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.06);
        }

        .book-cover {
            width: 100%;
            height: 220px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 12px;
            background: #F8FAFC;
        }

        .book-title {
            font-size: 0.9rem;
            font-weight: 700;
            color: #1E293B;
            margin-bottom: 6px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .book-price {
            font-size: 0.95rem;
            font-weight: 800;
            color: #23085A;
            margin-top: auto;
        }

        @media (max-width: 768px) {
            .author-profile-card {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }
        }
    </style>
@endpush

@section('content')
    <div class="author-detail-container">
        <!-- NAVIGASI KEMBALI -->
        <div style="margin-bottom: 20px; font-size: 0.85rem;">
            <a href="{{ route('authors.index') }}" style="color: #23085A; text-decoration: none; font-weight: 700;">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Penulis
            </a>
        </div>

        <!-- IDENTITAS LENGKAP PENULIS -->
        <div class="author-profile-card">
            @php
                $authorName = $author->name ?? ($author->author ?? 'Penulis');
                $authorPhoto = $author->photo ?? ($author->avatar ?? null);
                $authorTitle = $author->title ?? ($author->degree ?? null);
                $authorBio = $author->bio ?? ($author->biography ?? null);
                $booksList = $author->books ?? [];
            @endphp

            @if (!empty($authorPhoto))
                <img src="{{ asset($authorPhoto) }}" class="author-profile-avatar-img" alt="{{ $authorName }}">
            @else
                <div class="author-profile-avatar-initial">
                    {{ strtoupper(substr($authorName, 0, 1)) }}
                </div>
            @endif

            <div class="author-info-wrapper">
                <div class="author-info-name">{{ $authorName }}</div>

                @if (!empty($authorTitle))
                    <div class="author-info-title">{{ $authorTitle }}</div>
                @endif

                <div class="author-info-bio">
                    {{ $authorBio ?? 'Belum ada informasi biografi lengkap untuk penulis ini.' }}
                </div>

                <div class="author-stats-badge">
                    <i class="fa-solid fa-book-open"></i> {{ count($booksList) }} Karya Buku Diterbitkan
                </div>
            </div>
        </div>

        <!-- DAFTAR BUKU KARYA PENULIS -->
        <div class="section-title-wrapper">
            <h2 class="section-title">Daftar Buku Karya {{ $authorName }}</h2>
        </div>

        <div class="books-grid">
            @forelse($booksList as $book)
                <a href="{{ route('books.show', $book->id) }}" class="book-card">
                    @php
                        $bookCover = $book->cover ?? ($book->image ?? ($book->cover_image ?? null));
                    @endphp

                    @if ($bookCover)
                        <img src="{{ asset('storage/' . $bookCover) }}" class="book-cover" alt="{{ $book->title }}"
                            onerror="this.src='https://via.placeholder.com/200x280?text=No+Cover'">
                    @else
                        <img src="https://via.placeholder.com/200x280?text=No+Cover" class="book-cover"
                            alt="{{ $book->title }}">
                    @endif
                    <div class="book-title">{{ $book->title }}</div>
                    <div class="book-price">Rp {{ number_format($book->price ?? 0, 0, ',', '.') }}</div>
                </a>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 40px 0; color: #64748B;">
                    <i class="fa-solid fa-book-bookmark"
                        style="font-size: 2.5rem; margin-bottom: 10px; color: #CBD5E1;"></i>
                    <p>Penulis ini belum memiliki buku terpublikasi.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
