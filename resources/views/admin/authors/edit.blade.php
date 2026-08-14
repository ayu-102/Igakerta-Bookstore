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

        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .page-title {
            font-size: 1.35rem;
            font-weight: 800;
            color: var(--primary-dark, #0F172A);
            margin: 0;
        }

        .btn-back {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            color: #475569;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
        }

        .btn-back:hover {
            background: #F8FAFC;
            color: #0F172A;
            border-color: #CBD5E1;
        }

        .card-form {
            background: #FFFFFF;
            border-radius: 12px;
            border: 1px solid #E2E8F0;
            padding: 24px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 0.8rem;
            font-weight: 700;
            color: #334155;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.03em;
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
            border-color: var(--primary-medium, #4F46E5);
        }

        .preview-avatar-wrapper {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-top: 8px;
        }

        .current-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            border: 1px solid #CBD5E1;
        }

        .current-avatar-initial {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: #E0E7FF;
            color: #4338CA;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.25rem;
        }

        .checkbox-label {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-size: 0.875rem;
            font-weight: 600;
            color: #334155;
            cursor: pointer;
        }

        .btn-submit {
            background-color: var(--primary-medium, #2D1558);
            color: #FFFFFF;
            padding: 10px 24px;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: opacity 0.2s;
        }

        .btn-submit:hover {
            opacity: 0.9;
        }
    </style>

    <div class="page-container">
        <!-- HEADER -->
        <div class="page-header">
            <h1 class="page-title">Edit Data Penulis</h1>
            <a href="{{ route('admin.authors.index') }}" class="btn-back">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>

        <!-- FORM CARD -->
        <div class="card-form">
            <form action="{{ route('admin.authors.update', $author->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- NAMA PENULIS -->
                <div class="form-group">
                    <label class="form-label">Nama Lengkap <span style="color: #EF4444;">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $author->name) }}"
                        required>
                </div>

                <!-- GELAR / PERAN -->
                <div class="form-group">
                    <label class="form-label">Gelar / Peran / Sub-Judul</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $author->title) }}"
                        placeholder="Contoh: Dosen & Peneliti Senior">
                </div>

                <!-- FOTO PROFIL -->
                <div class="form-group">
                    <label class="form-label">Foto Profil</label>
                    <div class="preview-avatar-wrapper">
                        @if ($author->photo)
                            <img src="{{ asset('storage/' . $author->photo) }}" class="current-avatar"
                                alt="{{ $author->name }}">
                        @else
                            <div class="current-avatar-initial">
                                {{ strtoupper(substr($author->name, 0, 1)) }}
                            </div>
                        @endif
                        <div style="flex: 1;">
                            <input type="file" name="photo" class="form-control" accept="image/*">
                            <small style="color: #64748B; font-size: 0.75rem;">Biarkan kosong jika tidak ingin mengubah foto
                                profil.</small>
                        </div>
                    </div>
                </div>

                <!-- BIOGRAFI SINGKAT -->
                <div class="form-group">
                    <label class="form-label">Biografi Singkat</label>
                    <textarea name="bio" rows="4" class="form-control"
                        placeholder="Tuliskan riwayat atau profil singkat penulis...">{{ old('bio', $author->bio) }}</textarea>
                </div>

                <!-- STATUS FEATURED -->
                <div class="form-group">
                    <label class="checkbox-label">
                        <input type="checkbox" name="is_featured" value="1"
                            {{ old('is_featured', $author->is_featured) ? 'checked' : '' }}>
                        Jadikan Penulis Pilihan (Featured)
                    </label>
                </div>

                <!-- TOMBOL SIMPAN -->
                <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 28px;">
                    <a href="{{ route('admin.authors.index') }}" class="btn-back">Batal</a>
                    <button type="submit" class="btn-submit">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
