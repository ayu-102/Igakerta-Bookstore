@extends('layouts.app')

@section('title', 'Checkout - IGAKERTA Book Store')

@push('styles')
    <style>
        .checkout-page-container {
            padding: 25px 6%;
            background-color: #F8FAFC;
        }

        .breadcrumb-wrap {
            font-size: 0.8rem;
            color: #64748B;
            margin-bottom: 20px;
        }

        .breadcrumb-wrap a {
            color: #475569;
            text-decoration: none;
        }

        .page-header-title {
            font-size: 1.6rem;
            font-weight: 800;
            color: #1E0A3C;
            margin-bottom: 25px;
        }

        /* STEPPER */
        .stepper-wrap {
            display: flex;
            align-items: center;
            justify-content: center;
            max-width: 700px;
            margin: 0 auto 35px auto;
            position: relative;
        }

        .stepper-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            z-index: 2;
            flex: 1;
        }

        .stepper-circle {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #E2E8F0;
            color: #64748B;
            font-weight: 700;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 6px;
        }

        .stepper-item.active .stepper-circle {
            background: #1E0A3C;
            color: white;
        }

        .stepper-label {
            font-size: 0.75rem;
            font-weight: 700;
            color: #64748B;
        }

        .stepper-item.active .stepper-label {
            color: #1E0A3C;
        }

        .stepper-line {
            position: absolute;
            top: 16px;
            left: 10%;
            right: 10%;
            height: 2px;
            background: #E2E8F0;
            z-index: 1;
        }

        /* MAIN GRID */
        .checkout-grid {
            display: grid;
            grid-template-columns: 1fr 400px;
            gap: 25px;
            align-items: start;
        }

        .checkout-card {
            background: white;
            border: 1px solid #E2E8F0;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
        }

        .card-section-title {
            font-size: 1rem;
            font-weight: 800;
            color: #1E0A3C;
            margin-bottom: 18px;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-label {
            display: block;
            font-size: 0.78rem;
            font-weight: 700;
            color: #334155;
            margin-bottom: 6px;
        }

        .form-input,
        .form-select,
        .form-textarea {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #CBD5E1;
            border-radius: 8px;
            font-size: 0.82rem;
            color: #1E293B;
            outline: none;
            background: #F8FAFC;
        }

        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            border-color: #1E0A3C;
            background: #FFFFFF;
        }

        /* RADIO OPTION CARDS */
        .option-card {
            border: 1px solid #E2E8F0;
            border-radius: 10px;
            padding: 14px 18px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .option-card:hover,
        .option-card.selected {
            border-color: #1E0A3C;
            background: #F8F5FF;
        }

        .option-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .option-title {
            font-size: 0.85rem;
            font-weight: 700;
            color: #1E0A3C;
        }

        .option-desc {
            font-size: 0.72rem;
            color: #64748B;
        }

        .option-price {
            font-size: 0.85rem;
            font-weight: 800;
            color: #1E0A3C;
        }

        /* SUMMARY ITEMS */
        .summary-item-flex {
            display: flex;
            gap: 12px;
            margin-bottom: 14px;
            align-items: center;
        }

        .summary-item-flex img {
            width: 48px;
            height: 64px;
            object-fit: cover;
            border-radius: 6px;
        }

        .summary-item-title {
            font-size: 0.82rem;
            font-weight: 700;
            color: #1E0A3C;
            line-height: 1.2;
        }

        .summary-item-qty {
            font-size: 0.75rem;
            color: #64748B;
        }

        .summary-item-price {
            font-size: 0.82rem;
            font-weight: 800;
            color: #1E0A3C;
            margin-left: auto;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            font-size: 0.8rem;
            color: #475569;
            margin-bottom: 8px;
        }

        .summary-row.total-row {
            border-top: 1px dashed #CBD5E1;
            padding-top: 12px;
            margin-top: 12px;
            font-size: 1.1rem;
            font-weight: 800;
            color: #1E0A3C;
        }

        /* BOTTOM BAR STICKY */
        .checkout-bottom-bar {
            margin-top: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border: 1px solid #CBD5E1;
            border-radius: 8px;
            background: white;
            color: #1E0A3C;
            font-weight: 700;
            font-size: 0.82rem;
            text-decoration: none;
        }

        .btn-submit-order {
            background: #1E0A3C;
            color: white;
            border: none;
            padding: 12px 28px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-submit-order:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        @media (max-width: 992px) {
            .checkout-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@section('content')
    <div class="checkout-page-container">

        <!-- BREADCRUMB -->
        <div class="breadcrumb-wrap">
            <a href="{{ route('home') }}">Beranda</a> &rsaquo;
            <a href="{{ route('cart.index') }}">Keranjang Belanja</a> &rsaquo;
            <span>Checkout</span>
        </div>

        <h1 class="page-header-title">Checkout</h1>

        <!-- STEPPER -->
        <div class="stepper-wrap">
            <div class="stepper-line"></div>
            <div class="stepper-item active">
                <div class="stepper-circle">1</div>
                <div class="stepper-label">Alamat & Pengiriman</div>
            </div>
            <div class="stepper-item">
                <div class="stepper-circle">2</div>
                <div class="stepper-label">Metode Pembayaran</div>
            </div>
            <div class="stepper-item">
                <div class="stepper-circle">3</div>
                <div class="stepper-label">Konfirmasi Pesanan</div>
            </div>
            <div class="stepper-item">
                <div class="stepper-circle">4</div>
                <div class="stepper-label">Selesai</div>
            </div>
        </div>

        <form id="checkoutForm" action="{{ route('checkout.process') }}" method="POST">
            @csrf

            <div class="checkout-grid">

                <!-- KOLOM KIRI: FORM ALAMAT, EXPEDISI & CATATAN -->
                <div>
                    <!-- 1. ALAMAT PENGIRIMAN -->
                    <div class="checkout-card">
                        <div
                            style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                            <h3 class="card-section-title" style="margin: 0;">1. Alamat Pengiriman</h3>
                            @if (Auth::check() && isset($addresses) && $addresses->count() > 1)
                                <button type="button" class="btn-select-address" id="btnToggleAddresses"
                                    style="background: transparent; border: 1px solid #1E0A3C; color: #1E0A3C; padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 700; cursor: pointer;">
                                    <i class="fa-solid fa-location-dot"></i> Pilih Alamat Lain
                                </button>
                            @endif
                        </div>

                        <!-- Pilihan Alamat Jika Punya Banyak Alamat -->
                        @if (Auth::check() && isset($addresses) && $addresses->count() > 1)
                            <div id="addressSelectorBox"
                                style="display: none; background: #F8FAFC; border: 1px solid #CBD5E1; border-radius: 8px; padding: 12px; margin-bottom: 16px;">
                                <label class="form-label" style="margin-bottom: 8px;">Gunakan Alamat Tersimpan:</label>
                                <select id="savedAddressDropdown" class="form-select">
                                    @foreach ($addresses as $addr)
                                        <option value="{{ $addr->id }}" data-name="{{ $addr->recipient_name }}"
                                            data-phone="{{ $addr->phone_number }}"
                                            data-address="{{ $addr->address_detail }}" data-city="{{ $addr->city }}"
                                            data-postal="{{ $addr->postal_code }}"
                                            {{ $defaultAddress && $defaultAddress->id == $addr->id ? 'selected' : '' }}>
                                            [{{ $addr->label }}] {{ $addr->recipient_name }} - {{ $addr->city }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                            <div class="form-group">
                                <label class="form-label">Nama Penerima</label>
                                <input type="text" id="recipient_name" name="recipient_name" class="form-input"
                                    placeholder="Nama Lengkap"
                                    value="{{ old('recipient_name', $defaultAddress->recipient_name ?? (Auth::user()->name ?? '')) }}"
                                    required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">No. Telepon / WA</label>
                                <input type="text" id="phone_number" name="phone_number" class="form-input"
                                    placeholder="08xxxxxxxxxx"
                                    value="{{ old('phone_number', $defaultAddress->phone_number ?? (Auth::user()->phone ?? '')) }}"
                                    required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Alamat Lengkap</label>
                            <textarea id="address_detail" name="address_detail" rows="2" class="form-textarea"
                                placeholder="Jl. Melati No.25, RT/RW..." required>{{ old('address_detail', $defaultAddress->address_detail ?? '') }}</textarea>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 120px; gap: 15px;">
                            <div class="form-group">
                                <label class="form-label">Kota Tujuan / Wilayah</label>
                                <select id="city" name="city" class="form-select" required>
                                    @foreach ($cities as $city)
                                        <option value="{{ $city }}"
                                            {{ old('city', $selectedCity) == $city ? 'selected' : '' }}>
                                            {{ $city }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Kode Pos</label>
                                <input type="text" id="postal_code" name="postal_code" class="form-input"
                                    placeholder="16418"
                                    value="{{ old('postal_code', $defaultAddress->postal_code ?? '') }}" required>
                            </div>
                        </div>
                    </div>

                    <!-- 2. METODE PENGIRIMAN -->
                    <div class="checkout-card">
                        <h3 class="card-section-title">2. Metode Pengiriman</h3>

                        <label class="option-card shipping-card selected">
                            <div class="option-left">
                                <input type="radio" name="shipping_method" value="Reguler (JNE REG)" checked>
                                <div>
                                    <div class="option-title"><i class="fa-solid fa-truck"></i> Reguler (JNE REG)</div>
                                    <div class="option-desc">Estimasi 2-3 hari kerja</div>
                                </div>
                            </div>
                            <div class="option-price">Rp 15.000</div>
                        </label>

                        <label class="option-card shipping-card">
                            <div class="option-left">
                                <input type="radio" name="shipping_method" value="Express (JNE YES)">
                                <div>
                                    <div class="option-title"><i class="fa-solid fa-truck-fast"></i> Express (JNE YES)
                                    </div>
                                    <div class="option-desc">Estimasi 1-2 hari kerja</div>
                                </div>
                            </div>
                            <div class="option-price">Rp 25.000</div>
                        </label>
                    </div>

                    <!-- CATATAN UNTUK PENJUAL -->
                    <div class="checkout-card">
                        <h3 class="card-section-title">Catatan untuk Penjual (Opsional)</h3>
                        <textarea name="notes" class="form-textarea" rows="2"
                            placeholder="Contoh: Tolong dikemas dengan aman, dll."></textarea>
                    </div>
                </div>

                <!-- KOLOM KANAN: RINGKASAN PESANAN & PEMBAYARAN -->
                <div>

                    <!-- KOTAK POIN MEMBER -->
                    @if (Auth::check() && isset($userPoints) && $userPoints > 0)
                        <div class="checkout-card" style="background: #F0FDF4; border-color: #BBF7D0;">
                            <div style="display: flex; align-items: center; justify-content: space-between;">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <i class="fa-solid fa-coins" style="font-size: 1.2rem; color: #16A34A;"></i>
                                    <div>
                                        <div style="font-size: 0.85rem; font-weight: 800; color: #166534;">
                                            Gunakan {{ number_format($userPoints) }} Poin Saya
                                        </div>
                                        <div style="font-size: 0.73rem; color: #15803D;">
                                            Setara potongan Rp {{ number_format($userPoints * 500, 0, ',', '.') }}
                                        </div>
                                    </div>
                                </div>
                                <input type="checkbox" id="use_points" name="use_points" value="1"
                                    style="width: 18px; height: 18px; cursor: pointer;">
                            </div>
                        </div>
                    @endif

                    <!-- RINGKASAN PESANAN -->
                    <div class="checkout-card">
                        <div
                            style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                            <h3 class="card-section-title" style="margin: 0;">Ringkasan Pesanan</h3>
                            <span style="font-size: 0.78rem; color: #64748B;">{{ count($cart) }} Produk</span>
                        </div>

                        @foreach ($cart as $item)
                            <div class="summary-item-flex">
                                <img src="{{ $item['cover_image'] ? asset('storage/' . $item['cover_image']) : 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?q=80&w=300' }}"
                                    alt="{{ $item['title'] }}">
                                <div>
                                    <div class="summary-item-title">{{ $item['title'] }}</div>
                                    <div class="summary-item-qty">Qty: {{ $item['quantity'] }}</div>
                                </div>
                                <div class="summary-item-price">
                                    Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                                </div>
                            </div>
                        @endforeach

                        <hr style="border: none; border-top: 1px solid #F1F5F9; margin: 15px 0;">

                        <div class="summary-row">
                            <span>Subtotal ({{ count($cart) }} produk)</span>
                            <strong>Rp {{ number_format($subtotal, 0, ',', '.') }}</strong>
                        </div>
                        <div class="summary-row">
                            <span>Ongkos Kirim</span>
                            <strong id="display-shipping-cost">Rp {{ number_format($shippingCost, 0, ',', '.') }}</strong>
                        </div>
                        <div class="summary-row">
                            <span>Diskon Voucher</span>
                            <strong style="color: #16A34A;" id="display-discount">- Rp
                                {{ number_format($discountAmount, 0, ',', '.') }}</strong>
                        </div>

                        <!-- BARIS POTONGAN POIN -->
                        <div class="summary-row" id="row-points-discount" style="display: none;">
                            <span>Potongan Poin</span>
                            <strong style="color: #16A34A;" id="display-points-discount">- Rp 0</strong>
                        </div>

                        <div class="summary-row total-row">
                            <span>Total Pembayaran</span>
                            <span id="display-grand-total">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                        </div>

                        <!-- ESTIMASI POIN YANG DIDAPAT -->
                        <div
                            style="margin-top: 12px; background: #FEF3C7; color: #92400E; padding: 10px 12px; border-radius: 8px; font-size: 0.75rem; text-align: center; font-weight: 600;">
                            <i class="fa-solid fa-gift"></i> Kamu akan mendapatkan <strong>+{{ floor($subtotal / 10000) }}
                                Poin</strong> setelah transaksi lunas!
                        </div>
                    </div>

                    <!-- METODE PEMBAYARAN -->
                    <div class="checkout-card">
                        <h3 class="card-section-title">3. Metode Pembayaran</h3>

                        <label class="option-card payment-card selected">
                            <div class="option-left">
                                <input type="radio" name="payment_method" value="Midtrans Snap" checked>
                                <div class="option-title"><i class="fa-solid fa-credit-card"></i> Payment Gateway
                                    (Midtrans)</div>
                            </div>
                        </label>
                        <div style="font-size: 0.75rem; color: #64748B; margin-top: 8px;">
                            Bisa bayar via Transfer Bank, Virtual Account, QRIS, GoPay, ShopeePay, dan Kartu Kredit.
                        </div>
                    </div>
                </div>

            </div>

            <!-- BOTTOM ACTIONS -->
            <div class="checkout-bottom-bar">
                <a href="{{ route('cart.index') }}" class="btn-back">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Keranjang
                </a>
                <button type="submit" id="btnSubmit" class="btn-submit-order">
                    <span>Lanjutkan ke Pembayaran</span> <i class="fa-solid fa-arrow-right"></i>
                </button>
            </div>
        </form>

    </div>
@endsection

@push('scripts')
    <!-- SDK MIDTRANS SNAP -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.client_key') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const shippingInputs = document.querySelectorAll('input[name="shipping_method"]');
            const usePointsCheckbox = document.getElementById('use_points');
            const displayShipping = document.getElementById('display-shipping-cost');
            const displayPointsDiscount = document.getElementById('display-points-discount');
            const rowPointsDiscount = document.getElementById('row-points-discount');
            const displayGrandTotal = document.getElementById('display-grand-total');

            const subtotal = {{ $subtotal }};
            const discountAmount = {{ $discountAmount }};
            const userPoints = {{ $userPoints ?? 0 }};

            function formatRupiah(number) {
                return 'Rp ' + number.toLocaleString('id-ID');
            }

            // Fungsi Kalkulasi Total
            function calculateTotals() {
                let shippingCost = 15000;
                const selectedShipping = document.querySelector('input[name="shipping_method"]:checked');
                if (selectedShipping && selectedShipping.value === 'Express (JNE YES)') {
                    shippingCost = 25000;
                }

                let pointsDiscount = 0;
                if (usePointsCheckbox && usePointsCheckbox.checked) {
                    const currentTotalBeforePoints = Math.max(0, subtotal + shippingCost - discountAmount);

                    // 1 Poin = Rp 500
                    const pointsValue = userPoints * 500;
                    pointsDiscount = Math.min(pointsValue, currentTotalBeforePoints);

                    if (rowPointsDiscount) rowPointsDiscount.style.display = 'flex';
                    if (displayPointsDiscount) displayPointsDiscount.innerText = '- Rp ' + pointsDiscount
                        .toLocaleString('id-ID');
                } else {
                    if (rowPointsDiscount) rowPointsDiscount.style.display = 'none';
                }

                const grandTotal = Math.max(0, subtotal + shippingCost - discountAmount - pointsDiscount);

                displayShipping.innerText = formatRupiah(shippingCost);
                displayGrandTotal.innerText = formatRupiah(grandTotal);
            }

            // Toggle & Auto Fill dari Dropdown Alamat Tersimpan
            const btnToggle = document.getElementById('btnToggleAddresses');
            const selectorBox = document.getElementById('addressSelectorBox');
            const dropdown = document.getElementById('savedAddressDropdown');

            if (btnToggle && selectorBox) {
                btnToggle.addEventListener('click', function() {
                    selectorBox.style.display = selectorBox.style.display === 'none' ? 'block' : 'none';
                });
            }

            if (dropdown) {
                dropdown.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];

                    document.getElementById('recipient_name').value = selectedOption.dataset.name;
                    document.getElementById('phone_number').value = selectedOption.dataset.phone;
                    document.getElementById('address_detail').value = selectedOption.dataset.address;
                    document.getElementById('postal_code').value = selectedOption.dataset.postal;

                    const citySelect = document.getElementById('city');
                    if (citySelect) {
                        citySelect.value = selectedOption.dataset.city;
                    }
                });
            }

            // Event listener checkbox poin
            if (usePointsCheckbox) {
                usePointsCheckbox.addEventListener('change', calculateTotals);
            }

            // Event listener ekspedisi pengiriman
            shippingInputs.forEach(input => {
                input.addEventListener('change', function() {
                    calculateTotals();
                    document.querySelectorAll('.shipping-card').forEach(card => card.classList
                        .remove('selected'));
                    this.closest('.option-card').classList.add('selected');
                });
            });

            // Handle Submit Form Checkout via AJAX & Pop-up Midtrans
            const checkoutForm = document.getElementById('checkoutForm');
            const btnSubmit = document.getElementById('btnSubmit');

            checkoutForm.addEventListener('submit', function(e) {
                e.preventDefault();

                btnSubmit.disabled = true;
                btnSubmit.innerHTML = 'Memproses... <i class="fa-solid fa-spinner fa-spin"></i>';

                const formData = new FormData(checkoutForm);

                fetch("{{ route('checkout.process') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "Accept": "application/json"
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        btnSubmit.disabled = false;
                        btnSubmit.innerHTML =
                            'Lanjutkan ke Pembayaran <i class="fa-solid fa-arrow-right"></i>';

                        if (data.status === 'success') {
                            // Triggers Midtrans Snap Popup
                            snap.pay(data.snap_token, {
                                onSuccess: function(result) {
                                    window.location.href = "{{ route('home') }}";
                                },
                                onPending: function(result) {
                                    window.location.href = "{{ route('home') }}";
                                },
                                onError: function(result) {
                                    alert("Pembayaran gagal! Silakan coba lagi.");
                                },
                                onClose: function() {
                                    alert(
                                        "Pop-up pembayaran ditutup sebelum transaksi selesai."
                                    );
                                    window.location.href = "{{ route('home') }}";
                                }
                            });
                        } else {
                            alert(data.message || 'Terjadi kesalahan saat memproses checkout.');
                        }
                    })
                    .catch(error => {
                        btnSubmit.disabled = false;
                        btnSubmit.innerHTML =
                            'Lanjutkan ke Pembayaran <i class="fa-solid fa-arrow-right"></i>';
                        console.error('Error:', error);
                        alert('Terjadi kesalahan pada server. Silakan coba lagi.');
                    });
            });
        });
    </script>
@endpush
