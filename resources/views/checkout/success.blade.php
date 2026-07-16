@extends('layouts.app')

@section('content')

<main class="max-w-3xl mx-auto px-6 py-20 text-center">
    <div class="bg-white rounded-3xl border border-slate-200 p-12 shadow-sm inline-block w-full max-w-md">
        <div class="w-24 h-24 bg-green-100 text-green-500 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
        <h2 class="text-3xl font-black mb-4">Terima Kasih!</h2>
        <p class="text-slate-500 mb-8 leading-relaxed">
            Pembayaran untuk pesanan <strong>{{ $transaction->order_id }}</strong> sedang diproses atau telah berhasil.
            E-Ticket akan dikirim ke email Anda (<strong>{{ $transaction->customer_email }}</strong>) setelah pembayaran terkonfirmasi lunas.
        </p>

        @if(is_array($transaction->items) && count($transaction->items) > 0)
            <div class="mb-6 text-left">
                <h3 class="font-bold mb-3">Rincian Pesanan</h3>
                <div class="space-y-3">
                    @foreach($transaction->items as $item)
                        <div class="flex justify-between p-3 bg-slate-50 rounded-lg border border-slate-100">
                            <div>
                                <p class="text-sm text-slate-500">{{ $item['title'] }}</p>
                                <p class="font-semibold">{{ $item['quantity'] }} tiket</p>
                            </div>
                            <div class="font-bold text-indigo-700">Rp {{ number_format($item['sub_total'], 0, ',', '.') }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="mb-6 text-left">
                <div class="flex justify-between text-slate-600">
                    <span>Tanggal</span>
                    <span>{{ optional($transaction->event)->date ? \Carbon\Carbon::parse($transaction->event->date)->format('d M Y') : '-' }}</span>
                </div>
                <div class="flex justify-between text-slate-600 mt-2">
                    <span>Lokasi</span>
                    <span>{{ $transaction->event->location ?? '-' }}</span>
                </div>
                <div class="flex justify-between text-slate-600 mt-2">
                    <span>Jumlah</span>
                    <span>{{ $transaction->quantity }} Tiket</span>
                </div>
            </div>
        @endif

        <div class="flex justify-between text-slate-600 mt-4">
            <span>Total Bayar</span>
            <span class="font-bold text-indigo-700">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
        </div>

        <div class="mt-6">
            <a href="{{ route('home') }}" class="inline-block px-8 py-4 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition">Kembali ke Beranda</a>
        </div>
    </div>
</main>

@endsection
