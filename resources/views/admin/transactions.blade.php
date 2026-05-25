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
                <th class="px-8 py-5 text-xs font-bold uppercase tracking-wider text-slate-400">Event</th>
                <th class="px-8 py-5 text-xs font-bold uppercase tracking-wider text-slate-400">Total</th>
                <th class="px-8 py-5 text-xs font-bold uppercase tracking-wider text-slate-400">Status</th>
            </tr>
        </thead>
        <tbody>
            <tr class="border-b border-slate-50">
                <td class="px-8 py-6 font-bold text-slate-400">#TRX-8821</td>
                <td class="px-8 py-6 font-bold text-slate-700">Contoh User</td>
                <td class="px-8 py-6 font-medium text-slate-600">Seminar Forex</td>
                <td class="px-8 py-6 font-bold text-indigo-600">Rp 55.000</td>
                <td class="px-8 py-6">
                    <span class="px-3 py-1 bg-green-100 text-green-600 rounded-full text-xs font-bold">Lunas</span>
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endsection