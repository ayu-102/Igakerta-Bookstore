@extends('admin.app')

@section('content')
    <div class="container-fluid p-0">
        <!-- HEADER PAGE -->
        <div class="d-flex justify-content-between align-items-center mb-4"
            style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <div>
                <h2 style="font-weight: 800; color: #18003C; margin: 0; font-size: 1.5rem;">Edit Promo: {{ $promo->name }}
                </h2>
                <p style="color: #64748B; font-size: 0.85rem; margin: 4px 0 0 0;">Ubah informasi detail promo atau perbarui
                    daftar buku yang diberi potongan harga.</p>
            </div>
            <a href="{{ route('admin.promos.index') }}" class="btn btn-secondary"
                style="background-color: #64748B; border: none; padding: 10px 18px; border-radius: 8px; font-weight: 700; text-decoration: none; color: #fff; display: inline-flex; align-items: center; gap: 8px; font-size: 0.85rem;">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>

        <form action="{{ route('admin.promos.update', $promo->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row" style="display: flex; flex-wrap: wrap; margin: -12px;">
                <!-- KOLOM KIRI: INFORMASI PROMO -->
                <div class="col-md-5"
                    style="flex: 0 0 41.666667%; max-width: 41.666667%; padding: 12px; box-sizing: border-box;">
                    <div class="card shadow-sm"
                        style="background: #ffffff; border-radius: 12px; border: 1px solid #E2E8F0; overflow: hidden; margin-bottom: 1.5rem;">
                        <div class="card-header bg-white"
                            style="background-color: #ffffff; padding: 16px 20px; border-bottom: 1px solid #E2E8F0;">
                            <strong style="color: #18003C; font-size: 0.95rem;"><i class="fa-solid fa-pen-to-square me-2"
                                    style="color: #23085A;"></i>Informasi Promo</strong>
                        </div>
                        <div class="card-body" style="padding: 20px;">
                            <div class="mb-3" style="margin-bottom: 1rem;">
                                <label class="form-label"
                                    style="display: block; font-weight: 700; font-size: 0.82rem; color: #334155; margin-bottom: 6px;">Nama
                                    Promo / Event</label>
                                <input type="text" name="name" class="form-control"
                                    style="width: 100%; padding: 10px 14px; font-size: 0.85rem; border: 1px solid #CBD5E1; border-radius: 8px; outline: none; box-sizing: border-box;"
                                    value="{{ old('name', $promo->name) }}" required>
                            </div>

                            <div class="mb-3" style="margin-bottom: 1rem;">
                                <label class="form-label"
                                    style="display: block; font-weight: 700; font-size: 0.82rem; color: #334155; margin-bottom: 6px;">Besar
                                    Diskon (%)</label>
                                <input type="number" step="0.01" name="discount_percentage" class="form-control"
                                    style="width: 100%; padding: 10px 14px; font-size: 0.85rem; border: 1px solid #CBD5E1; border-radius: 8px; outline: none; box-sizing: border-box;"
                                    value="{{ old('discount_percentage', $promo->discount_percentage) }}" required>
                            </div>

                            <div class="form-check form-switch mb-2"
                                style="display: flex; align-items: center; gap: 10px; margin-top: 15px;">
                                <input class="form-check-input" type="checkbox" name="is_active" id="is_active"
                                    value="1" {{ $promo->is_active ? 'checked' : '' }}
                                    style="width: 38px; height: 20px; cursor: pointer;">
                                <label class="form-check-label" for="is_active"
                                    style="font-weight: 600; font-size: 0.85rem; color: #334155; cursor: pointer;">Status
                                    Promo Aktif</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- KOLOM KANAN: PILIHAN BUKU -->
                <div class="col-md-7"
                    style="flex: 0 0 58.333333%; max-width: 58.333333%; padding: 12px; box-sizing: border-box;">
                    <div class="card shadow-sm"
                        style="background: #ffffff; border-radius: 12px; border: 1px solid #E2E8F0; overflow: hidden; margin-bottom: 1.5rem;">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center"
                            style="background-color: #ffffff; padding: 14px 20px; border-bottom: 1px solid #E2E8F0; display: flex; justify-content: space-between; align-items: center;">
                            <strong style="color: #18003C; font-size: 0.95rem;"><i class="fa-solid fa-book me-2"
                                    style="color: #23085A;"></i>Pilih Buku Yang Diberi Diskon</strong>
                            <button type="button" class="btn btn-sm btn-outline-primary" id="selectAll"
                                style="background: transparent; color: #23085A; border: 1px solid #23085A; padding: 5px 12px; border-radius: 6px; font-weight: 700; font-size: 0.78rem; cursor: pointer;">
                                Pilih Semua
                            </button>
                        </div>
                        <div class="card-body" style="padding: 20px; max-height: 420px; overflow-y: auto;">
                            <div class="row g-2" style="display: flex; flex-direction: column; gap: 8px;">
                                @foreach ($books as $book)
                                    <div class="col-md-12">
                                        <div class="border rounded p-2.5 d-flex align-items-center justify-content-between"
                                            style="border: 1px solid #E2E8F0; border-radius: 8px; padding: 10px 14px; display: flex; align-items: center; justify-content: space-between; background: #FAFBFD;">
                                            <div class="d-flex align-items-center gap-3"
                                                style="display: flex; align-items: center; gap: 12px;">
                                                <input type="checkbox" name="book_ids[]" value="{{ $book->id }}"
                                                    class="form-check-input book-checkbox" id="book_{{ $book->id }}"
                                                    {{ in_array($book->id, $selectedBookIds) ? 'checked' : '' }}
                                                    style="width: 18px; height: 18px; cursor: pointer;">
                                                <label class="form-check-label" for="book_{{ $book->id }}"
                                                    style="cursor: pointer; margin: 0; font-size: 0.85rem; color: #1E293B; font-weight: 600;">
                                                    {{ $book->title }}
                                                </label>
                                            </div>
                                            <span
                                                style="color: #64748B; font-size: 0.8rem; font-weight: 700; background: #E2E8F0; padding: 3px 8px; border-radius: 4px;">
                                                Rp {{ number_format($book->price, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- SUBMIT BUTTONS -->
                    <div class="d-flex justify-content-end gap-2"
                        style="display: flex; justify-content: flex-end; gap: 10px;">
                        <a href="{{ route('admin.promos.index') }}" class="btn btn-secondary"
                            style="background-color: #94A3B8; color: white; border: none; padding: 10px 20px; border-radius: 8px; font-weight: 700; text-decoration: none; font-size: 0.85rem;">Batal</a>
                        <button type="submit" class="btn btn-primary"
                            style="background-color: #23085A; color: white; border: none; padding: 10px 24px; border-radius: 8px; font-weight: 700; font-size: 0.85rem; cursor: pointer;">
                            <i class="fa-solid fa-arrows-rotate me-1"></i> Update Promo
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('selectAll').addEventListener('click', function() {
            const checkboxes = document.querySelectorAll('.book-checkbox');
            const allChecked = Array.from(checkboxes).every(cb => cb.checked);
            checkboxes.forEach(cb => cb.checked = !allChecked);
            this.textContent = allChecked ? 'Pilih Semua' : 'Batal Pilih Semua';
        });
    </script>
@endsection
