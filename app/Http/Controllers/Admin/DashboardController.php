<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
    
        return view('admin.dashboard');
    }

    public function transactions()
    {
        // Ambil semua transaksi dengan relasi event, urutkan dari terbaru
        $transactions = Transaction::with('event')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('admin.transactions', compact('transactions'));
    }
}
