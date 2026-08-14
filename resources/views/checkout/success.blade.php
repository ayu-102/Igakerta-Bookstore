@extends('layouts.app')

@section('title', 'Pembayaran Berhasil - IGAKERTA Book Store')

@push('styles')
    <style>
        .success-page-container {
            min-height: 75vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            background-color: #F8FAFC;
        }

        .success-card {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 16px;
            padding: 40px 30px;
            max-width: 520px;
            width: 100%;
            text-align: center;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
        }

        .icon-circle {
            width: 80px;
            height: 80px;
            background: #DCFCE7;
            color: #16A34A;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            margin: 0 auto 24px auto;
        }

        .success-title {
            font-size: 1.5rem;
            font-weight: 800;
            color: #0F172A;
            margin-bottom: 8px;
        }

        .success-desc {
            font-size: 0.88rem;
            color: #64748B;
            margin-bottom: 28px;
            line-height: 1.5;
        }

        .btn-group-action {
            display: flex;
            gap: 12px;
            justify-content: center;
        }

        .btn-primary-custom {
            background: #23085A;
            color: #FFFFFF;
            font-size: 0.85rem;
            font-weight: 700;
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-primary-custom:hover {
            background: #1A0644;
            color: #FFFFFF;
        }

        .btn-secondary-custom {
            background: #F1F5F9;
            color: #475569;
            font-size: 0.85rem;
            font-weight: 700;
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-secondary-custom:hover {
            background: #E2E8F0;
            color: #1E293B;
        }
    </style>
@endpush

@section('content')
    <div class="success-page-container">
        <div class="success-card">
            <div class="icon-circle">
                <i class="fa-solid fa-check"></i>
            </div>
            <h1 class="success-title">Pembayaran Berhasil!</h1>
            <p class="success-desc">
                Terima kasih telah berbelanja di IGAKERTA Book Store. Pesanan Anda telah diterima dan akan segera kami
                proses.
            </p>
            <div class="btn-group-action">
                <a href="{{ route('customer.orders.index') }}" class="btn-primary-custom">
                    <i class="fa-regular fa-clipboard me-1"></i> Lihat Pesanan Saya
                </a>
                <a href="{{ route('home') }}" class="btn-secondary-custom">
                    <i class="fa-solid fa-house me-1"></i> Beranda
                </a>
            </div>
        </div>
    </div>
@endsection
