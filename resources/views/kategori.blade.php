@extends('layouts.app')

@section('content')
<main class="max-w-7xl mx-auto px-6 py-20">
    <div class="mb-10 text-center">
        <h1 class="text-4xl font-black">Kategori Event</h1>
        <p class="text-slate-500 mt-3">Temukan berbagai kategori event yang tersedia di AmikomEventHub. Pilih kategori untuk melihat event yang paling cocok untukmu.</p>
    </div>

    <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
        @foreach($categories as $category)
        <a href="{{ route('category.show', $category->id) }}" class="group block rounded-3xl border border-slate-200 bg-white p-8 shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-slate-900">{{ $category->name }}</h2>
                    <p class="mt-3 text-slate-500">{{ $category->description ?? 'Kategori event yang cocok untuk berbagai minat dan kebutuhan.' }}</p>
                </div>
                <div class="rounded-3xl bg-indigo-600 px-4 py-3 text-white font-bold">{{ $category->events_count }} Event</div>
            </div>
            <div class="mt-6 flex items-center gap-2 text-indigo-600 font-semibold">
                <span>Lihat Event</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
            </div>
        </a>
        @endforeach
    </div>
</main>
@endsection
