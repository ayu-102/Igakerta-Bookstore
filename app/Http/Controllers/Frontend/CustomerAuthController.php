<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Wishlist;
use App\Models\Book;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\User;


class CustomerAuthController extends Controller
{
    // ... method login/register Anda yang sudah ada ...

    public function showLoginForm()
    {
        return view('auth.login'); // atau 'frontend.auth.login' sesuai lokasi blade kamu
    }

    public function showRegisterForm()
    {
        return view('auth.register'); // Sesuaikan dengan lokasi file register.blade.php Anda (misal: 'auth.register' atau 'frontend.auth.register')
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email',
            'phone'    => 'required|string|max:20|unique:users,phone',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'email.unique' => 'Email sudah terdaftar.',
            'phone.unique' => 'Nomor telepon sudah terdaftar.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
            'role'     => 'customer', // Sesuaikan jika ada kolom role
        ]);



        return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Silakan login dengan akun Anda.');
    }
    public function login(Request $request)
    {
        $request->validate([
            'login_id' => 'required|string',
            'password' => 'required|string',
        ]);

        $fieldType = filter_var($request->login_id, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        $credentials = [
            $fieldType => $request->login_id,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            /** @var \App\Models\User $user */
            $user = Auth::user();
            $user->update([
                'last_login_at' => Carbon::now(),
            ]);

            // MENGGUNAKAN redirect()->route() AGAR SELALU PAKSABUKA DASHBOARD LOG-IN PERTAMA KALI
            return redirect()->route('customer.dashboard');
        }

        return back()->withErrors([
            'login_id' => 'Email/No. Telepon atau password salah.',
        ])->onlyInput('login_id');
    }

    public function dashboard()
    {
        $userId = Auth::id();

        // 1. Hitung Widget Statistik
        $totalOrders = Order::where('user_id', $userId)->count();
        $completedOrders = Order::where('user_id', $userId)->whereIn('status', ['completed', 'selesai'])->count();

        // Ebook yang dibeli (mengambil item unik bernilai type ebook dari order yang sukses)
        $myEbooksCount = Order::where('user_id', $userId)
            ->whereIn('status', ['paid', 'shipped', 'completed', 'selesai'])
            ->whereHas('items.book', function ($q) {
                $q->where('type', 'ebook');
            })->count();

        $wishlistCount = Wishlist::where('user_id', $userId)->count();

        $activeVouchersCount = Voucher::where('is_active', 1)
            ->where(function ($q) {
                $q->whereNull('expiry_date')->orWhere('expiry_date', '>=', now());
            })->count();

        // 2. Pesanan Terakhir (3 data teratas)
        $latestOrders = Order::with(['items.book'])
            ->where('user_id', $userId)
            ->latest()
            ->take(3)
            ->get();

        // 3. Ringkasan Belanja
        $totalSpent = Order::where('user_id', $userId)
            ->whereIn('status', ['paid', 'shipped', 'completed', 'selesai'])
            ->sum('grand_total');

        $totalDiscount = Order::where('user_id', $userId)
            ->whereIn('status', ['paid', 'shipped', 'completed', 'selesai'])
            ->sum('discount');

        $physicalBooksBought = OrderItem::whereHas('order', function ($q) use ($userId) {
            $q->where('user_id', $userId)
                ->whereIn('status', ['paid', 'shipped', 'completed', 'selesai']);
        })
            ->whereHas('book', function ($q) {
                $q->where('type', 'physical');
            })
            ->sum('quantity');

        // 4. Rekomendasi Buku
        $recommendedBooks = Book::where('is_featured', 1)->take(3)->get();

        return view('customer.dashboard', compact(
            'totalOrders',
            'completedOrders',
            'myEbooksCount',
            'wishlistCount',
            'activeVouchersCount',
            'latestOrders',
            'totalSpent',
            'totalDiscount',
            'physicalBooksBought',
            'recommendedBooks'
        ));
    }

    public function myEbooks(Request $request)
    {
        $query = Book::where('type', 'ebook');

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $myEbooks = $query->paginate(8);

        return view('customer.ebook.index', compact('myEbooks'));
    }

    public function myVouchers()
    {
        // Mengambil voucher yang sedang aktif
        $vouchers = \App\Models\Voucher::where('is_active', true)->get();

        return view('customer.promo.index', compact('vouchers'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}
