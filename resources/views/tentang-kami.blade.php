@extends('layouts.app')

@section('content')
<main class="max-w-7xl mx-auto px-6 py-20">
    <div class="grid gap-16 lg:grid-cols-[1.2fr_0.8fr] items-center">
        <div>
            <p class="text-sm font-semibold uppercase text-indigo-600">Tentang AmikomEventHub</p>
            <h1 class="text-5xl font-black text-slate-900 mt-4">Membawa Event Terbaik untuk Komunitas Mahasiswa dan Profesional</h1>
            <p class="mt-6 text-lg leading-8 text-slate-600">AmikomEventHub adalah platform reservasi tiket event yang dirancang khusus untuk menghubungkan penyelenggara dan penonton dengan cara yang mudah, cepat, dan terpercaya. Kami mendukung event edukasi, teknologi, workshop, seminar, dan komunitas kreatif dalam satu ekosistem terpadu.</p>

            <div class="mt-12 grid gap-6 sm:grid-cols-2">
                <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
                    <h2 class="text-xl font-bold text-slate-900">Visi Kami</h2>
                    <p class="mt-3 text-slate-500">Menjadi platform event pilihan utama kampus dan komunitas yang memudahkan peserta serta penyelenggara dalam setiap langkah partisipasi event.</p>
                </div>
                <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
                    <h2 class="text-xl font-bold text-slate-900">Misi Kami</h2>
                    <p class="mt-3 text-slate-500">Menyajikan pengalaman tiket yang aman, transparan, dan terintegrasi dengan dukungan teknologi pembayaran modern seperti Midtrans dan QRIS.</p>
                </div>
            </div>
        </div>
        <div class="rounded-3xl bg-indigo-600 p-10 text-white shadow-xl">
            <h2 class="text-3xl font-black">Kenapa AmikomEventHub?</h2>
            <ul class="mt-8 space-y-5 text-indigo-100">
                <li class="flex gap-3 items-start">
                    <span class="mt-1 inline-flex h-8 w-8 items-center justify-center rounded-full bg-white text-indigo-600 font-bold">1</span>
                    <span>Akses cepat ke berbagai event berkualitas dari komunitas dan kampus.</span>
                </li>
                <li class="flex gap-3 items-start">
                    <span class="mt-1 inline-flex h-8 w-8 items-center justify-center rounded-full bg-white text-indigo-600 font-bold">2</span>
                    <span>Proses checkout mudah dengan dukungan keranjang dan pembayaran terpusat.</span>
                </li>
                <li class="flex gap-3 items-start">
                    <span class="mt-1 inline-flex h-8 w-8 items-center justify-center rounded-full bg-white text-indigo-600 font-bold">3</span>
                    <span>Informasi event yang lengkap dan tampilan modern untuk semua pengguna.</span>
                </li>
            </ul>
        </div>
    </div>
</main>
@endsection
