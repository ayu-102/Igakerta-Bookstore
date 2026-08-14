@extends('admin.app')

@section('title', 'Kelola Member & Poin')

@section('content')
    <div
        style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; padding: 24px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 2px 4px -2px rgba(0, 0, 0, 0.02);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
            <div>
                <h2 style="font-size: 1.15rem; font-weight: 800; color: #0F172A; margin: 0 0 4px 0;">Daftar Member & Saldo
                    Poin</h2>
                <p style="font-size: 0.8rem; color: #64748B; margin: 0;">Kelola perolehan poin dan peringkat member
                    pelanggan.</p>
            </div>

            <form action="{{ route('admin.members.index') }}" method="GET" style="display: flex; gap: 8px;">
                <div style="position: relative;">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..."
                        style="padding: 9px 14px; border: 1px solid #E2E8F0; border-radius: 8px; font-size: 0.83rem; width: 220px; outline: none; background: #F8FAFC; transition: all 0.2s;">
                </div>
                <button type="submit"
                    style="padding: 9px 16px; background: #4F46E5; color: white; border: none; border-radius: 8px; font-weight: 600; font-size: 0.83rem; cursor: pointer; transition: background 0.2s;">
                    <i class="fa-solid fa-magnifying-glass" style="margin-right: 4px;"></i> Cari
                </button>
            </form>
        </div>

        @if (session('success'))
            <div
                style="padding: 12px 16px; background: #ECFDF5; border: 1px solid #A7F3D0; color: #065F46; border-radius: 10px; margin-bottom: 20px; font-size: 0.83rem; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-circle-check"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div style="overflow-x: auto; border-radius: 10px; border: 1px solid #F1F5F9;">
            <table style="width: 100%; border-collapse: collapse; font-size: 0.85rem;">
                <thead>
                    <tr
                        style="background: #F8FAFC; text-align: left; border-bottom: 1px solid #E2E8F0; color: #64748B; font-weight: 700; text-transform: uppercase; font-size: 0.72rem; letter-spacing: 0.5px;">
                        <th style="padding: 14px 16px; width: 50px;">No</th>
                        <th style="padding: 14px 16px;">Member</th>
                        <th style="padding: 14px 16px;">Kontak</th>
                        <th style="padding: 14px 16px;">Tier</th>
                        <th style="padding: 14px 16px;">Saldo Poin</th>
                        <th style="padding: 14px 16px; width: 280px;">Aksi Penyesuaian</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($members as $index => $member)
                        @php
                            $pts = $member->points ?? 0;
                            if ($pts >= 1000) {
                                $tier = 'Platinum';
                                $badgeBg = '#EEF2FF';
                                $badgeColor = '#4338CA';
                                $badgeBorder = '#C7D2FE';
                            } elseif ($pts >= 500) {
                                $tier = 'Gold';
                                $badgeBg = '#FEF3C7';
                                $badgeColor = '#B45309';
                                $badgeBorder = '#FDE68A';
                            } elseif ($pts >= 200) {
                                $tier = 'Silver';
                                $badgeBg = '#F1F5F9';
                                $badgeColor = '#475569';
                                $badgeBorder = '#E2E8F0';
                            } else {
                                $tier = 'Bronze';
                                $badgeBg = '#FFEDD5';
                                $badgeColor = '#C2410C';
                                $badgeBorder = '#FED7AA';
                            }
                        @endphp
                        <tr style="border-bottom: 1px solid #F1F5F9; transition: background 0.15s;"
                            onmouseover="this.style.background='#F8FAFC'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 14px 16px; color: #94A3B8; font-weight: 600;">
                                {{ $members->firstItem() + $index }}</td>
                            <td style="padding: 14px 16px;">
                                <div style="font-weight: 700; color: #0F172A;">{{ $member->name }}</div>
                            </td>
                            <td style="padding: 14px 16px; color: #64748B;">
                                <div>{{ $member->email }}</div>
                                <div style="font-size: 0.75rem; color: #94A3B8; margin-top: 2px;">
                                    <i class="fa-solid fa-phone" style="font-size: 0.7rem;"></i> {{ $member->phone ?? '-' }}
                                </div>
                            </td>
                            <td style="padding: 14px 16px;">
                                <span
                                    style="background: {{ $badgeBg }}; color: {{ $badgeColor }}; border: 1px solid {{ $badgeBorder }}; padding: 3px 10px; border-radius: 20px; font-weight: 700; font-size: 0.72rem; display: inline-flex; align-items: center; gap: 4px;">
                                    <i class="fa-solid fa-award"></i> {{ $tier }}
                                </span>
                            </td>
                            <td style="padding: 14px 16px;">
                                <div
                                    style="font-weight: 800; color: #D97706; font-size: 0.9rem; display: flex; align-items: center; gap: 6px;">
                                    <span
                                        style="background: #FEF3C7; width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                        <i class="fa-solid fa-coins" style="font-size: 0.75rem; color: #D97706;"></i>
                                    </span>
                                    {{ number_format($pts) }} <span
                                        style="font-size: 0.75rem; color: #B45309; font-weight: 600;">Pts</span>
                                </div>
                            </td>
                            <td style="padding: 14px 16px;">
                                <form action="{{ route('admin.members.updatePoints', $member->id) }}" method="POST"
                                    style="display: flex; align-items: center; gap: 6px;">
                                    @csrf
                                    <div style="position: relative; display: flex; align-items: center;">
                                        <input type="number" name="points" value="{{ $pts }}"
                                            id="pts-input-{{ $member->id }}"
                                            style="width: 85px; padding: 6px 10px; border: 1px solid #CBD5E1; border-radius: 8px; font-size: 0.83rem; font-weight: 700; color: #0F172A; text-align: center; outline: none;"
                                            onfocus="this.style.borderColor='#4F46E5'"
                                            onblur="this.style.borderColor='#CBD5E1'">
                                    </div>

                                    <!-- Tombol Cepat Tambah/Kurang -->
                                    <button type="button"
                                        onclick="document.getElementById('pts-input-{{ $member->id }}').value = parseInt(document.getElementById('pts-input-{{ $member->id }}').value || 0) + 50"
                                        title="Tambah 50 Poin"
                                        style="padding: 6px 8px; background: #F1F5F9; color: #475569; border: 1px solid #CBD5E1; border-radius: 6px; font-size: 0.72rem; font-weight: 700; cursor: pointer;">
                                        +50
                                    </button>

                                    <button type="submit"
                                        style="padding: 6px 14px; background: #4F46E5; color: white; border: none; border-radius: 8px; font-size: 0.78rem; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 4px; box-shadow: 0 1px 2px rgba(79, 70, 229, 0.2); transition: all 0.2s;"
                                        onmouseover="this.style.background='#4338CA'"
                                        onmouseout="this.style.background='#4F46E5'">
                                        <i class="fa-solid fa-floppy-disk"></i> Simpan
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 32px; color: #94A3B8;">
                                <i class="fa-solid fa-users-slash"
                                    style="font-size: 1.5rem; margin-bottom: 8px; display: block;"></i>
                                Belum ada data member yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 20px;">
            {{ $members->links() }}
        </div>
    </div>
@endsection
