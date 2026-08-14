<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Publisher;
use Illuminate\Http\Request;

class PublisherController extends Controller
{
    /**
     * Tampilkan daftar penerbit.
     */
    public function index()
    {
        $publishers = Publisher::withCount('books')->latest()->paginate(10);
        return view('admin.publishers.index', compact('publishers'));
    }

    public function create()
    {
        // Ambil data publishers agar tidak undefined di view
        $publishers = Publisher::paginate(10);

        return view('admin.publishers.create', compact('publishers'));
    }

    /**
     * Simpan data penerbit baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        Publisher::create($validated);

        return redirect()->route('admin.publishers.index')
            ->with('success', 'Penerbit berhasil ditambahkan!');
    }

    /**
     * Tampilkan form edit penerbit.
     */
    public function edit(Publisher $publisher)
    {
        return view('admin.publishers.edit', compact('publisher'));
    }

    /**
     * Perbarui data penerbit di database.
     */
    public function update(Request $request, Publisher $publisher)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $publisher->update($validated);

        return redirect()->route('admin.publishers.index')
            ->with('success', 'Data penerbit berhasil diperbarui!');
    }

    /**
     * Hapus data penerbit dari database.
     */
    public function destroy(Publisher $publisher)
    {
        $publisher->delete();

        return redirect()->route('admin.publishers.index')
            ->with('success', 'Penerbit berhasil dihapus!');
    }
}
