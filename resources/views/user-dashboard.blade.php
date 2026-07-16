@extends('layouts.app')

@section('content')
<main class="max-w-6xl mx-auto px-6 py-20">
    <div class="rounded-[2.5rem] bg-white p-10 shadow-2xl border border-slate-200">
        <div class="mb-10">
            <p class="text-sm uppercase tracking-[0.35em] text-indigo-600 font-bold">Selamat Datang</p>
            <h1 class="mt-4 text-4xl font-black text-slate-900">Halo, {{ $user->name }}!</h1>
            <p class="mt-4 text-slate-600 max-w-2xl">Semoga hari ini kamu siap membeli tiket event seru. Dari sini kamu bisa langsung membuka keranjang, melihat tiket, dan kembali menjelajahi event favorit.</p>
        </div>

        <div class="grid gap-6 md:grid-cols-3">
            <a href="{{ route('cart.index') }}" class="group rounded-[2rem] border border-slate-200 p-8 bg-slate-50 hover:bg-indigo-600 hover:text-white transition shadow-sm">
                <h2 class="text-xl font-bold mb-3">Keranjang</h2>
                <p class="text-slate-600 group-hover:text-white">Lihat item tiketmu, ubah jumlah, atau lanjutkan ke checkout.</p>
            </a>
            <a href="{{ route('ticket') }}" class="group rounded-[2rem] border border-slate-200 p-8 bg-slate-50 hover:bg-indigo-600 hover:text-white transition shadow-sm">
                <h2 class="text-xl font-bold mb-3">Tiket Saya</h2>
                <p class="text-slate-600 group-hover:text-white">Cek tiket yang sudah kamu pesan dan simpan detailnya.</p>
            </a>
            <a href="{{ route('home') }}" class="group rounded-[2rem] border border-slate-200 p-8 bg-slate-50 hover:bg-indigo-600 hover:text-white transition shadow-sm">
                <h2 class="text-xl font-bold mb-3">Jelajahi Event</h2>
                <p class="text-slate-600 group-hover:text-white">Buka halaman event dan lihat detail foto, lokasi, dan jadwal.</p>
            </a>
        </div>
    </div>
</main>
@endsection
