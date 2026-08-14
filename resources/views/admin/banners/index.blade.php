@extends('admin.app')

@section('title', 'Kelola Banner Promo')

@section('content')
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2>Kelola Banner Hero Slider</h2>
            <a href="{{ route('admin.banners.create') }}" class="btn btn-primary">+ Tambah Banner Baru</a>
        </div>

        @if (session('success'))
            <div style="padding: 12px; background: #D4EDDA; color: #155724; border-radius: 8px; margin-bottom: 20px;">
                {{ session('success') }}
            </div>
        @endif

        <table class="table" style="width:100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #F1F3F5; text-align: left;">
                    <th style="padding: 12px;">Gambar Banner</th>
                    <th>Judul/Keterangan</th>
                    <th>Link Tujuan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($banners as $banner)
                    <tr style="border-bottom: 1px solid #EEE;">
                        <td style="padding: 12px;">
                            <img src="{{ asset('storage/' . $banner->image) }}"
                                style="width: 180px; height: 80px; object-fit: cover; border-radius: 6px;">
                        </td>
                        <td>{{ $banner->title ?? '-' }}</td>
                        <td>{{ $banner->link ?? '-' }}</td>
                        <td>
                            <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST"
                                onsubmit="return confirm('Hapus banner ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    style="background:#E63946; color:white; border:none; padding:8px 12px; border-radius:6px; cursor:pointer;"><i
                                        class="fa-solid fa-trash"></i> Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 20px;">Belum ada banner promo. Silakan tambah
                            banner baru!</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
