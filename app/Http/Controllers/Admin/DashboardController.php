<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\Author;
use App\Models\Publisher;
use App\Models\User;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // 1. Mengambil data buku dengan stok menipis (<= 5 eksemplar)
        $lowStockBooks = Book::where('stock', '<=', 5)
            ->orderBy('stock', 'asc')
            ->take(5)
            ->get();

        // 2. Menghitung statistik riil dari database
        $totalBooks       = Book::count();
        $totalCategories  = Category::count();
        $totalAuthors     = Author::count();
        $totalPublishers  = Publisher::count();
        $totalUsers       = User::count();

        // Total Penjualan & Total Pesanan Riil
        $paidStatuses   = ['completed', 'paid', 'PAID', 'COMPLETED', 'success'];
        $totalPenjualan = Order::whereIn('status', $paidStatuses)->sum('grand_total');
        $totalPesanan   = Order::count();

        // 3. Menyusun array statistik untuk view
        $stats = [
            'total_penjualan' => $totalPenjualan,
            'total_pesanan'   => $totalPesanan,
            'total_pelanggan' => $totalUsers,
            'total_produk'    => $totalBooks,
            'total_kategori'  => $totalCategories,
            'total_penulis'   => $totalAuthors,
            'total_penerbit'  => $totalPublishers,
            'stok_menipis'    => Book::where('stock', '<=', 5)->count(),
        ];

        // 4. Opsi Filter Tahun & Rentang/Mode
        $selectedYear = (int) $request->get('year', Carbon::now()->year);

        // Ambil daftar tahun unik dari data Order (sebagai pilihan dropdown tahun)
        $availableYears = Order::selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();

        // Jika data transaksi belum ada, sediakan tahun sekarang & tahun lalu
        if (empty($availableYears)) {
            $availableYears = [Carbon::now()->year, Carbon::now()->subYear()->year];
        }

        $salesLabels = [];
        $salesAmountData = [];
        $ordersCountData = [];

        // Generate data 12 Bulan untuk Tahun yang Dipilih
        for ($monthNumber = 1; $monthNumber <= 12; $monthNumber++) {
            $date = Carbon::createFromDate($selectedYear, $monthNumber, 1);
            $salesLabels[] = $date->translatedFormat('M'); // Contoh: Jan, Feb, Mar

            $monthlyRevenue = Order::whereIn('status', $paidStatuses)
                ->whereYear('created_at', $selectedYear)
                ->whereMonth('created_at', $monthNumber)
                ->sum('grand_total');

            $monthlyOrdersCount = Order::whereYear('created_at', $selectedYear)
                ->whereMonth('created_at', $monthNumber)
                ->count();

            $salesAmountData[] = (float) $monthlyRevenue;
            $ordersCountData[] = $monthlyOrdersCount;
        }

        // 5. Data sebaran kategori untuk Chart Donut
        $categoriesChart = Category::withCount('books')
            ->orderBy('books_count', 'desc')
            ->take(5)
            ->get();

        $categoryLabels = $categoriesChart->pluck('name');
        $categoryData   = $categoriesChart->pluck('books_count');

        return view('admin.dashboard', compact(
            'stats',
            'lowStockBooks',
            'categoryLabels',
            'categoryData',
            'salesLabels',
            'salesAmountData',
            'ordersCountData',
            'selectedYear',
            'availableYears'
        ));
    }
}
