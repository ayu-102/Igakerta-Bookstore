<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\Book;
use App\Models\PointHistory;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class PaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('services.midtrans.server_key', env('MIDTRANS_SERVER_KEY'));
        Config::$isProduction = config('services.midtrans.is_production', env('MIDTRANS_IS_PRODUCTION', false));
        Config::$isSanitized = config('services.midtrans.is_sanitized', env('MIDTRANS_IS_SANITIZED', true));
        Config::$is3ds = config('services.midtrans.is_3ds', env('MIDTRANS_IS_3DS', true));
    }

    // 1. GENERATE SNAP TOKEN UNTUK MIDTRANS
    public function getSnapToken(Order $order)
    {
        $params = [
            'transaction_details' => [
                'order_id'     => $order->order_number,
                'gross_amount' => (int) $order->grand_total,
            ],
            'customer_details' => [
                'first_name' => $order->recipient_name,
                'phone'      => $order->phone_number,
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            return response()->json(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // 2. CALLBACK / WEBHOOK DARI MIDTRANS (Pengubah Status & Tambah Poin Otomatis)
    public function callback(Request $request)
    {
        try {
            $notif = new Notification();

            $transactionStatus = $notif->transaction_status;
            $paymentType       = $notif->payment_type;
            $orderId           = $notif->order_id;
            $fraudStatus       = $notif->fraud_status;

            // Cari order beserta itemnya
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

            // JIKA PEMBAYARAN SUKSES & BELUM PERNAH DIPROSES SEBELUMNYA
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
                            'user_id' => $user->id,
                            'title'   => 'Poin Pembelian Pesanan #' . $order->order_number,
                            'type'    => 'earned',
                            'points'  => $order->points_earned,
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
