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

        // 2. PERBAIKAN: Hitung akumulasi kuantitas tiket yang terjual menggunakan sum() agar akurat
        $ticketsSold = Transaction::whereIn('status', ['success', 'settlement'])->sum('quantity');

        // 3. SINKRONISASI: Mengubah nama variabel dari $totalEvents menjadi $activeEvents agar sesuai dengan view blade
        $activeEvents = Event::count();

        // 4. Hitung Pesanan Pending
        $pendingOrders = Transaction::where('status', 'pending')->count();

        // 5. Ambil 5 Transaksi Terakhir beserta relasi event
        $recentTransactions = Transaction::with('event')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Kirim semua variabel yang sudah sinkron ke view
        return view('admin.dashboard', compact(
            'totalRevenue', 
            'ticketsSold', 
            'activeEvents', // Sudah disamakan namanya
            'pendingOrders', 
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
