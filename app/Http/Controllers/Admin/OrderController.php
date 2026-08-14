<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Book;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // 1. Tampilkan Daftar Pesanan dengan Filter Status & Pencarian
    public function index(Request $request)
    {
        $query = Order::with('items')->latest();

        // Filter berdasarkan status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter pencarian (Nomor Pesanan / Nama Penerima / HP)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhere('recipient_name', 'like', "%{$search}%")
                    ->orWhere('phone_number', 'like', "%{$search}%");
            });
        }

        $orders = $query->paginate(10)->withQueryString();

        // Ringkasan hitungan untuk tab filter
        $counts = [
            'all'       => Order::count(),
            'pending'   => Order::where('status', 'pending')->count(),
            'paid'      => Order::where('status', 'paid')->count(),
            'shipped'   => Order::where('status', 'shipped')->count(),
            'completed' => Order::where('status', 'completed')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
        ];

        return view('admin.orders.index', compact('orders', 'counts'));
    }

    // 2. Tampilkan Detail Pesanan
    public function show($id)
    {
        $order = Order::with('items.book')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    // 3. Update Status Pesanan & Hitung Otomatis Sold Count
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,shipped,completed,cancelled'
        ]);

        $order = Order::with('items')->findOrFail($id);
        $oldStatus = $order->status;
        $newStatus = $request->status;

        // Eksekusi penambahan poin dan stok HANYA saat status berubah dari non-completed menjadi completed
        if ($newStatus === 'completed' && $oldStatus !== 'completed') {
            foreach ($order->items as $item) {
                $book = Book::find($item->book_id);
                if ($book) {
                    $book->increment('sold_count', $item->quantity);
                    if ($book->type === 'physical') {
                        $book->decrement('stock', $item->quantity);
                    }
                }
            }

            // Tambahkan Poin ke User
            if ($order->user_id && $order->points_earned > 0) {
                $user = \App\Models\User::find($order->user_id);
                if ($user) {
                    $user->increment('points', $order->points_earned);
                }
            }
        }

        $order->update(['status' => $newStatus]);

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui!');
    }



    // 4. CEK STATUS TRANSAKSI KE SERVER MIDTRANS (UNTUK TESTING LOKAL)
    public function checkStatus($id)
    {
        $order = Order::findOrFail($id);

        \Midtrans\Config::$serverKey = config('services.midtrans.server_key', env('MIDTRANS_SERVER_KEY'));
        \Midtrans\Config::$isProduction = (bool) config('services.midtrans.is_production', false);

        try {
            $midtransStatus = (array) \Midtrans\Transaction::status($order->order_number);
            $transactionStatus = $midtransStatus['transaction_status'] ?? null;
            $paymentType       = $midtransStatus['payment_type'] ?? $order->payment_method;

            if ($transactionStatus == 'settlement' || $transactionStatus == 'capture') {

                // Ubah status ke completed jika belum
                if ($order->status !== 'completed') {
                    $order->update([
                        'status' => 'completed',
                        'payment_method' => strtoupper((string) $paymentType)
                    ]);

                    // Tambahkan poin otomatis
                    if ($order->user_id && $order->points_earned > 0) {
                        $user = \App\Models\User::find($order->user_id);
                        if ($user) {
                            $user->increment('points', $order->points_earned);
                        }
                    }
                }

                return redirect()->back()->with('success', 'Pembayaran terverifikasi! Status otomatis Selesai dan Poin berhasil ditambahkan ke pelanggan.');
            } else if ($transactionStatus == 'pending') {
                return redirect()->back()->with('info', 'Pembayaran masih belum diselesaikan oleh pembeli.');
            } else if (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
                $order->update(['status' => 'cancelled']);
                return redirect()->back()->with('error', 'Pembayaran dibatalkan atau telah kedaluwarsa.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal terhubung ke Midtrans: ' . $e->getMessage());
        }

        return redirect()->back();
    }
}
