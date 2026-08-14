@extends('admin.app')

@section('content')
    <style>
        .page-container {
            padding: 24px;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            color: #1E293B;
            max-width: 800px;
            margin: 0 auto;
        }

        /* HEADER SECTION */
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .page-title {
            font-size: 1.35rem;
            font-weight: 800;
            color: #0F172A;
            margin: 0;
        }

        .btn-back {
            background-color: #F1F5F9;
            color: #475569;
            padding: 9px 16px;
            border-radius: 10px;
            font-size: 0.875rem;
            font-weight: 600;
            border: 1px solid #E2E8F0;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .btn-back:hover {
            background-color: #E2E8F0;
            color: #0F172A;
        }

        /* FORM CARD */
        .form-card {
            background: #FFFFFF;
            border-radius: 16px;
            border: 1px solid #E2E8F0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            padding: 28px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 0.775rem;
            font-weight: 700;
            color: #475569;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .form-label span {
            color: #EF4444;
        }

        .form-control {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #CBD5E1;
            border-radius: 8px;
            font-size: 0.875rem;
            outline: none;
            box-sizing: border-box;
            transition: border-color 0.2s;
        }

        .form-control:focus {
            border-color: #2D1558;
            box-shadow: 0 0 0 3px rgba(45, 21, 88, 0.1);
        }

        .form-hint {
            font-size: 0.78rem;
            color: #64748B;
            margin-top: 6px;
        }

        .btn-submit {
            background-color: #2D1558;
            color: #FFFFFF;
            padding: 11px 22px;
            border-radius: 10px;
            font-size: 0.875rem;
            font-weight: 600;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-submit:hover {
            background-color: #1E0D3D;
        }

        .form-footer {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 28px;
            padding-top: 20px;
            border-top: 1px solid #F1F5F9;
        }
    </style>

    <div class="page-container">
        <!-- HEADER -->
        <div class="page-header">
            <h1 class="page-title">Tambah Penulis Baru</h1>
            <a href="{{ route('admin.authors.index') }}" class="btn-back">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>

        <!-- FORM CARD -->
        <div class="form-card">
            <form action="{{ route('admin.authors.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Nama Lengkap -->
                <div class="form-group">
                    <label class="form-label">Nama Lengkap <span>*</span></label>
                    <input type="text" name="name" class="form-control" placeholder="Contoh: Prof. Dr. Sugiyono"
                        value="{{ old('name') }}" required>
                    @error('name')
                        <div style="color: #EF4444; font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Gelar / Sub-Judul -->
                <div class="form-group">
                    <label class="form-label">Gelar / Spesialisasi</label>
                    <input type="text" name="title" class="form-control" placeholder="Contoh: Dosen & Peneliti Senior"
                        value="{{ old('title') }}">
                    <div class="form-hint">Akan ditampilkan di bawah nama pada card penulis.</div>
                    @error('title')
                        <div style="color: #EF4444; font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Foto Profil -->
                <div class="form-group">
                    <label class="form-label">Foto Profil</label>
                    <input type="file" name="photo" class="form-control" accept="image/*">
                    <div class="form-hint">Format file: JPG, PNG, WEBP (Maksimal 2MB).</div>
                    @error('photo')
                        <div style="color: #EF4444; font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Biografi Singkat -->
                <div class="form-group">
                    <label class="form-label">Biografi Singkat</label>
                    <textarea name="bio" rows="4" class="form-control"
                        placeholder="Tuliskan riwayat singkat atau informasi profil penulis...">{{ old('bio') }}</textarea>
                    @error('bio')
                        <div style="color: #EF4444; font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Status Featured -->
                <div class="form-group" style="display: flex; align-items: center; gap: 10px; margin-top: 10px;">
                    <input type="checkbox" name="is_featured" id="is_featured" value="1"
                        {{ old('is_featured') ? 'checked' : '' }} style="width: 18px; height: 18px; cursor: pointer;">
                    <label for="is_featured"
                        style="font-size: 0.875rem; font-weight: 600; color: #334155; cursor: pointer;">
                        Jadikan Penulis Pilihan (Featured)
                    </label>
                </div>

                <!-- Action Buttons -->
                <div class="form-footer">
                    <a href="{{ route('admin.authors.index') }}" class="btn-back">Batal</a>
                    <button type="submit" class="btn-submit">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Penulis
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
