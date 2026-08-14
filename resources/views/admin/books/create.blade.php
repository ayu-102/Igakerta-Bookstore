@extends('admin.app')

@section('content')
    <style>
        /* MAIN CONTAINER & GRID */
        .form-container {
            max-width: 1080px;
            margin: 0 auto 40px auto;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }

        /* HEADER PAGE */
        .page-header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .header-title-group h1 {
            font-size: 1.5rem;
            font-weight: 800;
            color: #0F172A;
            letter-spacing: -0.025em;
            margin-bottom: 4px;
        }

        .header-title-group p {
            font-size: 0.875rem;
            color: #64748B;
            margin: 0;
        }

        .btn-back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #475569;
            font-size: 0.875rem;
            font-weight: 600;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 8px;
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            transition: all 0.2s ease;
        }

        .btn-back-link:hover {
            background: #F8FAFC;
            color: #0F172A;
            border-color: #CBD5E1;
        }

        /* CARD DESIGN */
        .card-modern {
            background: #FFFFFF;
            border-radius: 16px;
            border: 1px solid #E2E8F0;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
            padding: 28px;
            margin-bottom: 24px;
        }

        .card-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #0F172A;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 1px solid #F1F5F9;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-title i {
            color: #4F46E5;
        }

        /* FORM GRID & INPUTS */
        .grid-2 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .grid-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .form-group-modern {
            margin-bottom: 18px;
        }

        .form-label-modern {
            display: block;
            font-size: 0.825rem;
            font-weight: 600;
            color: #334155;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .form-label-modern span {
            color: #EF4444;
        }

        .input-modern,
        .select-modern,
        .textarea-modern {
            width: 100%;
            padding: 10px 14px;
            border-radius: 8px;
            border: 1px solid #CBD5E1;
            background-color: #FFFFFF;
            font-size: 0.9rem;
            color: #0F172A;
            outline: none;
            transition: all 0.2s ease;
            box-sizing: border-box;
        }

        .input-modern:focus,
        .select-modern:focus,
        .textarea-modern:focus {
            border-color: #6366F1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
        }

        /* RADIO FORMAT SELECTOR */
        .format-selector-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
            margin-bottom: 20px;
        }

        .format-card-option {
            position: relative;
            border: 2px solid #E2E8F0;
            border-radius: 12px;
            padding: 16px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 14px;
            transition: all 0.2s ease;
        }

        .format-card-option:hover {
            border-color: #A5B4FC;
            background-color: #F8FAFC;
        }

        .format-card-option.active {
            border-color: #4F46E5;
            background-color: #EEF2FF;
        }

        .format-card-option input[type="radio"] {
            position: absolute;
            opacity: 0;
        }

        .format-icon {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            background: #F1F5F9;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            color: #475569;
        }

        .format-card-option.active .format-icon {
            background: #4F46E5;
            color: #FFFFFF;
        }

        .format-info-title {
            font-weight: 700;
            font-size: 0.95rem;
            color: #0F172A;
        }

        .format-info-sub {
            font-size: 0.78rem;
            color: #64748B;
        }

        /* TOGGLE CHECKBOX STYLING FOR FEATURED */
        .checkbox-featured-box {
            display: flex;
            align-items: center;
            gap: 12px;
            background: #F8FAFC;
            border: 1px solid #E2E8F0;
            padding: 14px 16px;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .checkbox-featured-box:hover {
            background: #F1F5F9;
        }

        .checkbox-featured-box input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: #4F46E5;
            cursor: pointer;
        }

        /* UPLOAD BOX STYLING */
        .upload-zone {
            border: 2px dashed #CBD5E1;
            border-radius: 12px;
            padding: 24px;
            text-align: center;
            background: #F8FAFC;
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
        }

        .upload-zone:hover {
            border-color: #6366F1;
            background: #EEF2FF;
        }

        .upload-zone input[type="file"] {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            opacity: 0;
            cursor: pointer;
        }

        .upload-zone i {
            font-size: 2rem;
            color: #6366F1;
            margin-bottom: 8px;
        }

        .upload-text-main {
            font-size: 0.875rem;
            font-weight: 600;
            color: #334155;
        }

        .upload-text-sub {
            font-size: 0.75rem;
            color: #94A3B8;
            margin-top: 4px;
        }

        /* BUTTON ACTION BAR */
        .action-bar-footer {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 12px;
            padding-top: 12px;
        }

        .btn-secondary-modern {
            padding: 10px 20px;
            border-radius: 8px;
            background: #FFFFFF;
            border: 1px solid #CBD5E1;
            color: #475569;
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .btn-secondary-modern:hover {
            background: #F1F5F9;
            color: #0F172A;
        }

        .btn-primary-modern {
            padding: 10px 24px;
            border-radius: 8px;
            background: #4F46E5;
            border: none;
            color: #FFFFFF;
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(79, 70, 229, 0.2);
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary-modern:hover {
            background: #4338CA;
            box-shadow: 0 4px 6px rgba(79, 70, 229, 0.3);
        }
    </style>

    <div class="form-container">
        <!-- BLOK ALERT ERROR VALIDASI -->
        @if ($errors->any())
            <div
                style="background: #FEE2E2; border: 1px solid #FCA5A5; color: #991B1B; padding: 14px 18px; border-radius: 12px; margin-bottom: 20px;">
                <strong style="display: block; margin-bottom: 6px;"><i class="fa-solid fa-triangle-exclamation"></i> Terjadi
                    kesalahan input:</strong>
                <ul style="margin: 0; padding-left: 20px; font-size: 0.875rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- PAGE HEADER -->
        <div class="page-header-container">
            <div class="header-title-group">
                <h1>Tambah Produk Buku Baru</h1>
                <p>Isi rincian informasi dan spesifikasi katalog buku di bawah ini.</p>
            </div>
            <a href="{{ route('admin.books.index') }}" class="btn-back-link">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>

        <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- CARD 1: FORMAT & INFORMASI UTAMA -->
            <div class="card-modern">
                <div class="card-title">
                    <i class="fa-solid fa-book-bookmark"></i> Format & Informasi Utama
                </div>

                <!-- Custom Radio Option Format Produk -->
                <div class="form-group-modern">
                    <label class="form-label-modern">Format Produk <span>*</span></label>
                    <div class="format-selector-grid">
                        <label class="format-card-option active" id="optionPhysical">
                            <input type="radio" name="type" value="physical" checked
                                onchange="toggleFormat('physical')">
                            <div class="format-icon"><i class="fa-solid fa-book"></i></div>
                            <div>
                                <div class="format-info-title">Buku Fisik (Cetak)</div>
                                <div class="format-info-sub">Memiliki stok fisik dan membutuhkan pengiriman</div>
                            </div>
                        </label>

                        <label class="format-card-option" id="optionEbook">
                            <input type="radio" name="type" value="ebook" onchange="toggleFormat('ebook')">
                            <div class="format-icon"><i class="fa-solid fa-file-pdf"></i></div>
                            <div>
                                <div class="format-info-title">E-Book (Digital)</div>
                                <div class="format-info-sub">File digital dalam bentuk PDF/EPUB tanpa stok</div>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="form-group-modern">
                    <label class="form-label-modern">Judul Buku <span>*</span></label>
                    <input type="text" name="title" class="input-modern" value="{{ old('title') }}"
                        placeholder="Masukkan judul buku lengkap" required>
                </div>

                <div class="grid-2">
                    <div class="form-group-modern">
                        <label class="form-label-modern">Kategori <span>*</span></label>
                        <select name="category_id" class="select-modern" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group-modern">
                        <label class="form-label-modern">Penulis <span>*</span></label>
                        <select name="author_id" class="select-modern" required>
                            <option value="">-- Pilih Penulis --</option>
                            @foreach ($authors as $author)
                                <option value="{{ $author->id }}" {{ old('author_id') == $author->id ? 'selected' : '' }}>
                                    {{ $author->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid-2">
                    <div class="form-group-modern">
                        <label class="form-label-modern">Harga (Rp) <span>*</span></label>
                        <input type="number" name="price" class="input-modern" value="{{ old('price') }}"
                            placeholder="Contoh: 108000" required>
                    </div>
                    <div class="form-group-modern" id="stockGroup">
                        <label class="form-label-modern">Jumlah Stok <span>*</span></label>
                        <input type="number" name="stock" class="input-modern" placeholder="Contoh: 10"
                            value="{{ old('stock', 10) }}">
                    </div>
                </div>

                <!-- OPSI BUKU FAVORIT / REKOMENDASI -->
                <div class="form-group-modern">
                    <label class="form-label-modern">Status Favorit / Rekomendasi</label>
                    <label class="checkbox-featured-box">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                        <div>
                            <div style="font-size: 0.875rem; font-weight: 700; color: #0F172A;">
                                <i class="fa-solid fa-star" style="color: #F59E0B; margin-right: 4px;"></i> Tandai Sebagai
                                Buku Rekomendasi / Favorit
                            </div>
                            <div style="font-size: 0.78rem; color: #64748B;">
                                Buku ini akan disorot di halaman depan dan bagian rekomendasi utama.
                            </div>
                        </div>
                    </label>
                </div>
            </div>

            <!-- CARD 2: SPESIFIKASI BUKU -->
            <div class="card-modern">
                <div class="card-title">
                    <i class="fa-solid fa-list-check"></i> Spesifikasi Detail Buku
                </div>

                <div class="grid-2">
                    <div class="form-group-modern">
                        <label class="form-label-modern">ISBN</label>
                        <input type="text" name="isbn" class="input-modern" value="{{ old('isbn') }}"
                            placeholder="978-623-XXXX-XX-X">
                    </div>
                    <div class="form-group-modern">
                        <label class="form-label-modern">Penerbit</label>
                        <select name="publisher_id" class="select-modern">
                            <option value="">-- Pilih Penerbit --</option>
                            @foreach ($publishers as $publisher)
                                <option value="{{ $publisher->id }}"
                                    {{ old('publisher_id') == $publisher->id ? 'selected' : '' }}>
                                    {{ $publisher->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid-2">
                    <div class="form-group-modern">
                        <label class="form-label-modern">Tahun Terbit</label>
                        <input type="number" name="publication_year" class="input-modern"
                            value="{{ old('publication_year') }}" placeholder="Contoh: 2024">
                    </div>
                    <div class="form-group-modern">
                        <label class="form-label-modern">Jumlah Halaman</label>
                        <input type="number" name="pages" class="input-modern" value="{{ old('pages') }}"
                            placeholder="Contoh: 256">
                    </div>
                </div>

                <div class="grid-2">
                    <div class="form-group-modern">
                        <label class="form-label-modern">Ukuran Buku</label>
                        <input type="text" name="dimensions" class="input-modern" value="{{ old('dimensions') }}"
                            placeholder="Contoh: 15.5 x 23 cm">
                    </div>
                    <div class="form-group-modern">
                        <label class="form-label-modern">Berat Buku</label>
                        <input type="text" name="weight" class="input-modern" value="{{ old('weight') }}"
                            placeholder="Contoh: 350 gram">
                    </div>
                </div>

                <div class="grid-2">
                    <div class="form-group-modern">
                        <label class="form-label-modern">Bahasa</label>
                        <input type="text" name="language" class="input-modern"
                            value="{{ old('language', 'Indonesia') }}">
                    </div>
                    <div class="form-group-modern">
                        <label class="form-label-modern">Jenis Cover Jilid</label>
                        <select name="cover_type" class="select-modern">
                            <option value="Soft Cover" {{ old('cover_type') == 'Soft Cover' ? 'selected' : '' }}>Soft
                                Cover</option>
                            <option value="Hard Cover" {{ old('cover_type') == 'Hard Cover' ? 'selected' : '' }}>Hard
                                Cover</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- CARD 3: MEDIA & DESKRIPSI -->
            <div class="card-modern">
                <div class="card-title">
                    <i class="fa-solid fa-file-arrow-up"></i> Media & Deskripsi
                </div>

                <div class="grid-2">
                    <!-- Cover Image Upload Box -->
                    <div class="form-group-modern">
                        <label class="form-label-modern">Foto Sampul (Cover Image)</label>
                        <div class="upload-zone">
                            <i class="fa-solid fa-cloud-arrow-up"></i>
                            <div class="upload-text-main">Pilih file foto atau drag & drop</div>
                            <div class="upload-text-sub">PNG, JPG, WEBP hingga 2MB</div>
                            <input type="file" name="cover_image" accept="image/*"
                                onchange="updateFileName(this, 'coverFileName')">
                        </div>
                        <small id="coverFileName"
                            style="color:#6366F1; font-weight:600; display:block; margin-top:6px;"></small>
                    </div>

                    <!-- Ebook Upload Box (Digital Only) -->
                    <div class="form-group-modern" id="ebookFileGroup" style="display: none;">
                        <label class="form-label-modern">File Digital E-Book (PDF)</label>
                        <div class="upload-zone">
                            <i class="fa-solid fa-file-pdf" style="color: #EF4444;"></i>
                            <div class="upload-text-main">Pilih file E-Book PDF</div>
                            <div class="upload-text-sub">Format PDF/EPUB Maksimal 20MB</div>
                            <input type="file" name="file_pdf" accept=".pdf,.epub"
                                onchange="updateFileName(this, 'pdfFileName')">
                        </div>
                        <small id="pdfFileName"
                            style="color:#EF4444; font-weight:600; display:block; margin-top:6px;"></small>
                    </div>
                </div>

                <div class="form-group-modern">
                    <label class="form-label-modern">Deskripsi Lengkap Buku</label>
                    <textarea name="description" rows="5" class="textarea-modern"
                        placeholder="Tuliskan sinopsis atau deskripsi buku di sini...">{{ old('description') }}</textarea>
                </div>
            </div>

            <!-- FOOTER ACTIONS -->
            <div class="action-bar-footer">
                <a href="{{ route('admin.books.index') }}" class="btn-secondary-modern">Batal</a>
                <button type="submit" class="btn-primary-modern">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Buku
                </button>
            </div>
        </form>
    </div>

    <!-- SCRIPT UNTUK INTERAKSI -->
    <script>
        function toggleFormat(type) {
            const optionPhysical = document.getElementById('optionPhysical');
            const optionEbook = document.getElementById('optionEbook');
            const stockGroup = document.getElementById('stockGroup');
            const ebookFileGroup = document.getElementById('ebookFileGroup');

            if (type === 'ebook') {
                optionEbook.classList.add('active');
                optionPhysical.classList.remove('active');
                stockGroup.style.display = 'none';
                ebookFileGroup.style.display = 'block';
            } else {
                optionPhysical.classList.add('active');
                optionEbook.classList.remove('active');
                stockGroup.style.display = 'block';
                ebookFileGroup.style.display = 'none';
            }
        }

        function updateFileName(input, targetId) {
            const target = document.getElementById(targetId);
            if (input.files && input.files[0]) {
                target.innerText = "File terpilih: " + input.files[0].name;
            } else {
                target.innerText = "";
            }
        }
    </script>
@endsection
