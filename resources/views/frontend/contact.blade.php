<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontak Kami - Iga Kerta Bookstore</title>

    <!-- Google Fonts & FontAwesome -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary-color: #1E0A3C;
            --secondary-color: #1E0A3C;
            --accent-color: #FFC700;
            --violet-color: #6B21A8;
            --bg-body: #FFFFFF;
            --bg-purple-light: #F3F0F8;
            --text-main: #212529;
            --text-muted: #6C757D;
            --border-color: #E2D9F3;
            --font-main: 'Poppins', sans-serif;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: var(--font-main);
        }

        body {
            background-color: var(--bg-body);
            color: var(--text-main);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        /* NAVBAR */
        .navbar {
            background-color: var(--secondary-color);
            padding: 12px 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 1.3rem;
            font-weight: 800;
            color: #FFFFFF;
        }

        .navbar-brand span {
            color: var(--accent-color);
        }

        .navbar-brand img {
            height: 48px;
            width: auto;
            object-fit: contain;
        }

        .nav-menu {
            display: flex;
            gap: 25px;
            list-style: none;
        }

        .nav-link {
            color: #FFFFFF;
            font-weight: 500;
            font-size: 0.95rem;
            transition: 0.3s;
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--accent-color);
        }

        /* HEADER BANNER - FOTO SUDAH DIGANTI */
        .page-header {
            background: linear-gradient(rgba(30, 10, 60, 0.70), rgba(30, 10, 60, 0.70)),
                url('https://images.unsplash.com/photo-1521587760476-6c12a4b040da?q=80&w=1200') center/cover;
            color: white;
            padding: 50px 5%;
            text-align: center;
            border-bottom: 4px solid var(--accent-color);
        }

        .page-header h1 {
            font-size: 2.2rem;
            font-weight: 800;
        }

        .page-header p {
            color: #DDD;
            font-size: 0.95rem;
            margin-top: 8px;
        }

        /* SECTION WRAPPERS */
        .section-purple {
            background-color: var(--bg-purple-light);
            padding: 60px 5%;
            width: 100%;
        }

        .section-white {
            background-color: #FFFFFF;
            padding: 60px 5%;
            width: 100%;
        }

        .container-inner {
            max-width: 1200px;
            margin: 0 auto;
            width: 100%;
        }

        .section-title {
            text-align: center;
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 30px;
        }

        /* CONTACT GRID & CARDS */
        .contact-info-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 40px;
        }

        .info-card {
            background: #FFFFFF;
            padding: 30px 20px;
            border-radius: 12px;
            border-top: 4px solid var(--violet-color);
            border-left: 1px solid var(--border-color);
            border-right: 1px solid var(--border-color);
            border-bottom: 1px solid var(--border-color);
            box-shadow: 0 4px 15px rgba(107, 33, 168, 0.06);
            transition: 0.3s;
            text-align: center;
        }

        .info-card:hover {
            transform: translateY(-5px);
            border-top-color: var(--accent-color);
        }

        .info-icon {
            width: 50px;
            height: 50px;
            background: var(--bg-purple-light);
            color: var(--violet-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            margin: 0 auto 15px;
        }

        .info-card h4 {
            font-size: 1rem;
            color: var(--primary-color);
            margin-bottom: 10px;
            font-weight: 700;
        }

        .info-card p {
            font-size: 0.88rem;
            color: var(--text-muted);
            line-height: 1.6;
        }

        /* MAP & FORM GRID */
        .map-form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }

        .map-container {
            background: #FFFFFF;
            padding: 15px;
            border-radius: 12px;
            border: 1px solid var(--border-color);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
            height: 100%;
            min-height: 400px;
            display: flex;
            flex-direction: column;
        }

        .map-container iframe {
            width: 100%;
            height: 100%;
            min-height: 370px;
            border: none;
            border-radius: 8px;
        }

        /* FORM STYLING */
        .form-container {
            background: #FFFFFF;
            padding: 30px;
            border-radius: 12px;
            border-top: 4px solid var(--primary-color);
            border-left: 1px solid var(--border-color);
            border-right: 1px solid var(--border-color);
            border-bottom: 1px solid var(--border-color);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
        }

        .form-container h3 {
            font-size: 1.2rem;
            color: var(--primary-color);
            margin-bottom: 20px;
            font-weight: 700;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 6px;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 0.9rem;
            outline: none;
            transition: 0.3s;
            background: var(--bg-purple-light);
        }

        .form-control:focus {
            border-color: var(--violet-color);
            background: #FFFFFF;
            box-shadow: 0 0 0 3px rgba(107, 33, 168, 0.1);
        }

        textarea.form-control {
            resize: vertical;
            height: 110px;
        }

        .btn-send {
            background-color: var(--primary-color);
            color: #FFFFFF;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.9rem;
            cursor: pointer;
            width: 100%;
            transition: 0.3s;
        }

        .btn-send:hover {
            background-color: var(--violet-color);
        }

        /* FOOTER */
        footer {
            background-color: var(--secondary-color);
            color: #FFFFFF;
            padding: 60px 5% 30px;
            margin-top: auto;
            border-top: 4px solid var(--accent-color);
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 35px;
            max-width: 1200px;
            margin: 0 auto 40px;
        }

        .footer-col h4 {
            font-size: 1.05rem;
            font-weight: 700;
            margin-bottom: 20px;
            color: var(--accent-color);
            text-transform: uppercase;
        }

        .footer-col ul {
            list-style: none;
        }

        .footer-col ul li {
            margin-bottom: 12px;
        }

        .footer-col ul li a {
            color: #DDD;
            font-size: 0.9rem;
        }

        .footer-col p {
            color: #DDD;
            font-size: 0.88rem;
            line-height: 1.7;
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 25px;
            text-align: center;
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.6);
        }

        @media (max-width: 900px) {
            .contact-info-grid {
                grid-template-columns: 1fr;
            }

            .map-form-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar">
        <a href="{{ route('home') }}" class="navbar-brand">
            <img src="{{ asset('images/logo.png') }}" alt="Iga Kerta Logo">
            IGAKERTA <span>BOOKSTORE</span>
        </a>
        <ul class="nav-menu">
            <li><a href="{{ route('home') }}" class="nav-link">Beranda</a></li>
            <li><a href="{{ route('home') }}#katalog" class="nav-link">Katalog Buku</a></li>
            <li><a href="{{ route('how-to-order') }}" class="nav-link">Cara Pesan</a></li>
            <li><a href="{{ route('about') }}" class="nav-link">Tentang Kami</a></li>
            <li><a href="{{ route('contact') }}" class="nav-link active">Kontak</a></li>
        </ul>
        <a href="#" style="color: white; font-weight: 600;"><i class="fa-solid fa-cart-shopping"></i> (0)</a>
    </nav>

    <!-- HEADER BANNER -->
    <div class="page-header">
        <h1>HUBUNGI KAMI</h1>
        <p>Kami siap melayani pertanyaan, pemesanan, dan kerja sama Anda</p>
    </div>

    <!-- SECTION 1: KARTU INFORMASI KONTAK -->
    <div class="section-purple">
        <div class="container-inner">
            <div class="contact-info-grid">
                <div class="info-card">
                    <div class="info-icon"><i class="fa-solid fa-location-dot"></i></div>
                    <h4>Alamat Toko</h4>
                    <p>Jl. Tentara Pelajar no. 111, RT3/03 Desa Widoro, Kec. Pacitan, Kab. Pacitan, Jawa Timur 63551</p>
                </div>

                <div class="info-card">
                    <div class="info-icon"><i class="fa-solid fa-phone"></i></div>
                    <h4>Informasi Kontak</h4>
                    <p>
                        <strong>No. HP/WA:</strong> +62 857-8276-3529<br>
                        <strong>Email:</strong> rinoridiojulianto@gmail.com<br>
                        <strong>Telegram:</strong> @ZurinArctus
                    </p>
                </div>

                <div class="info-card">
                    <div class="info-icon"><i class="fa-solid fa-clock"></i></div>
                    <h4>Jam Operasional</h4>
                    <p>
                        <strong>Senin - Jumat:</strong> 09.00 s/d 21.00 WIB<br>
                        <strong>Sabtu:</strong> 09.00 s/d 15.00 WIB<br>
                        <strong>Minggu:</strong> <span style="color: #d9534f; font-weight: 600;">Tutup</span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- SECTION 2: MAPS & FORM KIRIM PESAN -->
    <div class="section-white">
        <div class="container-inner">
            <h2 class="section-title">Lokasi & Pesan Langsung</h2>
            <div class="map-form-grid">

                <!-- Google Maps -->
                <div class="map-container">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3947.88123281031!2d111.096732!3d-8.214643!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7b1e4f3a388907%3A0x280e72bd58cd2e74!2sPacitan%2C%20Kabupaten%20Pacitan%2C%20Jawa%20Timur!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid"
                        allowfullscreen="" loading="lazy">
                    </iframe>
                </div>

                <!-- Form Kirim Pesan -->
                <div class="form-container">
                    <h3>Kirim Pesan ke Admin</h3>
                    <form action="https://wa.me/6285124157382" method="GET" target="_blank">
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" class="form-control" placeholder="Masukkan nama Anda..." required>
                        </div>
                        <div class="form-group">
                            <label>Alamat Email / No. WhatsApp</label>
                            <input type="text" class="form-control" placeholder="Contoh: 08123456789" required>
                        </div>
                        <div class="form-group">
                            <label>Pesan / Pertanyaan</label>
                            <textarea class="form-control" placeholder="Tuliskan pesan Anda di sini..." required></textarea>
                        </div>
                        <button type="submit" class="btn-send">
                            <i class="fa-solid fa-paper-plane" style="margin-right: 6px;"></i> Kirim Pesan
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- FOOTER LENGKAP -->
    <footer>
        <div class="footer-grid">
            <div class="footer-col">
                <h4>Informasi</h4>
                <ul>
                    <li><a href="{{ route('about') }}">Tentang Kami</a></li>
                    <li><a href="{{ route('home') }}#katalog">Katalog Lengkap</a></li>
                    <li><a href="{{ route('how-to-order') }}">Cara Pemesanan</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Bantuan</h4>
                <ul>
                    <li><a href="{{ route('contact') }}">Kontak Kami</a></li>
                    <li><a href="{{ route('how-to-order') }}">F.A.Q</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Tentang Kami</h4>
                <p>IGAKERTA BOOK Catalog menjual berbagai macam kategori buku dari komik hingga novel fiksi dengan harga
                    terjangkau.</p>
            </div>
            <div class="footer-col">
                <h4>Kontak</h4>
                <p>
                    <strong>Alamat:</strong> Pacitan, Jawa Timur<br>
                    <strong>No. HP:</strong> +62 857-8276-3529<br>
                    <strong>Email:</strong> igakertapublisher@gmail.com
                </p>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} Iga Kerta Bookstore. All rights reserved.</p>
        </div>
    </footer>

</body>

</html>
