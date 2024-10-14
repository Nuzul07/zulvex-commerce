<?php

use App\Http\Controllers\Admin\AddressController;
use App\Http\Controllers\Admin\CartController;
use App\Http\Controllers\Admin\CheckoutController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Admin\WishlistController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\User\AboutController;
use App\Http\Controllers\User\AllController;
use App\Http\Controllers\User\ContactController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Mail\OtpMail;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Mail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/send-test-email', function () {
    try {
        $otp = rand(100000, 999999); // Generate a random 6-digit OTP

        Mail::to('ferayuza190@gmail.com')->send(new OtpMail($otp));
        return 'Test email sent successfully!';
    } catch (\Exception $e) {
        return 'Failed to send email: ' . $e->getMessage();
    }
});


//users routes
Route::get('/verify-email', [VerificationController::class, 'showVerifyForm'])->name('verify-email');
Route::post('/verify-email', [VerificationController::class, 'verifyOtp'])->name('verify-otp');
Route::get('product-collection', [AllController::class, 'indexProduct'])->name('productCollect');
Route::get('get-counter', [AllController::class, 'getCounter'])->name('getCounter');
Route::get('product-all', [ProductController::class, 'getAll'])->name('productAll');
Route::get('users-all', [UserController::class, 'getAll'])->name('userAll');
Route::get('address-all', [AddressController::class, 'getAll'])->name('addressAll');
Route::get('voucher-all', [VoucherController::class, 'getAll'])->name('voucherAll');
Route::get('review-all', [ReviewController::class, 'getAll'])->name('reviewAll');
Route::get('payment-all', [PaymentController::class, 'getAll'])->name('paymentAll');
Route::get('wishlist-all', [WishlistController::class, 'getAll'])->name('wishlistAll');
Route::get('wishlist', [WishlistController::class, 'index'])->name('wishlist');
Route::get('cart', [CartController::class, 'index'])->name('cart');
Route::get('about-us', [AllController::class, 'indexAbout'])->name('aboutUs');
Route::get('contact-us', [AllController::class, 'indexContact'])->name('contactUs');

Route::get('/', function () {
    return Inertia::render('User/Index', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'wishlist_count' => Wishlist::count()
    ]);
})->name('userDashboard');

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->group(function () {


    Route::group(['prefix' => 'admin'], function () {
        Route::group(['middleware' => 'role:1'], function () {
            Route::get('dashboard', function () {
                return Inertia::render('Admin/Index');
            })->name('adminDashboard');
            Route::get('users', [UserController::class, 'index'])->name('users');
            Route::get('voucher', [VoucherController::class, 'index'])->name('voucher');
            Route::get('address', [AddressController::class, 'index'])->name('address');
            Route::get('product', [ProductController::class, 'index'])->name('product');
            Route::get('review', [ReviewController::class, 'index'])->name('review');
            Route::get('transactions', [TransactionController::class, 'orderIndex'])->name('trans');
            Route::get('payment', [PaymentController::class, 'index'])->name('payment');
        });

        //voucher routes    
        Route::post('store-voucher', [VoucherController::class, 'store'])->name('storeVoucher');
        Route::post('update-voucher', [VoucherController::class, 'update'])->name('updateVoucher');

        //address routes

        Route::post('store-address', [AddressController::class, 'store'])->name('storeAddress');
        Route::post('update-address', [AddressController::class, 'update'])->name('updateAddress');

        //user routes

        Route::post('updateAktif', [UserController::class, 'updateStatusAktif'])->name('updateAktif');
        Route::post('updateNonAktif', [UserController::class, 'updateStatusNonAktif'])->name('updateNonAktif');

        //product routes

        Route::post('store-product', [ProductController::class, 'store'])->name('storeProduct');

        //transactions routes


        //review routes

        Route::post('store-review', [ReviewController::class, 'store'])->name('storeReview');

        //payment routes

        Route::post('store-payment', [PaymentController::class, 'store'])->name('storePayment');

        //Wishlist Roure
        Route::get('wishlist-all', [WishlistController::class, 'getAll'])->name('wishlistAll');
        Route::get('wishlist-user', [WishlistController::class, 'getUserWishlist'])->name('wishlistUser');
        Route::post('store-wishlist', [WishlistController::class, 'store'])->name('storeWishlist');
        Route::post('delete-wishlist', [WishlistController::class, 'destroy'])->name('deleteWishlist');

        //Carts Roure
        Route::get('cart-all', [CartController::class, 'getAll'])->name('cartAll');
        Route::get('cart-user', [CartController::class, 'getUserCart'])->name('cartUser');
        Route::post('store-cart', [CartController::class, 'store'])->name('storeCart');
        Route::post('update-exist-cart', [CartController::class, 'updateExist'])->name('updateExistCart');
        Route::post('delete-cart', [CartController::class, 'destroy'])->name('deleteCart');
        
    });
    Route::post('checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::get('account', [AllController::class, 'indexAccount'])->name('account');
    Route::get('address-user', [AddressController::class, 'getAddressUser'])->name('addressUser');
    Route::post('store-address', [AddressController::class, 'store'])->name('storeAddress');
    Route::post('update-address', [AddressController::class, 'update'])->name('updateAddress');
});