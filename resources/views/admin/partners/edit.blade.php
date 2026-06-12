@extends('layouts.admin')

@section('content')
<div class="p-10">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-800">Edit Partner</h1>
            <p class="text-slate-500">Perbarui data partner <span class="font-semibold text-slate-800">{{ $partner->name }}</span></p>
        </div>
        <a href="{{ route('admin.partners.index') }}" class="text-slate-500 hover:text-slate-700 font-medium transition">
            &larr; Kembali ke List
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-8 max-w-2xl">
        <form action="{{ route('admin.partners.update', $partner->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block text-sm font-bold text-slate-700 mb-2">Nama Partner</label>
                <input type="text" name="name" id="name"
                    value="{{ old('name', $partner->name) }}"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
                    placeholder="Contoh: Google, Microsoft, dll" required>
            </div>

            <div>
                <label for="logo_url" class="block text-sm font-bold text-slate-700 mb-2">Logo URL</label>
                <input type="url" name="logo_url" id="logo_url"
                    value="{{ old('logo_url', $partner->logo_url) }}"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
                    placeholder="https://example.com/logo.png" required>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 rounded-xl shadow-lg shadow-indigo-200 transition duration-300">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
