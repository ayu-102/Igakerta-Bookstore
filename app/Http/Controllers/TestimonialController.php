<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    // Mengambil testimoni aktif untuk halaman utama (Frontend)
    public function getActiveTestimonials()
    {
        $testimonials = Testimonial::where('is_active', true)
            ->latest()
            ->take(6)
            ->get();

        return $testimonials;
    }

    // CRUD Sederhana (Contoh untuk Admin Dashboard)
    public function index()
    {
        $testimonials = Testimonial::latest()->paginate(10);
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'quote' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('avatar')) {
            $validated['avatar'] = $request->file('avatar')->store('testimonials', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        Testimonial::create($validated);

        return redirect()->back()->with('success', 'Testimoni berhasil ditambahkan.');
    }
}
