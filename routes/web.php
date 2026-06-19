<?php

use Illuminate\Support\Facades\Route;

// Import Controllers Utama
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;

// Import Controllers Admin
use App\Http\Controllers\Admin\AuthController; // Tambahkan ini untuk Auth Pertemuan 8
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\QrisController;

// Rute fallback bawaan Laravel agar melempar ke form login admin jika unauthenticated
Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');

// ---------------------------------------------------------
// HALAMAN PUBLIK
// ---------------------------------------------------------
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/event/{id}', [EventController::class, 'show'])->name('events.show');
Route::get('/checkout/{id}', [EventController::class, 'checkout'])->name('checkout');
Route::post('/checkout/{id}/payment', [EventController::class, 'createPayment'])->name('checkout.payment');
Route::post('/payment/callback', [EventController::class, 'handlePaymentCallback'])
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class])
    ->name('payment.callback');
// Offline QRIS payment (custom QR image flow)
Route::post('/checkout/{id}/offline', [EventController::class, 'createOfflinePayment'])->name('checkout.offline');
Route::post('/checkout/confirm-offline', [EventController::class, 'confirmOfflinePayment'])->name('checkout.offline.confirm');
Route::get('/my-ticket/{order_id?}', [EventController::class, 'ticket'])->name('ticket');

// ---------------------------------------------------------
// AREA ADMIN (Prefix: admin, Name: admin.)
// ---------------------------------------------------------
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    
    // 1. Rute Autentikasi (Bisa diakses tanpa login)
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // 2. Rute Terproteksi (Wajib Login & Harus Admin)
    Route::middleware(['auth', 'admin'])->group(function () {
        
        // Dashboard & Laporan Transaksi
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/transactions', [DashboardController::class, 'transactions'])->name('transactions.index');
        Route::put('/transactions/{transaction}/status', [DashboardController::class, 'updateStatus'])->name('transactions.updateStatus');
        Route::delete('/transactions/{transaction}', [DashboardController::class, 'destroy'])->name('transactions.destroy');

        // Kelola QRIS
        Route::get('/qris', [QrisController::class, 'index'])->name('qris.index');
        Route::post('/qris', [QrisController::class, 'update'])->name('qris.update');
        
        // Kelola Event
        Route::get('/events', [AdminEventController::class, 'index'])->name('events.index');
        Route::resource('events', AdminEventController::class)->except(['index']);
        
        // Kelola Kategori
        Route::resource('categories', CategoryController::class);
        
        // MODUL PARTNER (Tugas UTS Soal 2 & 3)
        Route::resource('partners', PartnerController::class);
        
    });
});

// ---------------------------------------------------------
// HALAMAN STATIS
// ---------------------------------------------------------
Route::get('/kontak', function () { return view('contact'); });
Route::get('/profil', function () { return view('profil'); });
Route::get('/katalog', function () { return view('katalog'); });
Route::get('/bantuan', function () { return view('bantuan'); });