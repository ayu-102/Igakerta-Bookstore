<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AuthorController extends Controller
{
    public function index(Request $request)
    {
        $query = Author::query();

        // Filter Search (Nama atau Gelar)
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('title', 'like', '%' . $request->search . '%');
            });
        }

        // Filter Status Featured / Regular
        if ($request->filled('status')) {
            if ($request->status === 'featured') {
                $query->where('is_featured', true);
            } elseif ($request->status === 'regular') {
                $query->where('is_featured', false);
            }
        }

        $authors = $query->latest()->paginate(10);

        return view('admin.authors.index', compact('authors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'bio' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('authors', 'public');
        }

        $validated['is_featured'] = $request->has('is_featured');

        Author::create($validated);

        return redirect()->back()->with('success', 'Penulis berhasil ditambahkan.');
    }

    public function edit(Author $author)
    {
        return view('admin.authors.edit', compact('author'));
    }

    public function update(Request $request, Author $author)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'bio' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
        ]);

        if ($request->hasFile('photo')) {
            if ($author->photo) {
                Storage::disk('public')->delete($author->photo);
            }
            $validated['photo'] = $request->file('photo')->store('authors', 'public');
        }

        $validated['is_featured'] = $request->has('is_featured');

        $author->update($validated);

        return redirect()->back()->with('success', 'Data penulis berhasil diperbarui.');
    }

    public function destroy(Author $author)
    {
        if ($author->photo) {
            Storage::disk('public')->delete($author->photo);
        }

        $author->delete();

        return redirect()->back()->with('success', 'Penulis berhasil dihapus.');
    }

    // Toggle status Penulis Pilihan secara cepat
    public function toggleFeatured(Author $author)
    {
        $author->update([
            'is_featured' => !$author->is_featured
        ]);

        return redirect()->back()->with('success', 'Status penulis pilihan berhasil diubah.');
    }

    public function create()
    {
        return view('admin.authors.create');
    }
}
