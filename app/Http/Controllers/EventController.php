<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Transaction; // Tambahkan import ini
use Illuminate\Support\Str;

class EventController extends Controller
{
    public function show($id)
    {
        $event = Event::with('category')->findOrFail($id);
        return view('event-detail', compact('event'));
    }

    // WAJIB ADA: Untuk menampilkan halaman checkout
    public function checkout($id)
    {
        $event = Event::findOrFail($id);
        return view('checkout', compact('event'));
    }

    public function processCheckout(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
        ]);

        // Simpan ke database sesuai struktur image_0a6f2a.png
        Transaction::create([
            'event_id'       => $event->id,
            'order_id'       => 'TRX-' . strtoupper(Str::random(8)),
            'customer_name'  => $request->name,
            'customer_email' => $request->email,
            'customer_phone' => $request->phone,
            'total_price'    => $event->price + 5000,
            'status'         => 'success',
        ]);

        // Kurangi stok otomatis
        $event->decrement('stock');

        return redirect()->route('ticket')->with('success', 'Pemesanan Berhasil!');
    }

    public function ticket()
    {
        // Opsional: Ambil transaksi terakhir untuk ditampilkan di tiket
        $transaction = Transaction::latest()->first();
        return view('ticket', compact('transaction'));
    }
}