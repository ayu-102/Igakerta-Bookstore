@extends('admin.app')

@section('content')
    <div class="page-container" style="padding: 24px; max-width: 800px; margin: 0 auto; color: #1E293B;">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px;">
            <h1 style="font-size: 1.35rem; font-weight: 800; color: #0F172A; margin: 0;">Tambah Artikel Baru</h1>
            <a href="{{ route('admin.articles.index') }}"
                style="background: #F1F5F9; color: #475569; padding: 9px 16px; border-radius: 10px; font-size: 0.875rem; font-weight: 600; text-decoration: none;">
                &larr; Kembali
            </a>
        </div>

        <div
            style="background: #FFFFFF; border-radius: 16px; border: 1px solid #E2E8F0; padding: 28px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
            <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Judul -->
                <div style="margin-bottom: 20px;">
                    <label
                        style="display: block; font-size: 0.775rem; font-weight: 700; color: #475569; margin-bottom: 8px; text-transform: uppercase;">Judul
                        Artikel *</label>
                    <input type="text" name="title" value="{{ old('title') }}" required
                        style="width: 100%; padding: 10px 14px; border: 1px solid #CBD5E1; border-radius: 8px; font-size: 0.875rem; box-sizing: border-box;">
                </div>

                <!-- Kategori & Estimasi Baca -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 20px;">
                    <div>
                        <label
                            style="display: block; font-size: 0.775rem; font-weight: 700; color: #475569; margin-bottom: 8px; text-transform: uppercase;">Kategori
                            *</label>
                        <select name="category" required
                            style="width: 100%; padding: 10px 14px; border: 1px solid #CBD5E1; border-radius: 8px; font-size: 0.875rem; box-sizing: border-box;">
                            @foreach ($categories as $cat)
                                <option value="{{ $cat }}">{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label
                            style="display: block; font-size: 0.775rem; font-weight: 700; color: #475569; margin-bottom: 8px; text-transform: uppercase;">Waktu
                            Baca (Menit) *</label>
                        <input type="number" name="read_time" value="{{ old('read_time', 3) }}" min="1" required
                            style="width: 100%; padding: 10px 14px; border: 1px solid #CBD5E1; border-radius: 8px; font-size: 0.875rem; box-sizing: border-box;">
                    </div>
                </div>

                <!-- Input Upload Foto (Thumbnail) -->
                <div style="margin-bottom: 20px;">
                    <label
                        style="display: block; font-size: 0.775rem; font-weight: 700; color: #475569; margin-bottom: 8px; text-transform: uppercase;">Foto
                        Sampul / Thumbnail</label>
                    <input type="file" name="thumbnail" accept="image/*"
                        style="width: 100%; padding: 10px 14px; border: 1px solid #CBD5E1; border-radius: 8px; font-size: 0.875rem; box-sizing: border-box;">
                    <span style="font-size: 0.75rem; color: #64748B;">Format: JPG, PNG, WEBP (Maksimal 2MB)</span>
                </div>

                <!-- Nama Penulis -->
                <div style="margin-bottom: 20px;">
                    <label
                        style="display: block; font-size: 0.775rem; font-weight: 700; color: #475569; margin-bottom: 8px; text-transform: uppercase;">Nama
                        Penulis Artikel</label>
                    <input type="text" name="author_name" value="{{ old('author_name', 'Tim Redaksi') }}"
                        style="width: 100%; padding: 10px 14px; border: 1px solid #CBD5E1; border-radius: 8px; font-size: 0.875rem; box-sizing: border-box;">
                </div>

                <!-- Ringkasan (Excerpt) -->
                <div style="margin-bottom: 20px;">
                    <label
                        style="display: block; font-size: 0.775rem; font-weight: 700; color: #475569; margin-bottom: 8px; text-transform: uppercase;">Ringkasan
                        Singkat (Excerpt) *</label>
                    <textarea name="excerpt" rows="3" required
                        style="width: 100%; padding: 10px 14px; border: 1px solid #CBD5E1; border-radius: 8px; font-size: 0.875rem; box-sizing: border-box;">{{ old('excerpt') }}</textarea>
                </div>

                <!-- Isi Artikel Lengkap -->
                <div style="margin-bottom: 20px;">
                    <label
                        style="display: block; font-size: 0.775rem; font-weight: 700; color: #475569; margin-bottom: 8px; text-transform: uppercase;">Isi
                        Lengkap Artikel *</label>
                    <textarea name="content" rows="10" required
                        style="width: 100%; padding: 10px 14px; border: 1px solid #CBD5E1; border-radius: 8px; font-size: 0.875rem; box-sizing: border-box;">{{ old('content') }}</textarea>
                </div>

                <!-- Featured Checkbox -->
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 24px;">
                    <input type="checkbox" name="is_featured" id="is_featured" value="1"
                        style="width: 18px; height: 18px;">
                    <label for="is_featured"
                        style="font-size: 0.875rem; font-weight: 600; color: #334155; cursor: pointer;">Tampilkan sebagai
                        Artikel Utama / Pilihan</label>
                </div>

                <!-- Submit Button -->
                <div
                    style="display: flex; justify-content: flex-end; gap: 12px; border-top: 1px solid #F1F5F9; padding-top: 20px;">
                    <button type="submit"
                        style="background-color: #2D1558; color: #FFFFFF; padding: 11px 22px; border-radius: 10px; font-size: 0.875rem; font-weight: 600; border: none; cursor: pointer;">
                        Terbitkan Artikel
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
