@extends('admin.app')

@section('title', 'Dashboard - IGAKERTA Book Store')

@push('styles')
    <style>
        .dash-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .dash-title h2 {
            font-size: 1.35rem;
            font-weight: 800;
            color: #0F172A;
            margin: 0 0 4px 0;
        }

        .dash-title p {
            font-size: 0.85rem;
            color: #64748B;
            margin: 0;
        }

        /* STATS CARDS */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 25px;
        }

        .stat-card {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 14px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
            transition: transform 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
        }

        .stat-icon {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.15rem;
            margin-bottom: 14px;
        }

        .stat-label {
            font-size: 0.75rem;
            font-weight: 700;
            color: #64748B;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .stat-value {
            font-size: 1.35rem;
            font-weight: 800;
            color: #0F172A;
            margin: 4px 0;
        }

        .stat-subtext {
            font-size: 0.72rem;
            font-weight: 600;
            color: #94A3B8;
        }

        /* CHARTS GRID */
        .charts-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
            margin-bottom: 25px;
        }

        .chart-card {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 14px;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
        }

        .card-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }

        .card-head h4 {
            font-size: 0.925rem;
            font-weight: 800;
            color: #0F172A;
            margin: 0;
        }

        /* TABLES GRID */
        .tables-grid {
            display: grid;
            grid-template-columns: 1.2fr 1fr;
            gap: 20px;
        }

        .custom-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.825rem;
        }

        .custom-table th {
            text-align: left;
            color: #475569;
            padding: 10px 12px;
            border-bottom: 1px solid #E2E8F0;
            font-weight: 700;
            font-size: 0.75rem;
            text-transform: uppercase;
            background: #F8FAFC;
        }

        .custom-table td {
            padding: 12px;
            border-bottom: 1px solid #F1F5F9;
            color: #1E293B;
            vertical-align: middle;
        }

        .badge-status {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.72rem;
            font-weight: 700;
            display: inline-block;
        }

        .status-critical {
            background: #FEF2F2;
            color: #EF4444;
            border: 1px solid #FECACA;
        }

        .year-select {
            border: 1px solid #CBD5E1;
            border-radius: 6px;
            padding: 4px 10px;
            font-size: 0.775rem;
            font-weight: 600;
            color: #475569;
            background-color: #F8FAFC;
            outline: none;
            cursor: pointer;
        }

        @media (max-width: 1024px) {

            .charts-grid,
            .tables-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@section('content')
    <!-- HEADER -->
    <div class="dash-header">
        <div class="dash-title">
            <h2>Dashboard Overview</h2>
            <p>Ringkasan statistik data katalog dan transaksi toko buku IGAKERTA 👋</p>
        </div>
        <div
            style="background: white; border: 1px solid #E2E8F0; padding: 8px 14px; border-radius: 10px; font-size: 0.825rem; font-weight: 600; color: #475569; box-shadow: 0 1px 2px rgba(0,0,0,0.03);">
            <i class="fa-regular fa-calendar-check" style="color: #2D1558; margin-right: 6px;"></i> {{ date('d M Y') }}
        </div>
    </div>

    <!-- 5 STATS CARDS DINAMIS -->
    <div class="stats-grid">
        <!-- TOTAL BUKU -->
        <div class="stat-card">
            <div>
                <div class="stat-icon" style="background: #F5EFFF; color: #2D1558;">
                    <i class="fa-solid fa-book"></i>
                </div>
                <div class="stat-label">Total Buku</div>
                <div class="stat-value">{{ number_format($stats['total_produk'], 0, ',', '.') }}</div>
            </div>
            <div class="stat-subtext">Judul terdaftar</div>
        </div>

        <!-- TOTAL KATEGORI -->
        <div class="stat-card">
            <div>
                <div class="stat-icon" style="background: #E0F2FE; color: #0284C7;">
                    <i class="fa-solid fa-tags"></i>
                </div>
                <div class="stat-label">Kategori</div>
                <div class="stat-value">{{ number_format($stats['total_kategori'], 0, ',', '.') }}</div>
            </div>
            <div class="stat-subtext">Genre & Topik</div>
        </div>

        <!-- TOTAL PENULIS -->
        <div class="stat-card">
            <div>
                <div class="stat-icon" style="background: #FEF3C7; color: #D97706;">
                    <i class="fa-solid fa-user-pen"></i>
                </div>
                <div class="stat-label">Penulis</div>
                <div class="stat-value">{{ number_format($stats['total_penulis'], 0, ',', '.') }}</div>
            </div>
            <div class="stat-subtext">Penulis terdaftar</div>
        </div>

        <!-- TOTAL PENERBIT -->
        <div class="stat-card">
            <div>
                <div class="stat-icon" style="background: #ECFDF5; color: #10B981;">
                    <i class="fa-solid fa-building"></i>
                </div>
                <div class="stat-label">Penerbit</div>
                <div class="stat-value">{{ number_format($stats['total_penerbit'], 0, ',', '.') }}</div>
            </div>
            <div class="stat-subtext">Mitra penerbitan</div>
        </div>

        <!-- STOK MENIPIS -->
        <div class="stat-card">
            <div>
                <div class="stat-icon" style="background: #FEF2F2; color: #EF4444;">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
                <div class="stat-label">Stok Menipis</div>
                <div class="stat-value" style="color: #EF4444;">{{ $stats['stok_menipis'] }}</div>
            </div>
            <div class="stat-subtext" style="color: #EF4444; font-weight: 700;">Stok &le; 5 Eksemplar</div>
        </div>
    </div>

    <!-- CHARTS SECTION -->
    <div class="charts-grid">
        <!-- CHART PENJUALAN LINE CHART DINAMIS -->
        <div class="chart-card">
            <div class="card-head">
                <h4 style="display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-chart-line" style="color: #2D1558;"></i>
                    Grafik Penjualan Tahun {{ $selectedYear }}
                </h4>
                <!-- FILTER TAHUN -->
                <form method="GET" action="{{ route('admin.dashboard') }}" id="yearFilterForm">
                    <select name="year" class="year-select"
                        onchange="document.getElementById('yearFilterForm').submit();">
                        @foreach ($availableYears as $y)
                            <option value="{{ $y }}" {{ $selectedYear == $y ? 'selected' : '' }}>
                                Tahun {{ $y }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
            <div style="position: relative; height: 220px; width: 100%;">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        <!-- CHART DONUT KATEGORI DINAMIS -->
        <div class="chart-card">
            <div class="card-head">
                <h4>Sebaran Buku per Kategori</h4>
            </div>
            <div style="position: relative; height: 220px;">
                <canvas id="categoryChart"></canvas>
            </div>
        </div>
    </div>

    <!-- TABLES SECTION -->
    <div class="tables-grid">
        <!-- BUKU STOK MENIPIS DINAMIS -->
        <div class="chart-card">
            <div class="card-head">
                <h4><i class="fa-solid fa-boxes-stacked" style="color: #EF4444; margin-right: 6px;"></i> Peringatan Stok
                    Menipis</h4>
                <a href="{{ route('admin.books.index') }}"
                    style="font-size: 0.775rem; color: #2D1558; font-weight: 700; text-decoration: none;">
                    Kelola Buku &rarr;
                </a>
            </div>
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Judul Buku</th>
                        <th style="text-align: center;">Sisa Stok</th>
                        <th style="text-align: center;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($lowStockBooks as $book)
                        <tr>
                            <td>
                                <strong style="color: #0F172A;">{{ $book->title }}</strong>
                            </td>
                            <td style="text-align: center; font-weight: 700;">{{ $book->stock }} eksemplar</td>
                            <td style="text-align: center;">
                                <span class="badge-status status-critical">Perlu Restock</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" style="text-align: center; padding: 20px; color: #94A3B8;">
                                <i class="fa-solid fa-circle-check" style="color: #10B981; margin-right: 4px;"></i> Semua
                                stok buku dalam kondisi aman.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- INFORMASI/RINGKASAN CEPAT -->
        <div class="chart-card">
            <div class="card-head">
                <h4>Aksi Cepat</h4>
            </div>
            <div style="display: flex; flex-direction: column; gap: 10px;">
                <a href="{{ route('admin.books.create') }}"
                    style="display: flex; align-items: center; justify-content: space-between; padding: 12px 16px; background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 10px; text-decoration: none; color: #0F172A; font-weight: 600; font-size: 0.85rem;">
                    <span><i class="fa-solid fa-plus-circle" style="color: #2D1558; margin-right: 8px;"></i> Tambah Buku
                        Baru</span>
                    <i class="fa-solid fa-chevron-right" style="font-size: 0.75rem; color: #94A3B8;"></i>
                </a>
                <a href="{{ route('admin.authors.create') }}"
                    style="display: flex; align-items: center; justify-content: space-between; padding: 12px 16px; background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 10px; text-decoration: none; color: #0F172A; font-weight: 600; font-size: 0.85rem;">
                    <span><i class="fa-solid fa-user-plus" style="color: #2D1558; margin-right: 8px;"></i> Tambah Penulis
                        Baru</span>
                    <i class="fa-solid fa-chevron-right" style="font-size: 0.75rem; color: #94A3B8;"></i>
                </a>
                <a href="{{ route('admin.categories.create') }}"
                    style="display: flex; align-items: center; justify-content: space-between; padding: 12px 16px; background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 10px; text-decoration: none; color: #0F172A; font-weight: 600; font-size: 0.85rem;">
                    <span><i class="fa-solid fa-folder-plus" style="color: #2D1558; margin-right: 8px;"></i> Tambah Kategori
                        Baru</span>
                    <i class="fa-solid fa-chevron-right" style="font-size: 0.75rem; color: #94A3B8;"></i>
                </a>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // 1. Chart Line Penjualan Dinamis
        const ctxSales = document.getElementById('salesChart').getContext('2d');
        const salesLabels = {!! json_encode($salesLabels) !!};
        const salesAmountData = {!! json_encode($salesAmountData) !!};
        const ordersCountData = {!! json_encode($ordersCountData) !!};

        new Chart(ctxSales, {
            type: 'line',
            data: {
                labels: salesLabels,
                datasets: [{
                        label: 'Penjualan (Rp)',
                        data: salesAmountData,
                        borderColor: '#2D1558',
                        backgroundColor: 'rgba(45, 21, 88, 0.05)',
                        fill: true,
                        tension: 0.35,
                        pointBackgroundColor: '#2D1558',
                        pointRadius: 4,
                        yAxisID: 'y'
                    },
                    {
                        label: 'Pesanan (Jumlah)',
                        data: ordersCountData,
                        borderColor: '#D97706',
                        backgroundColor: 'transparent',
                        borderDash: [5, 5],
                        tension: 0.35,
                        pointBackgroundColor: '#D97706',
                        pointRadius: 4,
                        yAxisID: 'y1'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        min: 0,
                        // Menentukan kelipatan kelipatan 5 Juta
                        stepSize: 5000000,
                        // Batas minimum tinggi grafik jika data belum mencapai 5 juta
                        suggestedMax: 15000000,
                        ticks: {
                            callback: function(value) {
                                if (value === 0) return 'Rp 0';
                                // Menampilkan kelipatan bulat tanpa koma/desimal (contoh: Rp 5 jt, Rp 10 jt)
                                return 'Rp ' + (value / 1000000) + ' jt';
                            }
                        },
                        grid: {
                            borderDash: [2, 2]
                        }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        grid: {
                            drawOnChartArea: false
                        },
                        ticks: {
                            precision: 0,
                            callback: function(value) {
                                return value + ' trx';
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            boxWidth: 8,
                            font: {
                                size: 11
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.datasetIndex === 0) {
                                    label += new Intl.NumberFormat('id-ID', {
                                        style: 'currency',
                                        currency: 'IDR',
                                        maximumFractionDigits: 0
                                    }).format(context.raw);
                                } else {
                                    label += context.raw + ' Pesanan';
                                }
                                return label;
                            }
                        }
                    }
                }
            }
        });

        // 2. Chart Donut Kategori Dinamis
        const ctxCat = document.getElementById('categoryChart').getContext('2d');
        const categoryLabels = {!! json_encode($categoryLabels) !!};
        const categoryData = {!! json_encode($categoryData) !!};

        new Chart(ctxCat, {
            type: 'doughnut',
            data: {
                labels: categoryLabels.length > 0 ? categoryLabels : ['Belum Ada Kategori'],
                datasets: [{
                    data: categoryData.length > 0 ? categoryData : [1],
                    backgroundColor: ['#2D1558', '#0284C7', '#D97706', '#10B981', '#EC4899', '#6366F1']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            font: {
                                size: 11
                            },
                            boxWidth: 12
                        }
                    }
                }
            }
        });
    </script>
@endpush
