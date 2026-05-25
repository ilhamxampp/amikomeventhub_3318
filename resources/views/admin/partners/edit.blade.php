@extends('layouts.admin')

@section('content')
<div class="space-y-6">
  <!-- Header -->
  <header>
    <a href="{{ route('admin.partners.index') }}" class="text-indigo-600 font-bold hover:text-indigo-700 mb-4 inline-block">
      ← Kembali ke Partner
    </a>
    <h1 class="text-3xl font-black">Edit Partner</h1>
    <p class="text-slate-500 font-medium">Perbarui informasi mitra strategis</p>
  </header>

  <!-- Form -->
  <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-8">
    <form action="{{ route('admin.partners.update', $partner->id) }}" method="POST" class="space-y-6 max-w-2xl">
      @csrf
      @method('PUT')

      <!-- Nama Partner -->
      <div>
        <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Nama Partner *</label>
        <input type="text" name="name" placeholder="Contoh: PT. Mitra Teknologi"
          value="{{ old('name', $partner->name) }}"
          class="w-full px-5 py-3 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium @error('name') border-red-500 @enderror"
          required>
        @error('name')
        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
        @enderror
      </div>

      <!-- Logo URL -->
      <div>
        <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">URL Logo *</label>
        <input type="url" name="logo_url" placeholder="https://example.com/logo.png"
          value="{{ old('logo_url', $partner->logo_url) }}"
          class="w-full px-5 py-3 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium @error('logo_url') border-red-500 @enderror"
          required>
        @error('logo_url')
        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
        @enderror
      </div>

      <!-- Preview Logo -->
      @if($partner->logo_url)
      <div class="bg-slate-50 border-2 border-slate-100 rounded-2xl p-6">
        <p class="text-sm font-bold text-slate-600 mb-3 uppercase tracking-wide">Preview Logo</p>
        <img src="{{ $partner->logo_url }}" alt="{{ $partner->name }}" class="h-20 w-auto">
      </div>
      @endif

      <!-- Info -->
      <div class="bg-indigo-50 border border-indigo-100 rounded-2xl p-4">
        <p class="text-sm text-indigo-700">
          <strong>Dibuat:</strong> {{ $partner->created_at->format('d/m/Y H:i') }}<br>
          <strong>Diperbarui:</strong> {{ $partner->updated_at->format('d/m/Y H:i') }}
        </p>
      </div>

      <!-- Buttons -->
      <div class="flex gap-4 justify-end pt-4 border-t border-slate-100">
        <a href="{{ route('admin.partners.index') }}"
          class="px-8 py-3 border-2 border-slate-200 text-slate-700 rounded-xl font-bold hover:bg-slate-50 transition">
          Batal
        </a>
        <button type="submit"
          class="px-8 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">
          Perbarui Partner
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
