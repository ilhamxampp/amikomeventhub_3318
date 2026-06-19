@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-black text-slate-900">Laporan Transaksi</h1>
    <p class="text-slate-500">Pantau semua tiket yang telah terjual di sini.</p>
</div>

<div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead class="bg-slate-50 border-b border-slate-100">
            <tr>
                <th class="px-8 py-5 text-xs font-bold uppercase tracking-wider text-slate-400">ID Order</th>
                <th class="px-8 py-5 text-xs font-bold uppercase tracking-wider text-slate-400">Nama Pembeli</th>
                <th class="px-8 py-5 text-xs font-bold uppercase tracking-wider text-slate-400">Email</th>
                <th class="px-8 py-5 text-xs font-bold uppercase tracking-wider text-slate-400">Event</th>
                <th class="px-8 py-5 text-xs font-bold uppercase tracking-wider text-slate-400">Total</th>
                <th class="px-8 py-5 text-xs font-bold uppercase tracking-wider text-slate-400">Status</th>
                <th class="px-8 py-5 text-xs font-bold uppercase tracking-wider text-slate-400">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transactions as $transaction)
                <tr class="border-b border-slate-50 hover:bg-slate-50 transition">
                    <td class="px-8 py-6 font-bold text-slate-400">{{ $transaction->order_id }}</td>
                    <td class="px-8 py-6 font-bold text-slate-700">{{ $transaction->customer_name }}</td>
                    <td class="px-8 py-6 text-sm text-slate-600">{{ $transaction->customer_email }}</td>
                    <td class="px-8 py-6 font-medium text-slate-600">{{ $transaction->event->title ?? '-' }}</td>
                    <td class="px-8 py-6 font-bold text-indigo-600">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                    <td class="px-8 py-6">
                        @if ($transaction->status === 'success')
                            <span class="px-3 py-1 bg-green-100 text-green-600 rounded-full text-xs font-bold">Lunas</span>
                        @elseif ($transaction->status === 'pending')
                            <span class="px-3 py-1 bg-yellow-100 text-yellow-600 rounded-full text-xs font-bold">Menunggu</span>
                        @else
                            <span class="px-3 py-1 bg-red-100 text-red-600 rounded-full text-xs font-bold">{{ ucfirst($transaction->status) }}</span>
                        @endif
                    </td>
                    <td class="px-8 py-6 text-sm text-slate-600">{{ $transaction->created_at->format('d M Y H:i') }}</td>
                </tr>
            @empty
                <tr class="border-b border-slate-50">
                    <td colspan="7" class="px-8 py-6 text-center text-slate-500">Belum ada transaksi</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection