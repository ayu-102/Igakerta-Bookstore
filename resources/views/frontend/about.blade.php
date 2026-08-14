@extends('layouts.app')

@section('title', 'Tentang Kami - IGAKERTA Book Store')

@push('styles')
    <style>
        /* HERO / HEADER BANNER (STYLE SESUAI KATALOG EBOOK) */
        .about-header {
            background: linear-gradient(90deg, #18003C 0%, #290858 55%, rgba(41, 8, 88, 0.45) 100%),
                url('https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?q=80&w=1200&auto=format&fit=crop') center / cover no-repeat;
            border-radius: 16px;
            color: white;
            padding: 35px 45px;
            margin: 1.5% 6% 30px 6%;
            width: auto;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-height: 160px;
            box-sizing: border-box;
            border-bottom: 4px solid #FFC000;
        }

        .about-header-content {
            max-width: 650px;
            position: relative;
            z-index: 2;
        }

        .breadcrumb-item {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 8px;
        }

        .breadcrumb-item a {
            color: #FFC000;
            text-decoration: none;
            font-weight: 600;
        }

        .about-header h1 {
            font-size: 1.85rem;
            font-weight: 800;
            margin-bottom: 8px;
            color: #FFFFFF;
            letter-spacing: -0.5px;
            text-transform: uppercase;
        }

        .about-header p {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.85);
            line-height: 1.5;
            margin: 0;
        }

        /* MAIN CONTAINER LAYOUT */
        .about-container {
            width: 100%;
            padding: 0 6% 40px;
            box-sizing: border-box;
        }

        .section-title {
            text-align: center;
            font-size: 1.4rem;
            font-weight: 800;
            color: #1E293B;
            margin-bottom: 25px;
            letter-spacing: -0.3px;
        }

        /* CARD PROFIL TOKO */
        .about-profile-grid {
            display: grid;
            grid-template-columns: 240px 1fr;
            gap: 25px;
            margin-bottom: 40px;
            align-items: stretch;
        }

        .stat-card {
            background: #FFFFFF;
            padding: 35px 20px;
            border-radius: 12px;
            text-align: center;
            border: 1px solid #E2E8F0;
            border-top: 4px solid #23085A;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .stat-card .year {
            font-size: 3.2rem;
            font-weight: 800;
            color: #23085A;
            line-height: 1;
        }

        .stat-card .label {
            font-size: 0.82rem;
            font-weight: 700;
            color: #64748B;
            margin-top: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .about-text-card {
            background: #FFFFFF;
            padding: 30px 35px;
            border-radius: 12px;
            border: 1px solid #E2E8F0;
            border-left: 4px solid #FFC000;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .about-text-card h3 {
            font-size: 1.25rem;
            color: #1E293B;
            margin-bottom: 12px;
            font-weight: 800;
        }

        .about-text-card p {
            font-size: 0.88rem;
            color: #475569;
            line-height: 1.7;
            margin-bottom: 18px;
        }

        .about-text-card .address {
            font-size: 0.82rem;
            color: #23085A;
            font-weight: 600;
            background: #F5EFFF;
            padding: 10px 14px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            width: fit-content;
        }

        /* KEUNGGULAN (3 CARD GRID) */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 40px;
        }

        .feature-card {
            background: #FFFFFF;
            padding: 30px 20px;
            border-radius: 12px;
            text-align: center;
            border: 1px solid #E2E8F0;
            border-top: 4px solid #23085A;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
            transition: transform 0.2s, box-shadow 0.2s, border-top-color 0.2s;
        }

        .feature-card:hover {
            transform: translateY(-4px);
            border-top-color: #FFC000;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.06);
        }

        .feature-icon {
            width: 50px;
            height: 50px;
            background: #F5EFFF;
            color: #23085A;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            margin: 0 auto 16px;
        }

        .feature-card h4 {
            font-size: 1rem;
            color: #1E293B;
            margin-bottom: 8px;
            font-weight: 700;
        }

        .feature-card p {
            font-size: 0.82rem;
            color: #64748B;
            line-height: 1.5;
            margin: 0;
        }

        /* MEDIA SOSIAL GRID */
        .social-section {
            background: #F8FAFC;
            border: 1px solid #E2E8F0;
            border-radius: 14px;
            padding: 30px;
            text-align: center;
        }

        .social-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
        }

        .social-card {
            background: #FFFFFF;
            padding: 18px;
            border-radius: 10px;
            text-align: center;
            border: 1px solid #E2E8F0;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02);
            transition: transform 0.2s, box-shadow 0.2s;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .social-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 16px rgba(35, 8, 90, 0.08);
        }

        .social-card i {
            font-size: 1.8rem;
        }

        .social-card.fb i {
            color: #1877F2;
        }

        .social-card.tw i {
            color: #1DA1F2;
        }

        .social-card.ig i {
            color: #E4405F;
        }

        .social-card.wa i {
            color: #25D366;
        }

        .social-card span {
            font-weight: 700;
            font-size: 0.8rem;
            color: #1E293B;
        }

        @media (max-width: 868px) {
            .about-header {
                padding: 25px 20px;
                margin: 10px 4% 20px;
            }

            .about-container {
                padding: 0 4% 30px;
            }

            .about-profile-grid {
                grid-template-columns: 1fr;
            }

            .features-grid {
                grid-template-columns: 1fr;
            }

            .social-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
@endpush

@section('content')
    <!-- HERO HEADER BANNER (IDENTIK DENGAN KATALOG EBOOK) -->
    <div class="about-header">
        <div class="about-header-content">
            <div class="breadcrumb-item">
                <a href="{{ route('home') }}">Beranda</a> &gt; <span>Tentang Kami</span>
            </div>
            <h1>Tentang Toko Kami</h1>
            <p>Mengenal lebih dekat IGAKERTA Bookstore, penyedia buku berkualitas dan terpercaya.</p>
        </div>
    </div>

    <!-- MAIN CONTENT AREA -->
    <div class="about-container">

        <!-- SECTION 1: PROFIL TOKO -->
        <div class="about-profile-grid">
            <div class="stat-card">
                <div class="year">2017</div>
                <div class="label">Tahun Didirikan</div>
            </div>

            <div class="about-text-card">
                <h3>Selamat Datang di IGAKERTA Bookstore</h3>
                <p>
                    IGAKERTA Bookstore menyediakan berbagai macam kategori buku mulai dari komik, novel fiksi, hingga
                    buku ilmiah dengan harga bersaing dan kualitas terjamin. Melalui platform digital ini, kami hadir untuk
                    mempermudah Anda mengakses rilisan buku terbaru, ketersediaan stok, hingga koleksi Ebook favorit.
                </p>
                <div class="address">
                    <i class="fa-solid fa-location-dot"></i>
                    <span>Jl. Tentara Pelajar no. 111, RT3/03 Desa Widoro, Kec. Pacitan, Kab. Pacitan, Jawa Timur,
                        63551</span>
                </div>
            </div>
        </div>

        <!-- SECTION 2: KEUNGGULAN KAMI -->
        <h2 class="section-title">Mengapa Memilih Kami?</h2>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon"><i class="fa-solid fa-certificate"></i></div>
                <h4>100% Buku Original</h4>
                <p>Semua produk dikirim langsung dari penerbit resmi dengan garansi kualitas cetak terbaik.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fa-solid fa-tags"></i></div>
                <h4>Harga Bersaing</h4>
                <p>Akses harga terjangkau serta penawaran voucher promo menarik untuk setiap pembelian.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fa-solid fa-truck-fast"></i></div>
                <h4>Pengiriman Cepat</h4>
                <p>Proses pengemasan yang aman dan pengiriman terpercaya ke seluruh penjuru Indonesia.</p>
            </div>
        </div>

        <!-- SECTION 3: MEDIA SOSIAL -->
        <div class="social-section">
            <h2 class="section-title" style="margin-bottom: 20px;">Hubungi & Ikuti Media Sosial Kami</h2>
            <div class="social-grid">
                <a href="#" class="social-card fb">
                    <i class="fa-brands fa-facebook"></i>
                    <span>FACEBOOK</span>
                </a>
                <a href="#" class="social-card tw">
                    <i class="fa-brands fa-x-twitter"></i>
                    <span>TWITTER / X</span>
                </a>
                <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" class="social-card ig">
                    <i class="fa-brands fa-instagram"></i>
                    <span>INSTAGRAM</span>
                </a>
                <a href="https://wa.me/6285782763529" target="_blank" rel="noopener noreferrer" class="social-card wa">
                    <i class="fa-brands fa-whatsapp"></i>
                    <span>WHATSAPP</span>
                </a>
            </div>
        </div>

    </div>
@endsection
