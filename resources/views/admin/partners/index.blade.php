@extends('layouts.admin')

@section('content')
<div class="space-y-6">
  <!-- Header -->
  <header class="flex justify-between items-center">
    <div>
      <h1 class="text-3xl font-black">Manajemen Partner</h1>
      <p class="text-slate-500 font-medium">Kelola semua mitra strategis platform ini</p>
    </div>
    <a href="{{ route('admin.partners.create') }}"
      class="px-8 py-4 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition">
      + Tambah Partner
    </a>
  </header>

  <!-- Success Message -->
  @if (session('success'))
  <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg text-green-700">
    <p class="font-medium">{{ session('success') }}</p>
  </div>
  @endif

  <!-- Search Bar -->
  <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
    <form method="GET" action="{{ route('admin.partners.index') }}" class="flex gap-4">
      <input type="text" name="search" placeholder="Cari partner..." value="{{ $search }}"
        class="flex-1 px-5 py-3 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium">
      <button type="submit"
        class="px-8 py-3 bg-indigo-600 text-white rounded-2xl font-bold hover:bg-indigo-700 transition">
        Cari
      </button>
      <a href="{{ route('admin.partners.index') }}"
        class="px-8 py-3 border-2 border-slate-200 text-slate-700 rounded-2xl font-bold hover:bg-slate-50 transition">
        Reset
      </a>
    </form>
  </div>

  <!-- Partners Table -->
  <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full">
        <thead>
          <tr class="border-b border-slate-100 bg-slate-50">
            <th class="px-6 py-4 text-left text-sm font-bold text-slate-600 uppercase tracking-wider">No.</th>
            <th class="px-6 py-4 text-left text-sm font-bold text-slate-600 uppercase tracking-wider">Logo</th>
            <th class="px-6 py-4 text-left text-sm font-bold text-slate-600 uppercase tracking-wider">Nama Partner</th>
            <th class="px-6 py-4 text-left text-sm font-bold text-slate-600 uppercase tracking-wider">Dibuat</th>
            <th class="px-6 py-4 text-left text-sm font-bold text-slate-600 uppercase tracking-wider">Diperbarui</th>
            <th class="px-6 py-4 text-center text-sm font-bold text-slate-600 uppercase tracking-wider">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
          @forelse($partners as $partner)
          <tr class="hover:bg-slate-50 transition">
            <td class="px-6 py-4 text-slate-900 font-medium">{{ ($partners->currentPage() - 1) * $partners->perPage() + $loop->iteration }}</td>
            <td class="px-6 py-4">
              <img src="{{ $partner->logo_url }}" alt="{{ $partner->name }}" class="h-12 w-auto rounded-lg object-cover">
            </td>
            <td class="px-6 py-4">
              <span class="px-4 py-2 bg-indigo-50 text-indigo-700 rounded-full font-bold text-sm">{{ $partner->name }}</span>
            </td>
            <td class="px-6 py-4 text-slate-600 text-sm">{{ $partner->created_at->format('d/m/Y H:i') }}</td>
            <td class="px-6 py-4 text-slate-600 text-sm">{{ $partner->updated_at->format('d/m/Y H:i') }}</td>
            <td class="px-6 py-4">
              <div class="flex gap-2 justify-center">
                <a href="{{ route('admin.partners.edit', $partner->id) }}"
                  class="px-4 py-2 bg-blue-50 text-blue-600 rounded-xl font-bold text-sm hover:bg-blue-100 transition">
                  Edit
                </a>
                <form method="POST" action="{{ route('admin.partners.destroy', $partner->id) }}" style="display: inline;"
                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus partner ini?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="px-4 py-2 bg-red-50 text-red-600 rounded-xl font-bold text-sm hover:bg-red-100 transition">
                    Hapus
                  </button>
                </form>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6" class="px-6 py-10 text-center text-slate-500">
              <p class="font-medium">Tidak ada partner ditemukan</p>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <!-- Pagination -->
  <div class="flex justify-center">
    {{ $partners->links() }}
  </div>
</div>
@endsection
