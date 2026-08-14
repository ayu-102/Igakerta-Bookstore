<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerOrderController extends Controller
{
    // Menampilkan daftar pesanan milik user yang sedang login
    public function index(Request $request)
    {
        $userId = Auth::id();
        $query = Order::with('items.book')->where('user_id', $userId)->latest();

        // Filter berdasarkan status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Pencarian nomor pesanan
        if ($request->filled('search')) {
            $query->where('order_number', 'like', "%{$request->search}%");
        }

        $orders = $query->paginate(5)->withQueryString();

        // Count per status untuk badge/tab filter
        $counts = [
            'all'       => Order::where('user_id', $userId)->count(),
            'pending'   => Order::where('user_id', $userId)->where('status', 'pending')->count(),
            'paid'      => Order::where('user_id', $userId)->where('status', 'paid')->count(),
            'shipped'   => Order::where('user_id', $userId)->where('status', 'shipped')->count(),
            'completed' => Order::where('user_id', $userId)->whereIn('status', ['completed', 'selesai'])->count(),
            'cancelled' => Order::where('user_id', $userId)->where('status', 'cancelled')->count(),
        ];

        return view('customer.orders.index', compact('orders', 'counts'));
    }

    // Menampilkan detail invoice pesanan
    public function show($id)
    {
        $order = Order::with('items.book')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('customer.orders.show', compact('order'));
    }
}
