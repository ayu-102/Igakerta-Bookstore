@extends('admin.app')

@section('content')
    <!-- Hapus max-width: 1100px dan margin: 0 auto agar tampilan memenuhi kontainer kanan-kiri -->
    <div class="page-container" style="padding: 24px 32px; width: 100%; box-sizing: border-box; color: #1E293B;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
            <h1 style="font-size: 1.35rem; font-weight: 800; color: #0F172A; margin: 0;">Kelola Artikel</h1>
            <a href="{{ route('admin.articles.create') }}"
                style="background: #2D1558; color: #fff; padding: 10px 18px; border-radius: 10px; font-weight: 600; font-size: 0.875rem; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-plus"></i> Tambah Artikel Baru
            </a>
        </div>

        @if (session('success'))
            <div
                style="background: #DEF7EC; color: #03543F; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 0.875rem;">
                {{ session('success') }}
            </div>
        @endif

        <div
            style="background: #fff; border-radius: 16px; border: 1px solid #E2E8F0; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); width: 100%;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.875rem;">
                <thead style="background: #F8FAFC; border-bottom: 1px solid #E2E8F0; font-weight: 700; color: #475569;">
                    <tr>
                        <th style="padding: 14px 18px;">Gambar</th>
                        <th style="padding: 14px 18px;">Judul Artikel</th>
                        <th style="padding: 14px 18px;">Kategori</th>
                        <th style="padding: 14px 18px;">Penulis</th>
                        <th style="padding: 14px 18px;">Estimasi</th>
                        <th style="padding: 14px 18px; text-align: center;">Featured</th>
                        <th style="padding: 14px 18px; text-align: center; width: 120px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($articles as $article)
                        <tr style="border-bottom: 1px solid #F1F5F9;">
                            <td style="padding: 12px 18px;">
                                <img src="{{ $article->thumbnail ? asset('storage/' . $article->thumbnail) : 'https://via.placeholder.com/60x40' }}"
                                    alt="thumb"
                                    style="width: 60px; height: 40px; object-fit: cover; border-radius: 6px;">
                            </td>
                            <td style="padding: 12px 18px; font-weight: 700; color: #0F172A;">
                                {{ Str::limit($article->title, 50) }}
                            </td>
                            <td style="padding: 12px 18px;">
                                <span
                                    style="background: #EDE9FE; color: #23085A; padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 700;">
                                    {{ $article->category }}
                                </span>
                            </td>
                            <td style="padding: 12px 18px; color: #64748B;">{{ $article->author_name ?? 'Admin' }}</td>
                            <td style="padding: 12px 18px; color: #64748B;">{{ $article->read_time }} min</td>
                            <td style="padding: 12px 18px; text-align: center;">
                                @if ($article->is_featured)
                                    <span
                                        style="background: #FEF3C7; color: #D97706; border: 1px solid #FDE68A; padding: 4px 10px; border-radius: 20px; font-weight: 700; font-size: 0.75rem; display: inline-flex; align-items: center; gap: 4px;">
                                        <i class="fa-solid fa-star" style="font-size: 0.7rem;"></i> Featured
                                    </span>
                                @else
                                    <span
                                        style="background: #F1F5F9; color: #94A3B8; border: 1px solid #E2E8F0; padding: 4px 10px; border-radius: 20px; font-weight: 600; font-size: 0.75rem; display: inline-flex; align-items: center;">
                                        Biasa
                                    </span>
                                @endif
                            </td>
                            <td style="padding: 12px 18px; text-align: center;">
                                <div style="display: flex; gap: 8px; justify-content: center;">
                                    <a href="{{ route('admin.articles.edit', $article->id) }}" title="Edit Artikel"
                                        style="color: #64748B; background: transparent; width: 34px; height: 34px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; transition: all 0.2s;"
                                        onmouseover="this.style.background='#F1F5F9'; this.style.color='#0F172A';"
                                        onmouseout="this.style.background='transparent'; this.style.color='#64748B';">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST"
                                        style="display: inline-block;"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus artikel ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Hapus Artikel"
                                            style="color: #64748B; background: transparent; width: 34px; height: 34px; border-radius: 8px; border: none; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s;"
                                            onmouseover="this.style.background='#F1F5F9'; this.style.color='#0F172A';"
                                            onmouseout="this.style.background='transparent'; this.style.color='#64748B';">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 40px; color: #94A3B8;">Belum ada artikel.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 20px;">
            {{ $articles->links() }}
        </div>
    </div>
@endsection
