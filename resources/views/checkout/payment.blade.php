@extends('layouts.app')

@section('content')
<main class="max-w-3xl mx-auto px-6 py-20 text-center">
    <div class="bg-white rounded-3xl border border-slate-200 p-12 shadow-sm inline-block w-full max-w-md">
        <div class="w-20 h-20 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3zm0 0V5m0 14v-3m9-7c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9z"></path>
            </svg>
        </div>
        <h2 class="text-2xl font-black mb-2">Selesaikan Pembayaran</h2>
        <p class="text-slate-500 mb-8">Mohon selesaikan pembayaran untuk pesanan <strong>{{ $transaction->order_id }}</strong>.</p>

        <div class="p-6 bg-slate-50 rounded-2xl border border-slate-100 mb-8">
            <p class="text-sm text-slate-400 font-bold uppercase tracking-wider mb-1">Total Tagihan</p>
            <h3 class="text-4xl font-extrabold text-indigo-600">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</h3>
            <p class="text-xs text-slate-400 mt-2">Email: {{ $transaction->customer_email }}</p>
        </div>

        <button id="pay-button" class="w-full py-5 bg-indigo-600 text-white rounded-2xl font-black text-xl shadow-xl shadow-indigo-200 hover:bg-indigo-700 transition animate-bounce-in">
            Bayar Sekarang
        </button>
    </div>
</main>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script type="text/javascript">
    document.getElementById('pay-button').onclick = function () {
        snap.pay('{{ $transaction->snap_token }}', {
            onSuccess: function(result) {
                window.location.href = "{{ route('checkout.success', $transaction->order_id) }}";
            },
            onPending: function(result) {
                window.location.href = "{{ route('checkout.success', $transaction->order_id) }}";
            },
            onError: function(result) {
                alert('Pembayaran gagal. Silakan coba lagi.');
            },
            onClose: function() {
                alert('Pembayaran ditutup. Silakan coba lagi jika belum selesai.');
            }
        });
    };

    window.onload = function() {
        document.getElementById('pay-button').click();
    }
</script>

<style>
    @keyframes bounce-in {
        0% { transform: scale(0.9); opacity: 0; }
        70% { transform: scale(1.05); opacity: 1; }
        100% { transform: scale(1); }
    }
    .animate-bounce-in { animation: bounce-in 0.4s ease-out forwards; }
</style>
