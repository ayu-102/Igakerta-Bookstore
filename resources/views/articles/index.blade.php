@extends('layouts.app')

@section('title', 'Artikel & Wawasan Literasi - IGAKERTA')

@push('styles')
    <style>
        /* BANNER HEADER DESIGN (HERO BACKGROUND STYLE) */
        .articles-header {
            background: linear-gradient(90deg, #18003C 0%, #290858 55%, rgba(41, 8, 88, 0.45) 100%),
                url('https://images.unsplash.com/photo-1499750310107-5fef28a66643?q=80&w=1200&auto=format&fit=crop') center / cover no-repeat;
            border-radius: 16px;
            color: white;
            padding: 35px 45px;
            margin: 1% 6% 25px 6%;
            width: auto;
            position: relative;
            overflow: hidden;
            box-sizing: border-box;
            min-height: 160px;
            display: flex;
            align-items: center;
        }

        .articles-header-content {
            max-width: 650px;
            position: relative;
            z-index: 2;
        }

        .breadcrumb-item {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 8px;
        }

        .breadcrumb-item a {
            color: #FFC000;
            text-decoration: none;
            font-weight: 600;
        }

        .articles-header h1 {
            font-size: 1.85rem;
            font-weight: 800;
            margin-bottom: 8px;
            color: #FFFFFF;
            letter-spacing: -0.5px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .articles-header p {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.9);
            line-height: 1.5;
            margin: 0;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
        }

        /* TOOLBAR (FILTER KATEGORI & SEARCH BAR) */
        .toolbar-wrapper {
            padding: 0 6%;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .category-pills {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .pill-btn {
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            color: #64748B;
            background: #F1F5F9;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .pill-btn:hover,
        .pill-btn.active {
            background: #23085A;
            color: #FFFFFF;
        }

        .article-search-box {
            width: 100%;
            max-width: 320px;
            display: flex;
            align-items: center;
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 10px;
            padding: 4px 6px 4px 14px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .article-search-box input {
            flex: 1;
            border: none;
            outline: none;
            font-size: 0.83rem;
            color: #1E293B;
            background: transparent;
        }

        .article-search-box button {
            background: #23085A;
            color: #FFFFFF;
            border: none;
            padding: 8px 14px;
            border-radius: 7px;
            font-weight: 600;
            cursor: pointer;
            font-size: 0.8rem;
        }

        /* MAIN CONTAINER */
        .articles-container {
            padding: 0 6% 40px;
        }

        /* GRID ARTIKEL */
        .articles-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 24px;
        }

        .article-card {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 12px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .article-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.06);
        }

        .article-thumb {
            width: 100%;
            height: 180px;
            object-fit: cover;
            background: #F8FAFC;
        }

        .article-body {
            padding: 18px;
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .article-badge {
            font-size: 0.7rem;
            font-weight: 700;
            color: #23085A;
            background: #EDE9FE;
            padding: 3px 10px;
            border-radius: 20px;
            align-self: flex-start;
            margin-bottom: 10px;
        }

        .article-title {
            font-size: 1.05rem;
            font-weight: 800;
            color: #1E293B;
            line-height: 1.4;
            margin-bottom: 8px;
            text-decoration: none;
        }

        .article-title a {
            color: inherit;
            text-decoration: none;
            transition: color 0.2s;
        }

        .article-title a:hover {
            color: #4A1996;
        }

        .article-excerpt {
            font-size: 0.82rem;
            color: #64748B;
            line-height: 1.5;
            margin-bottom: 15px;
            flex: 1;
        }

        .article-meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.73rem;
            color: #94A3B8;
            border-top: 1px solid #F1F5F9;
            padding-top: 12px;
        }

        .article-meta span {
            display: flex;
            align-items: center;
            gap: 5px;
        }
    </style>
@endpush

@section('content')
    <!-- BANNER HEADER -->
    <div class="articles-header">
        <div class="articles-header-content">
            <div class="breadcrumb-item">
                <a href="{{ route('home') }}">Beranda</a> &gt; <span>Artikel & Blog</span>
            </div>
            <h1>Artikel & Wawasan Literasi</h1>
            <p>Temukan rekomendasi buku, tips membaca, wawancara penulis, dan kabar terbaru seputar dunia literasi.</p>
        </div>
    </div>

    <!-- TOOLBAR (FILTER KATEGORI & PENCARIAN) -->
    <div class="toolbar-wrapper">
        <div class="category-pills">
            @foreach ($articleCategories as $cat)
                <a href="{{ route('articles.index', ['category' => $cat]) }}"
                    class="pill-btn {{ request('category', 'Semua') == $cat ? 'active' : '' }}">
                    {{ $cat }}
                </a>
            @endforeach
        </div>

        <form action="{{ route('articles.index') }}" method="GET" class="article-search-box">
            @if (request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif
            <input type="text" name="search" placeholder="Cari artikel..." value="{{ request('search') }}">
            <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>
    </div>

    <!-- MAIN ARTICLES CONTAINER -->
    <div class="articles-container">
        @if ($articles->count() > 0)
            <div class="articles-grid">
                @foreach ($articles as $article)
                    <div class="article-card">
                        <a href="{{ route('articles.show', $article->slug) }}">
                            <img src="{{ $article->thumbnail ? asset('storage/' . $article->thumbnail) : 'https://images.unsplash.com/photo-1457369804613-52c61a468e7d?q=80&w=600&auto=format&fit=crop' }}"
                                alt="{{ $article->title }}" class="article-thumb">
                        </a>
                        <div class="article-body">
                            <span class="article-badge">{{ $article->category }}</span>
                            <h3 class="article-title">
                                <a href="{{ route('articles.show', $article->slug) }}">{{ $article->title }}</a>
                            </h3>
                            <p class="article-excerpt">{{ Str::limit($article->excerpt, 110) }}</p>
                            <div class="article-meta">
                                <span><i class="fa-regular fa-calendar"></i>
                                    {{ $article->created_at->format('d M Y') }}</span>
                                <span><i class="fa-regular fa-clock"></i> {{ $article->read_time }} min read</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div style="margin-top: 35px;">
                {{ $articles->links() }}
            </div>
        @else
            <div
                style="background: #F8FAFC; border: 1px dashed #CBD5E1; padding: 40px; border-radius: 12px; text-align: center; color: #64748B;">
                <i class="fa-regular fa-newspaper" style="font-size: 2rem; margin-bottom: 10px; color: #94A3B8;"></i>
                <p style="margin: 0; font-size: 0.9rem;">Belum ada artikel yang ditemukan.</p>
            </div>
        @endif
    </div>
@endsection
