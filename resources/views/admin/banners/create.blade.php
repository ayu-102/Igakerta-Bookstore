@extends('admin.app')

@section('title', 'Tambah Banner')

@section('content')
    <div class="card" style="max-width: 600px; margin: 0 auto;">
        <h2 style="margin-bottom: 20px;">Tambah Banner Slider Baru</h2>

        <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div style="margin-bottom: 15px;">
                <label style="display:block; margin-bottom:5px; font-weight:600;">Gambar Banner (Rasio Landscape
                    Widescreen)</label>
                <input type="file" name="image" required class="form-control" accept="image/*"
                    style="width:100%; padding:10px; border:1px solid #CCC; border-radius:6px;">
                <small style="color: #666;">Rekomendasi ukuran: 1200 x 450 px</small>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display:block; margin-bottom:5px; font-weight:600;">Judul / Promo (Opsional)</label>
                <input type="text" name="title" class="form-control" placeholder="Contoh: Promo Diskon Buka Tahun"
                    style="width:100%; padding:10px; border:1px solid #CCC; border-radius:6px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display:block; margin-bottom:5px; font-weight:600;">Link Kategori / URL Promo
                    (Opsional)</label>
                <input type="text" name="link" class="form-control"
                    placeholder="Contoh: #katalog atau https://wa.me/..."
                    style="width:100%; padding:10px; border:1px solid #CCC; border-radius:6px;">
            </div>

            <button type="submit" class="btn btn-primary">Simpan Banner</button>
            <a href="{{ route('admin.banners.index') }}" class="btn"
                style="background:#CCC; color:#333; margin-left:10px;">Batal</a>
        </form>
    </div>
@endsection
