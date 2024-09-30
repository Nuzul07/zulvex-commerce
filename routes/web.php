<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\User\AboutController;
use App\Http\Controllers\User\ContactController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Mail\OtpMail;
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

Route::get('/verify-email', [VerificationController::class, 'showVerifyForm'])->name('verify-email');
Route::post('/verify-email', [VerificationController::class, 'verifyOtp'])->name('verify-otp');
Route::get('about-us', [AboutController::class, 'index'])->name('aboutUs');
Route::get('contact-us', [ContactController::class, 'index'])->name('contactUs');

Route::get('/', function () {
    return Inertia::render('User/Index', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register')
    ]);
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'),'verified',])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');



    Route::group(['prefix' => 'admin'], function () {
        Route::get('dashboard', function () {
            return Inertia::render('Admin/Index');
        })->name('adminDashboard');

        //user routes
        Route::get('users', [UserController::class, 'index'])->name('users');
        Route::get('users-all', [UserController::class, 'getAll'])->name('userAll');
        Route::post('updateAktif', [UserController::class, 'updateStatusAktif'])->name('updateAktif');
        Route::post('updateNonAktif', [UserController::class, 'updateStatusNonAktif'])->name('updateNonAktif');
    });
});
