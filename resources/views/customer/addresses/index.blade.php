@extends('layouts.app')

@section('title', 'Alamat Pengiriman - IGAKERTA Book Store')

@push('styles')
    <style>
        body,
        html {
            background-color: #F8FAFC;
            margin: 0;
            padding: 0;
            width: 100%;
            overflow-x: hidden;
        }

        .dashboard-container {
            width: 100%;
            max-width: 100%;
            margin: 24px 0 40px 0;
            padding: 0 32px;
            box-sizing: border-box;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: 260px 1fr;
            gap: 28px;
            align-items: start;
            width: 100%;
        }

        @media (max-width: 992px) {
            .dashboard-container {
                padding: 0 16px;
            }

            .dashboard-grid {
                grid-template-columns: 1fr;
            }
        }

        /* SIDEBAR CARD */
        .sidebar-card {
            background: #FFFFFF;
            border-radius: 12px;
            padding: 16px;
            border: 1px solid #E2E8F0;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-menu li {
            margin-bottom: 4px;
        }

        .sidebar-menu a,
        .sidebar-menu button {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 0.82rem;
            font-weight: 600;
            color: #334155;
            text-decoration: none;
            transition: all 0.2s;
            width: 100%;
            border: none;
            background: transparent;
            text-align: left;
            cursor: pointer;
        }

        .sidebar-menu a:hover {
            background-color: #F1F5F9;
            color: #23085A;
        }

        .sidebar-menu a.active {
            background-color: #23085A;
            color: #FFFFFF;
        }

        .sidebar-menu a i,
        .sidebar-menu button i {
            font-size: 0.9rem;
            width: 18px;
        }

        .sidebar-divider {
            height: 1px;
            background-color: #E2E8F0;
            margin: 12px 0;
        }

        .logout-btn {
            color: #EF4444 !important;
        }

        .logout-btn:hover {
            background-color: #FEF2F2 !important;
        }

        /* CARD MAIN CONTAINER */
        .card-box {
            background: #FFFFFF;
            border-radius: 12px;
            padding: 24px;
            border: 1px solid #E2E8F0;
        }

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 1px solid #F1F5F9;
        }

        .dashboard-title {
            font-size: 1.35rem;
            font-weight: 800;
            color: #0F172A;
            margin: 0;
        }

        .dashboard-welcome {
            font-size: 0.82rem;
            color: #64748B;
            margin-top: 4px;
        }

        .btn-add-address {
            background: #23085A;
            color: #FFFFFF;
            padding: 10px 18px;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 700;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: background 0.2s;
        }

        .btn-add-address:hover {
            background: #1A0644;
        }

        /* ADDRESS CARD LIST */
        .address-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .address-card {
            border: 1px solid #E2E8F0;
            border-radius: 10px;
            padding: 18px;
            background: #FFFFFF;
            position: relative;
            transition: border-color 0.2s;
        }

        .address-card.is-default {
            border: 2px solid #23085A;
            background: #FAF8FF;
        }

        .address-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 8px;
        }

        .address-label {
            font-size: 0.85rem;
            font-weight: 800;
            color: #0F172A;
        }

        .badge-default {
            background: #23085A;
            color: #FFFFFF;
            font-size: 0.68rem;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 12px;
        }

        .address-recipient {
            font-size: 0.88rem;
            font-weight: 700;
            color: #334155;
            margin-bottom: 4px;
        }

        .address-phone {
            font-size: 0.8rem;
            color: #64748B;
            margin-bottom: 8px;
        }

        .address-detail {
            font-size: 0.82rem;
            color: #475569;
            line-height: 1.5;
            margin-bottom: 14px;
        }

        /* TOMBOL AKSI MODERN */
        .address-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 8px;
            border-top: 1px solid #F1F5F9;
            padding-top: 14px;
            margin-top: 12px;
            flex-wrap: wrap;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 14px;
            border-radius: 8px;
            font-size: 0.78rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
            border: 1px solid transparent;
            text-decoration: none;
            line-height: 1;
        }

        .btn-action-edit {
            background: #F8FAFC;
            color: #334155;
            border-color: #CBD5E1;
        }

        .btn-action-edit:hover {
            background: #23085A;
            color: #FFFFFF;
            border-color: #23085A;
        }

        .btn-action-primary {
            background: #F1EAFF;
            color: #23085A;
            border-color: #E2D5F8;
        }

        .btn-action-primary:hover {
            background: #23085A;
            color: #FFFFFF;
            border-color: #23085A;
        }

        .btn-action-delete {
            background: #FEF2F2;
            color: #EF4444;
            border-color: #FCA5A5;
        }

        .btn-action-delete:hover {
            background: #EF4444;
            color: #FFFFFF;
            border-color: #EF4444;
        }

        /* MODAL STYLES */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.5);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            padding: 16px;
            box-sizing: border-box;
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal-card {
            background: #FFFFFF;
            border-radius: 12px;
            width: 100%;
            max-width: 520px;
            padding: 24px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 1px solid #F1F5F9;
        }

        .modal-title {
            font-size: 1.1rem;
            font-weight: 800;
            color: #0F172A;
            margin: 0;
        }

        .btn-close-modal {
            background: transparent;
            border: none;
            font-size: 1.2rem;
            color: #94A3B8;
            cursor: pointer;
        }

        .form-group {
            margin-bottom: 14px;
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
            padding: 10px 12px;
            border: 1px solid #CBD5E1;
            border-radius: 8px;
            font-size: 0.82rem;
            color: #1E293B;
            outline: none;
            box-sizing: border-box;
        }

        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            border-color: #23085A;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
            padding-top: 14px;
            border-top: 1px solid #F1F5F9;
        }

        .btn-cancel {
            background: #F1F5F9;
            color: #475569;
            border: none;
            padding: 9px 16px;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 700;
            cursor: pointer;
        }

        .btn-save {
            background: #23085A;
            color: #FFFFFF;
            border: none;
            padding: 9px 18px;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 700;
            cursor: pointer;
        }

        /* EMPTY STATE */
        .empty-state {
            text-align: center;
            padding: 40px 20px;
        }

        .empty-state i {
            font-size: 3rem;
            color: #CBD5E1;
            margin-bottom: 12px;
        }

        .empty-state h3 {
            font-size: 1rem;
            font-weight: 700;
            color: #0F172A;
            margin-bottom: 4px;
        }

        .empty-state p {
            font-size: 0.8rem;
            color: #64748B;
        }
    </style>
@endpush

@section('content')
    <div class="dashboard-container">
        <div class="dashboard-grid">

            <!-- SIDEBAR NAVIGASI INTEGRATED -->
            <aside class="sidebar-card">
                <ul class="sidebar-menu">
                    <li>
                        <a href="{{ route('customer.dashboard') }}"
                            class="{{ request()->routeIs('customer.dashboard') ? 'active' : '' }}">
                            <i class="fa-solid fa-square-poll-vertical"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('customer.member.index') }}"
                            class="{{ request()->routeIs('customer.member.*') ? 'active' : '' }}">
                            <i class="fa-solid fa-id-card"></i>
                            <span>Member & Poin</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('customer.orders.index') }}"
                            class="{{ request()->routeIs('customer.orders.*') ? 'active' : '' }}">
                            <i class="fa-regular fa-clipboard"></i>
                            <span>Pesanan Saya</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('customer.ebooks') }}"
                            class="{{ request()->routeIs('customer.ebooks') ? 'active' : '' }}">
                            <i class="fa-solid fa-book-bookmark"></i>
                            <span>Ebook Saya</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('customer.addresses.index') }}"
                            class="{{ request()->routeIs('customer.addresses.*') ? 'active' : '' }}">
                            <i class="fa-solid fa-location-dot"></i>
                            <span>Alamat Pengiriman</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('customer.vouchers') }}"
                            class="{{ request()->routeIs('customer.vouchers') ? 'active' : '' }}">
                            <i class="fa-solid fa-ticket"></i>
                            <span>Voucher Saya</span>
                        </a>
                    </li>

                    <div class="sidebar-divider"></div>

                    <li>
                        <a href="{{ route('customer.profile.edit') }}"
                            class="{{ request()->routeIs('customer.profile.*') ? 'active' : '' }}">
                            <i class="fa-regular fa-user"></i>
                            <span>Akun Saya</span>
                        </a>
                    </li>

                    <div class="sidebar-divider"></div>

                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="logout-btn">
                                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                <span>Keluar</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </aside>

            <!-- KONTEN UTAMA ALAMAT PENGIRIMAN -->
            <main class="card-box">
                <div class="dashboard-header">
                    <div>
                        <h1 class="dashboard-title">Alamat Pengiriman</h1>
                        <p class="dashboard-welcome">Atur alamat tujuan pengiriman pesanan buku fisik Anda.</p>
                    </div>
                    <button type="button" class="btn-add-address" onclick="openAddModal()">
                        <i class="fa-solid fa-plus"></i> Tambah Alamat
                    </button>
                </div>

                @if (session('success'))
                    <div
                        style="background: #F0FDF4; border: 1px solid #DCFCE7; color: #16A34A; padding: 12px 16px; border-radius: 8px; font-size: 0.8rem; margin-bottom: 20px; font-weight: 600;">
                        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                    </div>
                @endif

                @if (isset($addresses) && $addresses->count() > 0)
                    <div class="address-list">
                        @foreach ($addresses as $address)
                            <div class="address-card {{ $address->is_default ? 'is-default' : '' }}">
                                <div class="address-header">
                                    <span class="address-label">{{ $address->label }}</span>
                                    @if ($address->is_default)
                                        <span class="badge-default">Utama</span>
                                    @endif
                                </div>

                                <div class="address-recipient">{{ $address->recipient_name }}</div>
                                <div class="address-phone"><i class="fa-solid fa-phone" style="font-size: 0.72rem;"></i>
                                    {{ $address->phone_number }}</div>
                                <div class="address-detail">
                                    {{ $address->address_detail }}, {{ $address->city }}, {{ $address->province ?? '' }}
                                    {{ $address->postal_code }}
                                </div>

                                <div class="address-actions">
                                    <button type="button" class="btn-action btn-action-edit"
                                        onclick="openEditModal({{ json_encode($address) }})">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                        <span>Edit Alamat</span>
                                    </button>

                                    @if (!$address->is_default)
                                        <form action="{{ route('customer.addresses.set-default', $address->id) }}"
                                            method="POST" style="display:inline;">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn-action btn-action-primary">
                                                <i class="fa-regular fa-circle-check"></i>
                                                <span>Jadikan Utama</span>
                                            </button>
                                        </form>

                                        <form action="{{ route('customer.addresses.destroy', $address->id) }}"
                                            method="POST" style="display:inline;"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus alamat ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action btn-action-delete">
                                                <i class="fa-regular fa-trash-can"></i>
                                                <span>Hapus</span>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fa-solid fa-map-location-dot"></i>
                        <h3>Belum Ada Alamat Tersimpan</h3>
                        <p>Tambahkan alamat pengiriman agar memudahkan Anda saat checkout pesanan buku.</p>
                    </div>
                @endif
            </main>

        </div>
    </div>

    <!-- MODAL FORM TAMBAH / EDIT ALAMAT -->
    <div class="modal-overlay" id="addressModal">
        <div class="modal-card">
            <div class="modal-header">
                <h3 class="modal-title" id="modalTitle">Tambah Alamat Baru</h3>
                <button type="button" class="btn-close-modal" onclick="closeAddressModal()">&times;</button>
            </div>

            <form id="addressForm" action="{{ route('customer.addresses.store') }}" method="POST">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">

                <div class="form-group">
                    <label class="form-label">Label Alamat</label>
                    <input type="text" name="label" id="inputLabel" class="form-input"
                        placeholder="Contoh: Rumah, Kantor, Kos" required>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                    <div class="form-group">
                        <label class="form-label">Nama Penerima</label>
                        <input type="text" name="recipient_name" id="inputRecipient" class="form-input"
                            placeholder="Nama Lengkap" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">No. Telepon / WA</label>
                        <input type="text" name="phone_number" id="inputPhone" class="form-input"
                            placeholder="08xxxxxxxxxx" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Alamat Lengkap</label>
                    <textarea name="address_detail" id="inputAddressDetail" rows="2" class="form-textarea"
                        placeholder="Nama Jalan, No. Rumah, RT/RW, Kecamatan, Kelurahan" required></textarea>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 120px; gap: 12px;">
                    <div class="form-group">
                        <label class="form-label">Kota / Wilayah</label>
                        <select name="city" id="inputCity" class="form-select" required>
                            <option value="Kota Depok, Jawa Barat">Kota Depok, Jawa Barat</option>
                            <option value="Jakarta Selatan, DKI Jakarta">Jakarta Selatan, DKI Jakarta</option>
                            <option value="Bandung, Jawa Barat">Bandung, Jawa Barat</option>
                            <option value="Tangerang, Banten">Tangerang, Banten</option>
                            <option value="Surabaya, Jawa Timur">Surabaya, Jawa Timur</option>
                            <option value="Yogyakarta, DI Yogyakarta">Yogyakarta, DI Yogyakarta</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Kode Pos</label>
                        <input type="text" name="postal_code" id="inputPostalCode" class="form-input"
                            placeholder="16418" required>
                    </div>
                </div>

                <div class="form-group" style="margin-top: 10px;">
                    <label style="display: flex; align-items: center; gap: 8px; font-size: 0.8rem; cursor: pointer;">
                        <input type="checkbox" name="is_default" id="inputIsDefault" value="1">
                        <span>Jadikan sebagai alamat utama</span>
                    </label>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-cancel" onclick="closeAddressModal()">Batal</button>
                    <button type="submit" class="btn-save">Simpan Alamat</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const modal = document.getElementById('addressModal');
        const form = document.getElementById('addressForm');
        const modalTitle = document.getElementById('modalTitle');
        const formMethod = document.getElementById('formMethod');

        function openAddModal() {
            modalTitle.innerText = 'Tambah Alamat Baru';
            form.action = "{{ route('customer.addresses.store') }}";
            formMethod.value = 'POST';

            // Reset form
            document.getElementById('inputLabel').value = '';
            document.getElementById('inputRecipient').value = '';
            document.getElementById('inputPhone').value = '';
            document.getElementById('inputAddressDetail').value = '';
            document.getElementById('inputCity').selectedIndex = 0;
            document.getElementById('inputPostalCode').value = '';
            document.getElementById('inputIsDefault').checked = false;

            modal.classList.add('active');
        }

        function openEditModal(address) {
            modalTitle.innerText = 'Edit Alamat';
            form.action = "/customer/addresses/" + address.id;
            formMethod.value = 'PUT';

            // Fill form data
            document.getElementById('inputLabel').value = address.label;
            document.getElementById('inputRecipient').value = address.recipient_name;
            document.getElementById('inputPhone').value = address.phone_number;
            document.getElementById('inputAddressDetail').value = address.address_detail;
            document.getElementById('inputCity').value = address.city;
            document.getElementById('inputPostalCode').value = address.postal_code;
            document.getElementById('inputIsDefault').checked = address.is_default == 1;

            modal.classList.add('active');
        }

        function closeAddressModal() {
            modal.classList.remove('active');
        }
    </script>
@endpush
