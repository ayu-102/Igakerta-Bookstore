<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate   = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());
        $status    = $request->input('status', 'all');

        $query = Order::with('items.book')
            ->whereBetween('created_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay()
            ]);

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        // Ambil data order beserta items
        $orders = $query->latest()->get();

        // Menggunakan kolom 'grand_total' sesuai skema migration orders
        $totalRevenue  = $orders->whereIn('status', ['completed', 'paid', 'PAID', 'COMPLETED', 'success'])->sum('grand_total');
        $totalOrders   = $orders->count();
        $paidOrders    = $orders->whereIn('status', ['completed', 'paid', 'PAID', 'COMPLETED', 'success'])->count();
        $pendingOrders = $orders->whereIn('status', ['pending', 'PENDING'])->count();

        return view('admin.reports.index', compact(
            'orders',
            'startDate',
            'endDate',
            'status',
            'totalRevenue',
            'totalOrders',
            'paidOrders',
            'pendingOrders'
        ));
    }
}
