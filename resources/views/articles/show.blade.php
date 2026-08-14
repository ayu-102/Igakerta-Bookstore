@extends('layouts.app')

@section('title', $article->title . ' - IGAKERTA')

@push('styles')
    <style>
        .article-detail-container {
            max-width: 850px;
            margin: 0 auto;
            padding: 30px 20px 60px;
        }

        .breadcrumb-item {
            font-size: 0.85rem;
            color: #64748B;
            margin-bottom: 16px;
        }

        .breadcrumb-item a {
            color: #23085A;
            text-decoration: none;
            font-weight: 600;
        }

        .article-header {
            margin-bottom: 24px;
        }

        .article-badge {
            font-size: 0.75rem;
            font-weight: 700;
            color: #23085A;
            background: #EDE9FE;
            padding: 4px 12px;
            border-radius: 20px;
            display: inline-block;
            margin-bottom: 12px;
        }

        .article-header h1 {
            font-size: 2.1rem;
            font-weight: 800;
            color: #0F172A;
            line-height: 1.3;
            margin-bottom: 16px;
        }

        .article-meta-info {
            display: flex;
            align-items: center;
            gap: 16px;
            font-size: 0.82rem;
            color: #64748B;
            padding-bottom: 20px;
            border-bottom: 1px solid #E2E8F0;
        }

        .article-hero-img {
            width: 100%;
            max-height: 420px;
            object-fit: cover;
            border-radius: 14px;
            margin: 24px 0 32px;
        }

        .article-content {
            font-size: 1.02rem;
            line-height: 1.8;
            color: #334155;
        }

        .article-content p {
            margin-bottom: 1.4rem;
        }

        .article-content h2,
        .article-content h3 {
            color: #0F172A;
            margin-top: 2rem;
            margin-bottom: 1rem;
            font-weight: 700;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #23085A;
            text-decoration: none;
            font-weight: 600;
            margin-top: 40px;
            font-size: 0.9rem;
        }
    </style>
@endpush

@section('content')
    <div class="article-detail-container">
        <!-- BREADCRUMB -->
        <div class="breadcrumb-item">
            <a href="{{ route('home') }}">Beranda</a> &gt;
            <a href="{{ route('articles.index') }}">Artikel</a> &gt;
            <span>Detail</span>
        </div>

        <!-- HEADER ARTIKEL -->
        <div class="article-header">
            <span class="article-badge">{{ $article->category }}</span>
            <h1>{{ $article->title }}</h1>

            <div class="article-meta-info">
                <span><i class="fa-regular fa-user"></i> {{ $article->author_name ?? 'Admin IGAKERTA' }}</span>
                <span><i class="fa-regular fa-calendar"></i> {{ $article->created_at->format('d M Y') }}</span>
                <span><i class="fa-regular fa-clock"></i> {{ $article->read_time }} min read</span>
            </div>
        </div>

        <!-- GAMBAR UTAMA -->
        <img src="{{ $article->thumbnail ? asset('storage/' . $article->thumbnail) : 'https://images.unsplash.com/photo-1457369804613-52c61a468e7d?q=80&w=1200&auto=format&fit=crop' }}"
            alt="{{ $article->title }}" class="article-hero-img">

        <!-- ISI KONTEN ARTIKEL -->
        <div class="article-content">
            {!! nl2br(e($article->content ?? $article->excerpt)) !!}
        </div>

        <a href="{{ route('articles.index') }}" class="back-btn">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Artikel
        </a>
    </div>
@endsection
