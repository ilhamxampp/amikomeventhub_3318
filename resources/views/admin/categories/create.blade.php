@extends('layouts.admin')

@section('content')
<div class="space-y-6">
  <!-- Header -->
  <header>
    <a href="{{ route('admin.categories.index') }}" class="text-indigo-600 font-bold hover:text-indigo-700 mb-4 inline-block">
      ← Kembali ke Kategori
    </a>
    <h1 class="text-3xl font-black">Tambah Kategori Baru</h1>
    <p class="text-slate-500 font-medium">Buat kategori event baru untuk platform</p>
  </header>

  <!-- Form -->
  <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-8">
    <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-6 max-w-2xl">
      @csrf

      <!-- Nama Kategori -->
      <div>
        <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Nama Kategori *</label>
        <input type="text" name="name" placeholder="Contoh: Seminar, Konser, Workshop"
          value="{{ old('name') }}"
          class="w-full px-5 py-3 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium @error('name') border-red-500 @enderror"
          required>
        @error('name')
        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
        @enderror
      </div>

      <!-- Buttons -->
      <div class="flex gap-4 justify-end pt-4 border-t border-slate-100">
        <a href="{{ route('admin.categories.index') }}"
          class="px-8 py-3 border-2 border-slate-200 text-slate-700 rounded-xl font-bold hover:bg-slate-50 transition">
          Batal
        </a>
        <button type="submit"
          class="px-8 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">
          Simpan Kategori
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
