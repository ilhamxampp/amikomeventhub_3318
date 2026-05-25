@extends('layouts.admin') {{-- Sesuaikan dengan nama layout admin Anda --}}

@section('content')
<div class="p-10">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-800">Manajemen Partner</h1>
            <p class="text-slate-500">Kelola mitra strategis platform AmikomEventHub</p>
        </div>
        
        <div class="flex gap-4">
            <form action="{{ route('admin.partners.index') }}" method="GET" class="relative">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari partner..." 
                       class="pl-10 pr-4 py-2 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none w-64">
                <div class="absolute left-3 top-2.5 text-slate-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </form>

            <a href="{{ route('admin.partners.create') }}" 
               class="px-6 py-2 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">
               + Tambah Partner
            </a>
        </div>
    </div>

    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase">No.</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase">Logo</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase">Nama Partner</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($partners as $index => $partner)
                <tr class="hover:bg-slate-50/50 transition">
                    <td class="px-6 py-4 text-slate-500">{{ $index + 1 }}</td>
                    <td class="px-6 py-4">
                        <img src="{{ asset('storage/' . $partner->logo_url) }}" class="h-8 w-auto rounded">
                    </td>
                    <td class="px-6 py-4 font-medium text-slate-700">{{ $partner->name }}</td>
                    <td class="px-6 py-4">
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('admin.partners.edit', $partner->id) }}" class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-lg text-sm font-bold">Edit</a>
                            <form action="{{ route('admin.partners.destroy', $partner->id) }}" method="POST" onsubmit="return confirm('Hapus partner ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="px-3 py-1 bg-red-50 text-red-600 rounded-lg text-sm font-bold">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection