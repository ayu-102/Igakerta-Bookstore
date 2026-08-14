<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class PaymentController extends Controller
{
    public function __construct()
    {
        // Konfigurasi Midtrans otomatis mengambil dari file .env Anda
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

    // 2. CALLBACK / WEBHOOK DARI MIDTRANS (Pengubah Status Otomatis)
    public function callback(Request $request)
    {
        try {
            $notif = new Notification();

            $transactionStatus = $notif->transaction_status;
            $orderId = $notif->order_id;
            $fraudStatus = $notif->fraud_status;

            // Cari order berdasarkan order_number (INV-XXXXX)
            $order = Order::where('order_number', $orderId)->first();

            if (!$order) {
                return response()->json(['message' => 'Order not found'], 444);
            }

            // Logika Perubahan Status Transaksi
            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'challenge') {
                    $order->status = 'pending';
                } else if ($fraudStatus == 'accept') {
                    $order->status = 'paid';
                }
            } else if ($transactionStatus == 'settlement') {
                $order->status = 'paid';
            } else if ($transactionStatus == 'pending') {
                $order->status = 'pending';
            } else if (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
                $order->status = 'failed';
            }

            $order->save();

            return response()->json(['message' => 'Notification processed successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
