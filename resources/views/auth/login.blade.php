@extends('layouts.app')

@section('title', 'Masuk - IGAKERTA Book Store')

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
            margin-bottom: 16px;
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

        .form-flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.78rem;
            margin-bottom: 20px;
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

        .social-divider {
            text-align: center;
            position: relative;
            margin: 20px 0;
        }

        .social-divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #E2E8F0;
            z-index: 1;
        }

        .social-divider span {
            position: relative;
            background: #FFFFFF;
            padding: 0 10px;
            font-size: 0.72rem;
            color: #94A3B8;
            z-index: 2;
        }

        .social-btn-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .btn-social {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border: 1px solid #CBD5E1;
            padding: 9px;
            border-radius: 8px;
            background: white;
            font-size: 0.78rem;
            font-weight: 700;
            color: #334155;
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

            <!-- FORM LOGIN -->
            <div>
                <h2 class="auth-section-title">Login</h2>
                <p class="auth-section-sub">Masuk untuk melanjutkan ke akun Anda</p>

                <form action="{{ route('login.post') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Email atau No. Telepon</label>
                        <div class="input-group-custom">
                            <i class="fa-regular fa-user icon-left"></i>
                            <input type="text" name="login_id" class="form-control-custom"
                                placeholder="Masukkan email atau nomor telepon" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <div class="input-group-custom">
                            <i class="fa-solid fa-lock icon-left"></i>
                            <input type="password" id="login-password" name="password" class="form-control-custom"
                                placeholder="Masukkan password" required>
                            <i class="fa-regular fa-eye icon-right" onclick="togglePassword('login-password', this)"></i>
                        </div>
                    </div>

                    <div class="form-flex">
                        <label class="checkbox-custom">
                            <input type="checkbox" name="remember" checked>
                            <span>Ingat saya</span>
                        </label>
                        <a href="#" class="forgot-link">Lupa password?</a>
                    </div>

                    <button type="submit" class="btn-auth-primary">Masuk</button>

                    <div class="social-divider">
                        <span>atau masuk dengan</span>
                    </div>

                    <div class="social-btn-grid">

                    </div>

                    <div style="text-align: center; margin-top: 24px; font-size: 0.78rem; color: #64748B;">
                        Belum punya akun? <a href="{{ route('register') }}" class="forgot-link">Daftar sekarang</a>
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
