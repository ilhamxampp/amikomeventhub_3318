<?php

use Illuminate\Support\Facades\Route;

// Import Controllers Utama
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;

// Import Controllers Admin
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PartnerController; // Tambahkan ini agar tidak error

// ---------------------------------------------------------
// HALAMAN PUBLIK
// ---------------------------------------------------------
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/event/{id}', [EventController::class, 'show'])->name('events.show');
Route::get('/checkout/{id}', [EventController::class, 'checkout'])->name('checkout');
Route::post('/checkout/{id}/process', [EventController::class, 'processCheckout'])->name('checkout.process');
Route::get('/my-ticket', [EventController::class, 'ticket'])->name('ticket');

// ---------------------------------------------------------
// AREA ADMIN (Prefix: admin, Name: admin.)
// ---------------------------------------------------------
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    
    // Dashboard & Laporan Transaksi
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/transactions', [DashboardController::class, 'transactions'])->name('transactions.index');
    
    // Kelola Event
    Route::get('/events', [AdminEventController::class, 'index'])->name('events.index');
    Route::resource('events', AdminEventController::class)->except(['index']);
    
    // Kelola Kategori
    Route::resource('categories', CategoryController::class);
    
    // MODUL PARTNER (Tugas UTS Soal 2 & 3)
    // Diletakkan di sini agar mengikuti prefix 'admin.'
    Route::resource('partners', PartnerController::class);

});

// ---------------------------------------------------------
// HALAMAN STATIS
// ---------------------------------------------------------
Route::get('/kontak', function () { return view('contact'); });
Route::get('/profil', function () { return view('profil'); });
Route::get('/katalog', function () { return view('katalog'); });
Route::get('/bantuan', function () { return view('bantuan'); });