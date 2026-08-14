@extends('admin.app')

@section('content')
    <div class="container-fluid p-0">
        <!-- HEADER PAGE -->
        <div class="d-flex justify-content-between align-items-center mb-4"
            style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <div>
                <h2 style="font-weight: 800; color: #18003C; margin: 0; font-size: 1.5rem;">Kelola Promo & Diskon</h2>
                <p style="color: #64748B; font-size: 0.85rem; margin: 4px 0 0 0;">Atur promo event dan diskon persentase
                    untuk buku.</p>
            </div>
            <a href="{{ route('admin.promos.create') }}" class="btn btn-primary"
                style="background-color: #23085A; border-color: #23085A; padding: 10px 18px; border-radius: 8px; font-weight: 700; text-decoration: none; color: #fff; display: inline-flex; align-items: center; gap: 8px; font-size: 0.85rem;">
                <i class="fa-solid fa-plus" style="color: #FFC000;"></i> Tambah Promo Baru
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success mb-4"
                style="background-color: #D1E7DD; color: #0F5132; padding: 12px 16px; border-radius: 8px; border: 1px solid #BADBCC; margin-bottom: 1.5rem;">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
            </div>
        @endif

        <!-- CARD CONTAINER TABLE -->
        <div class="card shadow-sm"
            style="background: #ffffff; border-radius: 12px; border: 1px solid #E2E8F0; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
            <div class="card-body p-0" style="padding: 0;">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0"
                        style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.85rem;">
                        <thead style="background-color: #F8FAFC; border-bottom: 1px solid #E2E8F0;">
                            <tr>
                                <th style="padding: 14px 20px; font-weight: 700; color: #475569; width: 60px;">NO</th>
                                <th style="padding: 14px 20px; font-weight: 700; color: #475569;">NAMA PROMO</th>
                                <th style="padding: 14px 20px; font-weight: 700; color: #475569;">BESAR DISKON</th>
                                <th style="padding: 14px 20px; font-weight: 700; color: #475569;">JUMLAH BUKU</th>
                                <th style="padding: 14px 20px; font-weight: 700; color: #475569;">STATUS</th>
                                <th
                                    style="padding: 14px 20px; font-weight: 700; color: #475569; text-align: center; width: 120px;">
                                    AKSI</th>
                            </tr>
                        </thead>
                        <tbody style="divide-y: 1px solid #E2E8F0;">
                            @forelse ($promotions as $index => $promo)
                                <tr style="border-bottom: 1px solid #F1F5F9;">
                                    <td style="padding: 16px 20px; color: #64748B;">
                                        {{ $promotions->firstItem() + $index }}
                                    </td>
                                    <td style="padding: 16px 20px;">
                                        <strong style="color: #1E293B; font-weight: 700;">{{ $promo->name }}</strong>
                                    </td>
                                    <td style="padding: 16px 20px;">
                                        <span
                                            style="background: #FEF2F2; color: #EF4444; border: 1px solid #FCA5A5; padding: 4px 10px; border-radius: 20px; font-weight: 700; font-size: 0.78rem; display: inline-flex; align-items: center; gap: 4px;">
                                            <i class="fa-solid fa-tag"></i> {{ (float) $promo->discount_percentage }}% OFF
                                        </span>
                                    </td>
                                    <td style="padding: 16px 20px; color: #334155;">
                                        <i class="fa-solid fa-book me-1" style="color: #64748B;"></i>
                                        {{ $promo->books_count }} Buku
                                    </td>
                                    <td style="padding: 16px 20px;">
                                        @if ($promo->is_active)
                                            <span
                                                style="background: #ECFDF5; color: #059669; border: 1px solid #A7F3D0; padding: 4px 10px; border-radius: 20px; font-weight: 700; font-size: 0.75rem; display: inline-flex; align-items: center; gap: 6px;">
                                                <span
                                                    style="width: 6px; height: 6px; background-color: #10B981; border-radius: 50%;"></span>
                                                Aktif
                                            </span>
                                        @else
                                            <span
                                                style="background: #F1F5F9; color: #64748B; border: 1px solid #CBD5E1; padding: 4px 10px; border-radius: 20px; font-weight: 700; font-size: 0.75rem; display: inline-flex; align-items: center; gap: 6px;">
                                                <span
                                                    style="width: 6px; height: 6px; background-color: #94A3B8; border-radius: 50%;"></span>
                                                Non-Aktif
                                            </span>
                                        @endif
                                    </td>
                                    <td style="padding: 16px 20px; text-align: center;">
                                        <div style="display: flex; gap: 8px; justify-content: center;">
                                            <a href="{{ route('admin.promos.edit', $promo->id) }}" title="Edit Promo"
                                                style="color: #64748B; background: transparent; width: 34px; height: 34px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; transition: all 0.2s;"
                                                onmouseover="this.style.background='#F1F5F9'; this.style.color='#0F172A';"
                                                onmouseout="this.style.background='transparent'; this.style.color='#64748B';">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <form action="{{ route('admin.promos.destroy', $promo->id) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Yakin ingin menghapus promo ini?')"
                                                style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" title="Hapus Promo"
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
                                    <td colspan="6" style="text-align: center; padding: 40px 20px; color: #94A3B8;">
                                        <i class="fa-solid fa-tags"
                                            style="font-size: 2rem; margin-bottom: 8px; display: block;"></i>
                                        Belum ada promo yang dibuat.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($promotions->hasPages())
                    <div style="padding: 16px 20px; border-top: 1px solid #E2E8F0;">
                        {{ $promotions->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
