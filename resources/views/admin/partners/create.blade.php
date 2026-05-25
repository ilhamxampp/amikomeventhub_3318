@extends('layouts.admin')

@section('content')
<div class="p-10">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-800">Tambah Partner</h1>
            <p class="text-slate-500">Daftarkan mitra strategis baru untuk platform</p>
        </div>
        <a href="{{ route('admin.partners.index') }}" class="text-slate-500 hover:text-slate-700 font-medium transition">
            &larr; Kembali ke List
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-8 max-w-2xl">
        <form action="{{ route('admin.partners.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <div>
                <label for="name" class="block text-sm font-bold text-slate-700 mb-2">Nama Partner</label>
                <input type="text" name="name" id="name" 
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
                    placeholder="Contoh: Google, Microsoft, dll" required>
            </div>

            <div>
                <label for="logo" class="block text-sm font-bold text-slate-700 mb-2">Logo Partner</label>
                <div class="relative w-full px-4 py-3 rounded-xl border border-dashed border-slate-300 bg-slate-50 hover:bg-slate-100 transition cursor-pointer">
                    <input type="file" name="logo" id="logo" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" required onchange="updateFileName(this)">
                    <div class="flex items-center gap-3 text-slate-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span id="file-name">Pilih file logo (PNG, JPG, JPEG)</span>
                    </div>
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 rounded-xl shadow-lg shadow-indigo-200 transition duration-300">
                    Simpan Partner
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function updateFileName(input) {
        const fileName = input.files[0].name;
        document.getElementById('file-name').textContent = fileName;
    }
</script>
@endsection