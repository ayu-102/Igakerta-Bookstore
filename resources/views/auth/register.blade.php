@extends('layouts.app')

@section('title', 'Daftar Akun - IGAKERTA Book Store')

@push('styles')
    <style>
        body,
        html {
            background-color: #F8FAFC;
        }

        .auth-wrapper {
            max-width: 960px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .auth-card-outer {
            background: #FFFFFF;
            border-radius: 16px;
            padding: 40px;
            border: 1px solid #E2E8F0;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 40px;
            align-items: center;
        }

        @media (max-width: 868px) {
            .auth-card-outer {
                grid-template-columns: 1fr;
            }
        }

        .auth-section-title {
            font-size: 1.4rem;
            font-weight: 800;
            color: #0F172A;
            margin: 0 0 4px 0;
        }

        .auth-section-sub {
            font-size: 0.8rem;
            color: #64748B;
            margin-bottom: 24px;
        }

        .form-group {
            margin-bottom: 14px;
        }

        .form-label {
            display: block;
            font-size: 0.78rem;
            font-weight: 700;
            color: #1E293B;
            margin-bottom: 6px;
        }

        .input-group-custom {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-group-custom i.icon-left {
            position: absolute;
            left: 14px;
            color: #94A3B8;
            font-size: 0.85rem;
        }

        .input-group-custom i.icon-right {
            position: absolute;
            right: 14px;
            color: #94A3B8;
            font-size: 0.85rem;
            cursor: pointer;
        }

        .form-control-custom {
            width: 100%;
            padding: 11px 14px 11px 38px;
            font-size: 0.82rem;
            border: 1px solid #CBD5E1;
            border-radius: 8px;
            outline: none;
            transition: all 0.2s;
        }

        .form-control-custom:focus {
            border-color: #23085A;
            box-shadow: 0 0 0 3px rgba(35, 8, 90, 0.08);
        }

        .checkbox-custom {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #334155;
            cursor: pointer;
        }

        .checkbox-custom input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: #23085A;
        }

        .forgot-link {
            color: #6B21A8;
            font-weight: 600;
            text-decoration: none;
        }

        .btn-auth-primary {
            width: 100%;
            background: #23085A;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-auth-primary:hover {
            background: #3B1287;
        }

        .benefits-panel {
            border-left: 1px solid #E2E8F0;
            padding-left: 30px;
        }

        @media (max-width: 868px) {
            .benefits-panel {
                border-left: none;
                border-top: 1px solid #E2E8F0;
                padding-left: 0;
                padding-top: 30px;
            }
        }

        .benefits-illustration {
            width: 130px;
            height: auto;
            margin: 0 auto 16px auto;
            display: block;
        }

        .benefits-title {
            font-size: 0.95rem;
            font-weight: 800;
            color: #0F172A;
            margin-bottom: 18px;
        }

        .benefits-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .benefit-item {
            display: flex;
            gap: 12px;
            margin-bottom: 14px;
            align-items: flex-start;
        }

        .benefit-icon {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: #F3E8FF;
            color: #23085A;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            flex-shrink: 0;
        }

        .benefit-text h5 {
            font-size: 0.78rem;
            font-weight: 700;
            color: #0F172A;
            margin: 0 0 2px 0;
        }

        .benefit-text p {
            font-size: 0.7rem;
            color: #64748B;
            margin: 0;
            line-height: 1.35;
        }
    </style>
@endpush

@section('content')
    <div class="auth-wrapper">
        <div class="auth-card-outer">

            @if ($errors->any())
                <div
                    style="background-color: #FEE2E2; border: 1px solid #FCA5A5; color: #991B1B; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 0.8rem;">
                    <ul style="margin: 0; padding-left: 18px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- FORM REGISTER -->
            <div>
                <h2 class="auth-section-title">Daftar Akun</h2>
                <p class="auth-section-sub">Buat akun baru untuk pengalaman belanja terbaik</p>

                <form action="{{ route('register.post') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Nama Lengkap</label>
                        <div class="input-group-custom">
                            <i class="fa-regular fa-user icon-left"></i>
                            <input type="text" name="name" class="form-control-custom"
                                placeholder="Masukkan nama lengkap" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <div class="input-group-custom">
                            <i class="fa-regular fa-envelope icon-left"></i>
                            <input type="email" name="email" class="form-control-custom"
                                placeholder="Masukkan email Anda" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">No. Telepon</label>
                        <div class="input-group-custom">
                            <i class="fa-solid fa-phone icon-left"></i>
                            <input type="text" name="phone" class="form-control-custom"
                                placeholder="Masukkan nomor telepon" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <div class="input-group-custom">
                            <i class="fa-solid fa-lock icon-left"></i>
                            <input type="password" id="reg-password" name="password" class="form-control-custom"
                                placeholder="Buat password (min. 6 karakter)" required>
                            <i class="fa-regular fa-eye icon-right" onclick="togglePassword('reg-password', this)"></i>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Konfirmasi Password</label>
                        <div class="input-group-custom">
                            <i class="fa-solid fa-lock icon-left"></i>
                            <input type="password" id="reg-confirm-password" name="password_confirmation"
                                class="form-control-custom" placeholder="Ulangi password Anda" required>
                            <i class="fa-regular fa-eye icon-right"
                                onclick="togglePassword('reg-confirm-password', this)"></i>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom: 20px;">
                        <label class="checkbox-custom" style="font-size: 0.72rem;">
                            <input type="checkbox" name="terms" checked required>
                            <span>Saya menyetujui <a href="#" class="forgot-link">Syarat & Ketentuan</a> dan <a
                                    href="#" class="forgot-link">Kebijakan Privasi</a></span>
                        </label>
                    </div>

                    <button type="submit" class="btn-auth-primary">Daftar Sekarang</button>

                    <div style="text-align: center; margin-top: 18px; font-size: 0.78rem; color: #64748B;">
                        Sudah punya akun? <a href="{{ route('login') }}" class="forgot-link">Masuk di sini</a>
                    </div>
                </form>
            </div>

            <!-- PANEL BENEFIT (KANAN) -->
            <div class="benefits-panel">
                <svg class="benefits-illustration" viewBox="0 0 200 180" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M42 120 C 35 105, 15 100, 20 85 C 25 70, 45 80, 42 120 Z" fill="#4ADE80" />
                    <path d="M42 120 C 45 100, 60 90, 55 75 C 50 60, 35 75, 42 120 Z" fill="#22C55E" />
                    <rect x="30" y="120" width="24" height="28" rx="4" fill="#94A3B8" />
                    <rect x="75" y="60" width="60" height="88" rx="8" fill="#23085A" />
                    <path d="M90 60 C 90 40, 120 40, 120 60" stroke="#4A1996" stroke-width="4" fill="none" />
                    <circle cx="105" cy="100" r="14" fill="#FFC000" />
                    <path d="M101 92 H107 C110 92 111 94 111 96.5 C111 99 110 101 107 101 H101 V108 V92" stroke="#23085A"
                        stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" fill="none" />
                    <rect x="145" y="80" width="10" height="68" rx="2" fill="#D97706" />
                    <rect x="157" y="70" width="12" height="78" rx="2" fill="#1E293B" />
                    <rect x="171" y="90" width="8" height="58" rx="2" fill="#2563EB" />
                </svg>

                <h4 class="benefits-title">Kenapa membuat akun?</h4>

                <ul class="benefits-list">
                    <li class="benefit-item">
                        <div class="benefit-icon"><i class="fa-solid fa-bolt"></i></div>
                        <div class="benefit-text">
                            <h5>Belanja lebih cepat</h5>
                            <p>Simpan alamat untuk transaksi mudah</p>
                        </div>
                    </li>
                    <li class="benefit-item">
                        <div class="benefit-icon"><i class="fa-solid fa-box"></i></div>
                        <div class="benefit-text">
                            <h5>Lacak pesanan</h5>
                            <p>Pantau status pesanan real-time</p>
                        </div>
                    </li>
                    <li class="benefit-item">
                        <div class="benefit-icon"><i class="fa-regular fa-heart"></i></div>
                        <div class="benefit-text">
                            <h5>Wishlist</h5>
                            <p>Simpan buku favorit Anda</p>
                        </div>
                    </li>
                    <li class="benefit-item">
                        <div class="benefit-icon"><i class="fa-solid fa-percent"></i></div>
                        <div class="benefit-text">
                            <h5>Promo eksklusif</h5>
                            <p>Dapatkan penawaran spesial</p>
                        </div>
                    </li>
                </ul>
            </div>

        </div>
    </div>

    @push('scripts')
        <script>
            function togglePassword(inputId, icon) {
                const input = document.getElementById(inputId);
                if (input.type === "password") {
                    input.type = "text";
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = "password";
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            }
        </script>
    @endpush
@endsection
