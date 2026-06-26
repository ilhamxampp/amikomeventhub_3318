<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Event;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Hitung Total Pendapatan (Status success atau settlement)
        $totalRevenue = Transaction::whereIn('status', ['success', 'settlement'])->sum('total_price');

        // 2. Hitung Tiket Terjual
        $ticketsSold = Transaction::whereIn('status', ['success', 'settlement'])->count();

        // 3. Hitung Total Event Aktif
        $totalEvents = Event::count();

        // 4. Hitung Pesanan Pending (INI YANG TADI HILANG)
        $pendingOrders = Transaction::where('status', 'pending')->count();

        // 5. Ambil 5 Transaksi Terakhir beserta relasi event
        $recentTransactions = Transaction::with('event')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Kirim SEMUA 5 variabel ke view
        return view('admin.dashboard', compact(
            'totalRevenue', 
            'ticketsSold', 
            'totalEvents', 
            'pendingOrders', // Pastikan ini tertulis
            'recentTransactions'
        ));
    }

    public function transactions()
    {
        $transactions = Transaction::with('event')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('admin.transactions', compact('transactions'));
    }
}