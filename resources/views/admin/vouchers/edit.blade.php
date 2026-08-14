@extends('admin.app')

@section('title', 'Edit Voucher')

@push('styles')
    <style>
        .form-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .form-header h2 {
            font-size: 1.4rem;
            font-weight: 800;
            color: var(--primary-dark);
            margin: 0;
        }

        .btn-back {
            background: #F1F5F9;
            color: #475569;
            padding: 9px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 0.83rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
        }

        .btn-back:hover {
            background: #E2E8F0;
            color: #1E293B;
        }

        .card-form {
            background: #FFFFFF;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
            max-width: 800px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 0.83rem;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 8px;
        }

        .form-control {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 0.85rem;
            color: var(--text-main);
            box-sizing: border-box;
            transition: border-color 0.2s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-medium);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .text-error {
            color: #DC2626;
            font-size: 0.75rem;
            margin-top: 4px;
            display: block;
        }

        .btn-submit {
            background: var(--primary-medium);
            color: #FFFFFF;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: background 0.2s;
        }

        .btn-submit:hover {
            background: var(--primary-dark);
            color: var(--accent-yellow);
        }
    </style>
@endpush

@section('content')
    <div>
        <!-- HEADER -->
        <div class="form-header">
            <div>
                <h2>Edit Voucher</h2>
                <p style="font-size: 0.8rem; color: var(--text-muted); margin-top: 2px;">Perbarui data voucher
                    <strong>{{ $voucher->code }}</strong>.
                </p>
            </div>
            <a href="{{ route('admin.vouchers.index') }}" class="btn-back">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>

        <!-- FORM CARD -->
        <div class="card-form">
            <form action="{{ route('admin.vouchers.update', $voucher->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="code">Kode Voucher <span style="color: red;">*</span></label>
                        <input type="text" id="code" name="code" class="form-control"
                            value="{{ old('code', $voucher->code) }}" style="text-transform: uppercase;" required>
                        @error('code')
                            <span class="text-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="title">Judul Promo <span style="color: red;">*</span></label>
                        <input type="text" id="title" name="title" class="form-control"
                            value="{{ old('title', $voucher->title) }}" required>
                        @error('title')
                            <span class="text-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="type">Tipe Diskon <span style="color: red;">*</span></label>
                        <select id="type" name="type" class="form-control" required>
                            <option value="percentage" {{ old('type', $voucher->type) == 'percentage' ? 'selected' : '' }}>
                                Persentase (%)</option>
                            <option value="fixed" {{ old('type', $voucher->type) == 'fixed' ? 'selected' : '' }}>Nominal
                                (Rp)</option>
                        </select>
                        @error('type')
                            <span class="text-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="amount">Nilai Diskon <span style="color: red;">*</span></label>
                        <input type="number" step="any" id="amount" name="amount" class="form-control"
                            value="{{ old('amount', $voucher->amount) }}" required>
                        @error('amount')
                            <span class="text-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="min_purchase">Minimal Belanja (Rp)</label>
                        <input type="number" id="min_purchase" name="min_purchase" class="form-control"
                            value="{{ old('min_purchase', $voucher->min_purchase) }}">
                        @error('min_purchase')
                            <span class="text-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="expiry_date">Tanggal Kadaluarsa</label>
                        <input type="date" id="expiry_date" name="expiry_date" class="form-control"
                            value="{{ old('expiry_date', $voucher->expiry_date ? \Carbon\Carbon::parse($voucher->expiry_date)->format('Y-m-d') : '') }}">
                        @error('expiry_date')
                            <span class="text-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="is_active">Status Voucher</label>
                    <select id="is_active" name="is_active" class="form-control">
                        <option value="1" {{ old('is_active', $voucher->is_active) == 1 ? 'selected' : '' }}>Aktif
                        </option>
                        <option value="0" {{ old('is_active', $voucher->is_active) == 0 ? 'selected' : '' }}>Non-Aktif
                        </option>
                    </select>
                    @error('is_active')
                        <span class="text-error">{{ $message }}</span>
                    @enderror
                </div>

                <div style="margin-top: 28px; text-align: right;">
                    <button type="submit" class="btn-submit">
                        <i class="fa-solid fa-floppy-disk"></i> Perbarui Voucher
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
