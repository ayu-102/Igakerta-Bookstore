@extends('admin.app')

@section('title', 'Pengaturan Sistem')

@push('styles')
    <style>
        /* Wrapper untuk memposisikan seluruh elemen di tengah */
        .settings-wrapper {
            max-width: 800px;
            margin: 0 auto;
        }

        .page-header {
            margin-bottom: 20px;
        }

        .page-title h2 {
            font-size: 1.35rem;
            font-weight: 800;
            color: #0F172A;
            margin: 0 0 4px 0;
        }

        .page-title p {
            font-size: 0.85rem;
            color: #64748B;
            margin: 0;
        }

        .card-settings {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            font-size: 0.8rem;
            font-weight: 700;
            color: #475569;
            margin-bottom: 6px;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #CBD5E1;
            border-radius: 8px;
            font-size: 0.85rem;
            outline: none;
            box-sizing: border-box;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            border-color: var(--primary-medium, #1E0A3C);
        }

        .btn-save {
            padding: 10px 24px;
            background: var(--primary-medium, #1E0A3C);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            cursor: pointer;
            font-size: 0.85rem;
        }
    </style>
@endpush

@section('content')
    <div class="settings-wrapper">
        <div class="page-header">
            <div class="page-title">
                <h2>Pengaturan Toko & Sistem</h2>
                <p>Konfigurasi informasi umum toko buku IGAKERTA Anda</p>
            </div>
        </div>

        @if (session('success'))
            <div
                style="padding: 12px 16px; background: #ECFDF5; border: 1px solid #A7F3D0; color: #065F46; border-radius: 8px; margin-bottom: 20px; font-size: 0.85rem;">
                <i class="fa-solid fa-circle-check" style="margin-right: 6px;"></i> {{ session('success') }}
            </div>
        @endif

        <div class="card-settings">
            <form action="{{ route('admin.settings.update') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Nama Toko Buku</label>
                    <input type="text" name="store_name" value="{{ $settings['store_name'] }}" required>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                    <div class="form-group">
                        <label>Email Support / Kontak</label>
                        <input type="email" name="store_email" value="{{ $settings['store_email'] }}" required>
                    </div>
                    <div class="form-group">
                        <label>No. WhatsApp Operasional</label>
                        <input type="text" name="store_phone" value="{{ $settings['store_phone'] }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Alamat Toko / Penerbit</label>
                    <textarea name="store_address" rows="3">{{ $settings['store_address'] }}</textarea>
                </div>

                <div class="form-group">
                    <label>Teks Hak Cipta Footer</label>
                    <input type="text" name="footer_text" value="{{ $settings['footer_text'] }}">
                </div>

                <button type="submit" class="btn-save">
                    <i class="fa-solid fa-floppy-disk" style="margin-right: 6px;"></i> Simpan Pengaturan
                </button>
            </form>
        </div>
    </div>
@endsection
