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
            border-color: var(--primary-medium, #2D1558);
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
            <h1 class="page-title">Edit Data Penerbit</h1>
            <a href="{{ route('admin.publishers.index') }}" class="btn-back">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>

        <!-- FORM CARD -->
        <div class="card-form">
            <form action="{{ route('admin.publishers.update', $publisher->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- NAMA PENERBIT -->
                <div class="form-group">
                    <label class="form-label">Nama Penerbit <span style="color: #EF4444;">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $publisher->name) }}"
                        required placeholder="Contoh: PT Gramedia Pustaka Utama">
                    @error('name')
                        <small style="color: #EF4444; font-size: 0.75rem;">{{ $message }}</small>
                    @enderror
                </div>

                <!-- NO TELEPON / KONTAK -->
                <div class="form-group">
                    <label class="form-label">No. Telepon / WhatsApp</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $publisher->phone) }}"
                        placeholder="Contoh: 021-53650110 atau 081234567890">
                    <small style="color: #64748B; font-size: 0.75rem;">Nomor telepon resmi atau layanan pelanggan
                        penerbit.</small>
                    @error('phone')
                        <small style="color: #EF4444; font-size: 0.75rem;">{{ $message }}</small>
                    @enderror
                </div>

                <!-- ALAMAT PENERBIT -->
                <div class="form-group">
                    <label class="form-label">Alamat Kantor / Penerbit</label>
                    <textarea name="address" rows="4" class="form-control" placeholder="Tuliskan alamat lengkap kantor penerbit...">{{ old('address', $publisher->address) }}</textarea>
                    @error('address')
                        <small style="color: #EF4444; font-size: 0.75rem;">{{ $message }}</small>
                    @enderror
                </div>

                <!-- TOMBOL SIMPAN -->
                <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 28px;">
                    <a href="{{ route('admin.publishers.index') }}" class="btn-back">Batal</a>
                    <button type="submit" class="btn-submit">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
