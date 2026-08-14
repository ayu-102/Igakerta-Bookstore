<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::query();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('author_name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $articles = $query->latest()->paginate(10);
        $categories = ['Rekomendasi', 'Tips Membaca', 'Wawancara', 'Berita'];

        return view('admin.articles.index', compact('articles', 'categories'));
    }

    public function create()
    {
        $categories = ['Rekomendasi', 'Tips Membaca', 'Wawancara', 'Berita'];
        return view('admin.articles.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'category'    => 'required|string',
            'thumbnail'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'excerpt'     => 'required|string|max:500',
            'content'     => 'required|string',
            'author_name' => 'nullable|string|max:255',
            'read_time'   => 'required|integer|min:1',
            'is_featured' => 'nullable|boolean',
        ]);

        $validated['slug'] = Str::slug($request->title);

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('articles', 'public');
        }

        $validated['is_featured'] = $request->has('is_featured');
        $validated['author_name'] = $request->author_name ?? 'Admin';

        Article::create($validated);

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil diterbitkan!');
    }

    public function edit(Article $article)
    {
        $categories = ['Rekomendasi', 'Tips Membaca', 'Wawancara', 'Berita'];
        return view('admin.articles.edit', compact('article', 'categories'));
    }

    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'category'    => 'required|string',
            'thumbnail'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'excerpt'     => 'required|string|max:500',
            'content'     => 'required|string',
            'author_name' => 'nullable|string|max:255',
            'read_time'   => 'required|integer|min:1',
            'is_featured' => 'nullable|boolean',
        ]);

        $validated['slug'] = Str::slug($request->title);

        if ($request->hasFile('thumbnail')) {
            if ($article->thumbnail) {
                Storage::disk('public')->delete($article->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('articles', 'public');
        }

        $validated['is_featured'] = $request->has('is_featured');
        $validated['author_name'] = $request->author_name ?? 'Admin';

        $article->update($validated);

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil diperbarui!');
    }

    public function destroy(Article $article)
    {
        if ($article->thumbnail) {
            Storage::disk('public')->delete($article->thumbnail);
        }

        $article->delete();

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil dihapus!');
    }
}
