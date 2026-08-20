<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\PointHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    private function calculateVoucherDiscount($subtotal)
    {
        $discountAmount = 0;
        if (session()->has('voucher')) {
            $v = session('voucher');
            $vType = strtolower($v['type'] ?? ($v['discount_type'] ?? 'fixed'));
            $vVal = (float) ($v['discount'] ?? ($v['discount_amount'] ?? ($v['nominal'] ?? 0)));

            if (in_array($vType, ['percent', 'percentage', 'persentase'])) {
                $discountAmount = ($subtotal * $vVal) / 100;
            } else {
                $discountAmount = $vVal;
            }
        }
        return $discountAmount;
    }

    public function index(Request $request)
    {
        $cart = [];

        if ($request->has('book_id')) {
            $book = Book::findOrFail($request->book_id);
            $quantity = (int) $request->get('quantity', 1);
            $type = $request->get('type', $book->type);

            $price = ($book->discount_price && $book->discount_price > 0) ? $book->discount_price : $book->price;

            if ($book->promotions && $book->promotions->where('is_active', 1)->first()) {
                $discountPercent = $book->promotions->where('is_active', 1)->first()->discount_percentage;
                $price = $price * (1 - ($discountPercent / 100));
            }

            $cart[$book->id] = [
                'id'          => $book->id,
                'title'       => $book->title,
                'price'       => $price,
                'quantity'    => $quantity,
                'cover_image' => $book->cover ?? ($book->cover_image ?? $book->image),
                'type'        => $type,
            ];

            session()->put('checkout_items', $cart);
        } else {
            $cart = session()->get('cart', []);
            session()->put('checkout_items', $cart);
        }

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda masih kosong!');
        }

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $discountAmount = $this->calculateVoucherDiscount($subtotal);
        $shippingCost = 15000;
        $grandTotal = max(0, $subtotal + $shippingCost - $discountAmount);

        $addresses = collect();
        $defaultAddress = null;
        $userPoints = 0;

        if (Auth::check()) {
            $user = Auth::user();
            $addresses = $user->addresses;
            $defaultAddress = $addresses->where('is_default', true)->first() ?? $addresses->first();
            $userPoints = $user->points ?? 0;
        }

        $selectedCity = $defaultAddress ? $defaultAddress->city : session()->get('shipping_destination', 'Kota Depok, Jawa Barat');

        $cities = [
            'Kota Depok, Jawa Barat',
            'Jakarta Selatan, DKI Jakarta',
            'Bandung, Jawa Barat',
            'Tangerang, Banten',
            'Surabaya, Jawa Timur',
            'Yogyakarta, DI Yogyakarta'
        ];

        return view('checkout.index', compact(
            'cart',
            'subtotal',
            'discountAmount',
            'shippingCost',
            'grandTotal',
            'selectedCity',
            'cities',
            'addresses',
            'defaultAddress',
            'userPoints'
        ));
    }


    public function finishPayment(Request $request)
    {
        $request->validate([
            'order_number' => 'required|string',
        ]);

        $order = Order::with('items')->where('order_number', $request->order_number)->first();

        if (!$order) {
            return response()->json(['status' => 'error', 'message' => 'Pesanan tidak ditemukan'], 404);
        }

        // Eksekusi penambahan poin jika order belum pernah diproses (mencegah double point)
        if ($order->status !== 'completed' && $order->status !== 'paid') {

            // Cek jenis buku (ebook vs fisik)
            $isAllEbook = true;
            foreach ($order->items as $item) {
                $book = Book::find($item->book_id);
                if ($book && $book->type !== 'ebook') {
                    $isAllEbook = false;
                    break;
                }
            }

            // Set status pesanan
            $order->status = $isAllEbook ? 'completed' : 'paid';
            if ($request->filled('payment_type')) {
                $order->payment_method = strtoupper((string) $request->payment_type);
            }
            $order->save();

            // TAMBAHKAN POIN OTOMATIS KE MEMBER
            if ($order->user_id && $order->points_earned > 0) {
                $user = User::find($order->user_id);
                if ($user) {
                    // 1. Tambahkan saldo poin user
                    $user->increment('points', $order->points_earned);

                    // 2. Catat di riwayat poin
                    PointHistory::create([
                        'user_id' => $user->id,
                        'title'   => 'Poin Pembelian Pesanan #' . $order->order_number,
                        'type'    => 'earned',
                        'points'  => $order->points_earned,
                    ]);
                }
            }
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Pembayaran berhasil dikonfirmasi dan poin telah ditambahkan!'
        ]);
    }

    public function process(Request $request)
    {
        $request->validate([
            'recipient_name'  => 'required|string|max:100',
            'phone_number'    => 'required|string|max:20',
            'address_detail'  => 'required|string',
            'city'            => 'required|string',
            'province'        => 'nullable|string',
            'postal_code'     => 'required|string|max:10',
            'shipping_method' => 'required|string',
            'payment_method'  => 'required|string',
            'use_points'      => 'nullable|boolean',
        ]);

        $cart = session()->get('checkout_items', session()->get('cart', []));

        if (empty($cart)) {
            return response()->json(['status' => 'error', 'message' => 'Keranjang Anda masih kosong!'], 400);
        }

        // 1. Kalkulasi Subtotal & Diskon Voucher
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $discountAmount = $this->calculateVoucherDiscount($subtotal);
        $shippingCost = ($request->shipping_method == 'Express (JNE YES)') ? 25000 : 15000;

        // 2. Hitung Potongan Poin
        $pointsUsed = 0;
        $pointsDiscount = 0;

        if ($request->boolean('use_points') && Auth::check()) {
            $user = Auth::user();
            $maxDiscountAllowed = max(0, $subtotal + $shippingCost - $discountAmount);

            // 1 Poin = Rp 500
            $pointsNeededForFullDiscount = ceil($maxDiscountAllowed / 500);

            if ($user->points > 0) {
                $pointsUsed = min($user->points, $pointsNeededForFullDiscount);
                $pointsDiscount = min($pointsUsed * 500, $maxDiscountAllowed);
            }
        }

        $grandTotal = max(0, $subtotal + $shippingCost - $discountAmount - $pointsDiscount);

        // Hitung estimasi poin yang akan didapat (1 Poin tiap Rp 10.000 belanja)
        $pointsEarned = floor($subtotal / 10000);

        // 3. Simpan Data Order ke Database
        $order = Order::create([
            'user_id'         => Auth::check() ? Auth::id() : null,
            'order_number'    => 'INV-' . strtoupper(Str::random(8)),

            'recipient_name'  => $request->recipient_name,
            'phone_number'    => $request->phone_number,
            'address_detail'  => $request->address_detail,
            'city'            => $request->city,
            'province'        => $request->province ?? '-',
            'postal_code'     => $request->postal_code,

            'shipping_method' => $request->shipping_method,
            'shipping_cost'   => $shippingCost,
            'payment_method'  => $request->payment_method,
            'notes'           => $request->notes,

            'subtotal'        => $subtotal,
            'discount'        => $discountAmount,
            'points_used'     => $pointsUsed,
            'points_discount' => $pointsDiscount,
            'points_earned'   => $pointsEarned,
            'grand_total'     => $grandTotal,

            'status'          => 'pending',
        ]);

        // --- PROSES POTONG KUOTA VOUCHER DI DATABASE ---
        if (session()->has('voucher')) {
            $voucherData = session('voucher');
            $voucherCode = $voucherData['code'] ?? null;

            if ($voucherCode) {
                $voucher = \App\Models\Voucher::where('code', $voucherCode)->first();
                if ($voucher) {
                    $voucher->increment('used_count'); // Tambah jumlah pemakaian di database
                }
            }
        }

        // Potong Poin User Jika Digunakan
        if ($pointsUsed > 0 && Auth::check()) {
            $user = \App\Models\User::find(Auth::id());
            if ($user) {
                $user->decrement('points', $pointsUsed);


                \App\Models\PointHistory::create([
                    'user_id' => $user->id,
                    'title'   => 'Penukaran Poin Diskon Pesanan #' . $order->order_number,
                    'type'    => 'used',
                    'points'  => $pointsUsed,
                ]);
            }
        }

        // 4. Simpan Item & Potong Stok
        $itemDetails = [];
        foreach ($cart as $bookId => $item) {
            OrderItem::create([
                'order_id'   => $order->id,
                'book_id'    => $bookId,
                'book_title' => $item['title'],
                'price'      => $item['price'],
                'quantity'   => $item['quantity'],
                'subtotal'   => $item['price'] * $item['quantity'],
            ]);

            $book = Book::find($bookId);
            if ($book && $book->type === 'physical') {
                // Hanya kurangi stok jika buku fisik
                $book->decrement('stock', $item['quantity']);
            }

            $itemDetails[] = [
                'id'       => (string) $bookId,
                'price'    => (int) $item['price'],
                'quantity' => (int) $item['quantity'],
                'name'     => substr($item['title'], 0, 50),
            ];
        }

        if ($shippingCost > 0) {
            $itemDetails[] = [
                'id'       => 'SHIPPING',
                'price'    => (int) $shippingCost,
                'quantity' => 1,
                'name'     => 'Ongkos Kirim (' . $request->shipping_method . ')',
            ];
        }

        if ($discountAmount > 0) {
            $itemDetails[] = [
                'id'       => 'DISCOUNT',
                'price'    => (int) (-$discountAmount),
                'quantity' => 1,
                'name'     => 'Diskon Voucher',
            ];
        }

        if ($pointsDiscount > 0) {
            $itemDetails[] = [
                'id'       => 'POINTS_DISCOUNT',
                'price'    => (int) (-$pointsDiscount),
                'quantity' => 1,
                'name'     => 'Potongan Poin (' . $pointsUsed . ' Poin)',
            ];
        }

        // 5. Konfigurasi SDK Midtrans
        \Midtrans\Config::$serverKey = config('services.midtrans.server_key', env('MIDTRANS_SERVER_KEY'));
        \Midtrans\Config::$isProduction = filter_var(config('services.midtrans.is_production', env('MIDTRANS_IS_PRODUCTION', false)), FILTER_VALIDATE_BOOLEAN);
        \Midtrans\Config::$isSanitized = filter_var(config('services.midtrans.is_sanitized', env('MIDTRANS_IS_SANITIZED', true)), FILTER_VALIDATE_BOOLEAN);
        \Midtrans\Config::$is3ds = filter_var(config('services.midtrans.is_3ds', env('MIDTRANS_IS_3DS', true)), FILTER_VALIDATE_BOOLEAN);

        $params = [
            'transaction_details' => [
                'order_id'     => $order->order_number,
                'gross_amount' => (int) $grandTotal,
            ],
            'customer_details' => [
                'first_name' => $request->recipient_name,
                'phone'      => $request->phone_number,
            ],
            'item_details' => $itemDetails,
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);

            session()->forget(['cart', 'checkout_items', 'voucher', 'shipping_destination']);

            return response()->json([
                'status'       => 'success',
                'snap_token'   => $snapToken,
                'order_number' => $order->order_number,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
