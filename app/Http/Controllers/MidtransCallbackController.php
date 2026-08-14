<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\Book;
use App\Models\PointHistory; // <-- Buka/Import Model PointHistory
use Illuminate\Http\Request;

class MidtransCallbackController extends Controller
{
    public function handle(Request $request)
    {
        \Midtrans\Config::$serverKey = config('services.midtrans.server_key', env('MIDTRANS_SERVER_KEY'));
        \Midtrans\Config::$isProduction = filter_var(config('services.midtrans.is_production', env('MIDTRANS_IS_PRODUCTION', false)), FILTER_VALIDATE_BOOLEAN);

        try {
            $notification = new \Midtrans\Notification();

            $transactionStatus = $notification->transaction_status;
            $paymentType       = $notification->payment_type;
            $orderId           = $notification->order_id;
            $fraudStatus       = $notification->fraud_status;

            $order = Order::with('items')->where('order_number', $orderId)->first();

            if (!$order) {
                return response()->json(['message' => 'Order not found'], 404);
            }

            $isSuccess = false;

            if ($transactionStatus == 'capture') {
                if ($paymentType == 'credit_card' && $fraudStatus != 'challenge') {
                    $isSuccess = true;
                }
            } else if ($transactionStatus == 'settlement') {
                $isSuccess = true;
            } else if (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
                $order->update(['status' => 'cancelled']);
                return response()->json(['message' => 'Order cancelled']);
            }

            // JIKA PEMBAYARAN SUKSES
            if ($isSuccess && $order->status !== 'completed' && $order->status !== 'paid') {

                // Cek apakah semua item di pesanan adalah Ebook (Digital)
                $isAllEbook = true;
                foreach ($order->items as $item) {
                    $book = Book::find($item->book_id);
                    if ($book && $book->type !== 'ebook') {
                        $isAllEbook = false;
                        break;
                    }
                }

                $order->status = $isAllEbook ? 'completed' : 'paid';
                $order->payment_method = strtoupper($paymentType);
                $order->save();

                // TAMBAHKAN POIN DAN CATAT DI RIWAYAT
                if ($order->user_id && $order->points_earned > 0) {
                    $user = User::find($order->user_id);
                    if ($user) {
                        // 1. Tambah Saldo Poin User
                        $user->increment('points', $order->points_earned);

                        // 2. Insert ke Riwayat Poin Otomatis
                        PointHistory::create([
                            'user_id'     => $user->id,
                            'title'       => 'Poin Pembelian Pesanan #' . $order->order_number,
                            'type'        => 'earned', // perolehan
                            'points'      => $order->points_earned,
                        ]);
                    }
                }
            }

            return response()->json(['message' => 'Notification processed successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
