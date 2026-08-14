<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::query();

        // Filter berdasarkan pencarian
        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('excerpt', 'like', '%' . $request->search . '%');
        }

        // Filter berdasarkan kategori
        if ($request->has('category') && $request->category != 'Semua') {
            $query->where('category', $request->category);
        }

        $featuredArticle = Article::where('is_featured', true)->latest()->first();
        $articles = $query->latest()->paginate(6)->withQueryString();

        // Gunakan nama variabel yang lebih spesifik
        $articleCategories = ['Semua', 'Rekomendasi', 'Tips Membaca', 'Wawancara', 'Berita'];

        return view('articles.index', compact('articles', 'featuredArticle', 'articleCategories'));
    }

    public function show($slug)
    {
        // Cari artikel berdasarkan slug
        $article = Article::where('slug', $slug)->firstOrFail();

        // Mengambil artikel terkait berdasarkan kategori (opsional untuk saran artikel lain)
        $relatedArticles = Article::where('category', $article->category)
            ->where('id', '!=', $article->id)
            ->take(3)
            ->get();

        return view('articles.show', compact('article', 'relatedArticles'));
    }
}
