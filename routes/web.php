<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\AboutController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\CustomerAuthController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\PublisherController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\PromoController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Frontend\CustomerOrderController;
use App\Http\Controllers\Frontend\CustomerProfileController;
use App\Http\Controllers\CustomerAddressController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\MidtransCallbackController;
use App\Http\Controllers\Customer\MemberController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\MemberController as AdminMemberController;

// --- 1. ROUTE AUTHENTICATION CUSTOMER (GUEST) ---
Route::middleware('guest')->group(function () {
    Route::get('/login', [CustomerAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [CustomerAuthController::class, 'login'])->name('login.post');

    Route::get('/register', [CustomerAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [CustomerAuthController::class, 'register'])->name('register.post');
});

// Logout customer
Route::post('/logout', [CustomerAuthController::class, 'logout'])->name('logout')->middleware('auth');


// --- 2. ROUTE CUSTOMER (WAJIB LOGIN) ---
Route::middleware('auth')->prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard', [CustomerAuthController::class, 'dashboard'])->name('dashboard');

    // Ebook Saya
    Route::get('/ebook-saya', [CustomerAuthController::class, 'myEbooks'])->name('ebooks');

    // Pesanan Saya
    Route::get('/orders', [CustomerOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [CustomerOrderController::class, 'show'])->name('orders.show');

    // Voucher Saya
    Route::get('/voucher-saya', [CustomerAuthController::class, 'myVouchers'])->name('vouchers');

    // Akun Saya (Profil)
    Route::get('/profile', [CustomerProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [CustomerProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [CustomerProfileController::class, 'updatePassword'])->name('profile.password');

    Route::post('/orders/{id}/reviews', [ReviewController::class, 'store'])->name('reviews.store');

    // Alamat Pengiriman
    Route::get('/addresses', [CustomerAddressController::class, 'index'])->name('addresses.index');
    Route::post('/addresses', [CustomerAddressController::class, 'store'])->name('addresses.store');
    Route::put('/addresses/{address}', [CustomerAddressController::class, 'update'])->name('addresses.update');
    Route::delete('/addresses/{address}', [CustomerAddressController::class, 'destroy'])->name('addresses.destroy');
    Route::patch('/addresses/{address}/set-default', [CustomerAddressController::class, 'setDefault'])->name('addresses.set-default');

    // Member & Poin Customer
    Route::get('/member', [MemberController::class, 'index'])->name('member.index');
});





// --- 4. ROUTE FRONTEND UMUM ---
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/katalog', [HomeController::class, 'catalog'])->name('catalog.index');
Route::get('/tentang-kami', [AboutController::class, 'index'])->name('about');
Route::get('/kontak', [ContactController::class, 'index'])->name('contact');


// --- 5. ROUTE PANEL ADMIN ---
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('books', BookController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('banners', BannerController::class)->except(['show', 'edit', 'update']);

    Route::resource('authors', AuthorController::class);
    Route::patch('authors/{author}/toggle-featured', [AuthorController::class, 'toggleFeatured'])->name('authors.toggleFeatured');

    Route::resource('vouchers', VoucherController::class);
    Route::patch('vouchers/{voucher}/toggle-status', [VoucherController::class, 'toggleStatus'])->name('vouchers.toggleStatus');
    Route::resource('promos', PromoController::class);

    Route::resource('publishers', PublisherController::class);
    Route::resource('articles', AdminArticleController::class);

    // Kelola Pesanan
    Route::resource('orders', OrderController::class)->only(['index', 'show']);
    Route::patch('orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::get('orders/{order}/check-status', [OrderController::class, 'checkStatus'])->name('orders.checkStatus');

    // Kelola Member & Poin (Admin)
    Route::get('/members', [AdminMemberController::class, 'index'])->name('members.index');
    Route::post('/members/{id}/update-points', [AdminMemberController::class, 'updatePoints'])->name('members.updatePoints');

    // Kelola Pengguna
    Route::get('/customers', [UserController::class, 'customers'])->name('customers.index');
    Route::get('/admins', [UserController::class, 'admins'])->name('admins.index');
    Route::post('/admins', [UserController::class, 'storeAdmin'])->name('admins.store');
    Route::put('/admins/{id}', [UserController::class, 'updateAdmin'])->name('admins.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    // Kelola Laporan & Pengaturan
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
});


// --- 6. ROUTE KERANJANG BELANJA & CHECKOUT ---
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/apply-voucher', [CartController::class, 'applyVoucher'])->name('cart.apply-voucher');
Route::post('/cart/remove-voucher', [CartController::class, 'removeVoucher'])->name('cart.remove-voucher');
Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/checkout/whatsapp', [CartController::class, 'checkoutWhatsApp'])->name('checkout.whatsapp');

Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
});


// --- 7. ROUTE BUKU, KATALOG EBOOK, ARTIKEL, WISHLIST ---
Route::get('/books/{id}', [HomeController::class, 'show'])->name('books.show');
Route::post('/books/{id}/reviews', [ReviewController::class, 'store'])->name('books.reviews.store')->middleware('auth');

Route::get('/ebook', [HomeController::class, 'ebook'])->name('ebook.index');
Route::get('/penulis', [HomeController::class, 'authors'])->name('authors.index');
Route::get('/penulis/{id}', [HomeController::class, 'authorShow'])->name('authors.show');
Route::get('/promo', [HomeController::class, 'promo'])->name('promo.index');

Route::middleware('auth')->group(function () {
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle/{id}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::post('/wishlist/move-to-cart/{id}', [WishlistController::class, 'moveToCart'])->name('wishlist.moveToCart');
    Route::delete('/wishlist/remove/{id}', [WishlistController::class, 'remove'])->name('wishlist.remove');
});

Route::get('/artikel', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{slug}', [ArticleController::class, 'show'])->name('articles.show');


// --- 8. ROUTE PAYMENT MIDTRANS ---
// Menggunakan match(['get', 'post']) untuk mengakomodasi request dari Midtrans & redirect SSL hosting
Route::match(['get', 'post'], '/midtrans/callback', [MidtransCallbackController::class, 'handle'])->name('midtrans.callback');

Route::middleware('auth')->group(function () {
    Route::get('/payment/snap-token/{order}', [PaymentController::class, 'getSnapToken'])->name('payment.snap-token');
});
