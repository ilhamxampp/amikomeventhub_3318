@extends('layouts.admin')

@section('content')
<header class="flex justify-between items-center mb-10">
    <div>
        <h1 class="text-3xl font-black">Manajemen Kategori</h1>
        <p class="text-slate-500 font-medium">Kelola semua kategori event di platform ini</p>
    </div>
    <button onclick="openAddModal()"
        class="px-8 py-4 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition">
        + Tambah Kategori
    </button>
</header>

@if (session('success'))
    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700 font-bold">
        {{ session('success') }}
    </div>
@endif

<!-- Categories Table -->
<div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-slate-100 bg-slate-50">
                    <th class="px-6 py-4 text-left text-sm font-bold text-slate-600 uppercase tracking-wider">
                        No.
                    </th>
                    <th class="px-6 py-4 text-left text-sm font-bold text-slate-600 uppercase tracking-wider">
                        Nama Kategori
                    </th>
                     <th class="px-6 py-4 text-left text-sm font-bold text-slate-600 uppercase tracking-wider">
                        Deskripsi
                    </th>
                    <th class="px-6 py-4 text-left text-sm font-bold text-slate-600 uppercase tracking-wider">
                        Jumlah Event
                    </th>
                    <th class="px-6 py-4 text-center text-sm font-bold text-slate-600 uppercase tracking-wider">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($categories as $index => $category)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-6 py-4 text-slate-900 font-medium">{{ $index + 1 }}</td>
                    <td class="px-6 py-4">
                        <span class="px-4 py-2 bg-indigo-50 text-indigo-700 rounded-full font-bold text-sm">{{ $category->name }}</span>
                    </td>
                    <td class="px-6 py-4 text-slate-600 text-sm">{{ $category->description ?? '-' }}</td>
                    <td class="px-6 py-4 text-slate-900 font-bold">{{ $category->events_count }}</td>
                    <td class="px-6 py-4">
                        <div class="flex gap-2 justify-center">
                            <button onclick="openEditModal({{ $category->id }}, '{{ $category->name }}', '{{ $category->description }}')"
                                class="px-4 py-2 bg-blue-50 text-blue-600 rounded-xl font-bold text-sm hover:bg-blue-100 transition">
                                Edit
                            </button>
                            <button onclick="openDeleteModal({{ $category->id }}, '{{ $category->name }}')"
                                class="px-4 py-2 bg-red-50 text-red-600 rounded-xl font-bold text-sm hover:bg-red-100 transition">
                                Hapus
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-slate-500 font-medium">
                        Tidak ada kategori. <button onclick="openAddModal()" class="text-indigo-600 font-bold hover:underline">Tambah kategori sekarang</button>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Add/Edit Category Modal -->
<div id="categoryModal"
    class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-6">
    <div class="bg-white w-full max-w-lg rounded-3xl shadow-2xl overflow-hidden">
        <!-- Modal Header -->
        <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-8 py-6 flex justify-between items-center">
            <h2 id="modalTitle" class="text-xl font-bold text-white">Tambah Kategori Baru</h2>
            <button onclick="closeCategoryModal()" class="text-white hover:bg-indigo-700 p-2 rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="p-8">
            <form id="categoryForm" method="POST" action="{{ route('admin.categories.store') }}" class="space-y-6">
                @csrf
                @method('POST')
                
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Nama Kategori
                        *</label>
                    <input id="categoryName" type="text" name="name" placeholder="Contoh: Seminar"
                        class="w-full px-5 py-3 bg-white border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium"
                        required>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Deskripsi
                        Singkat</label>
                    <textarea id="categoryDesc" name="description" rows="3" placeholder="Deskripsi kategori event ini..."
                        class="w-full px-5 py-3 bg-white border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium"></textarea>
                </div>

                <div class="flex gap-4 justify-end pt-4">
                    <button type="button" onclick="closeCategoryModal()"
                        class="px-6 py-3 border-2 border-slate-200 text-slate-700 rounded-xl font-bold hover:bg-slate-50 transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-8 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal"
    class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-6">
    <div class="bg-white w-full max-w-sm rounded-3xl shadow-2xl overflow-hidden">
        <!-- Modal Header -->
        <div class="bg-gradient-to-r from-red-600 to-red-700 px-8 py-6">
            <h2 class="text-xl font-bold text-white">Konfirmasi Penghapusan</h2>
        </div>

        <!-- Modal Body -->
        <div class="p-8 text-center">
            <svg class="w-16 h-16 text-red-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 9v2m0 4v2m0 0H5m12 0v-2m0 2H5m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <p class="text-slate-600 mb-2">Anda yakin ingin menghapus kategori:</p>
            <p id="deleteItemName" class="text-lg font-bold text-slate-900 mb-6"></p>
            <p class="text-sm text-slate-500 mb-6">Tindakan ini tidak dapat dibatalkan.</p>

            <form id="deleteForm" method="POST" class="flex gap-4 justify-center">
                @csrf
                @method('DELETE')
                <button type="button" onclick="closeDeleteModal()"
                    class="px-6 py-3 border-2 border-slate-200 text-slate-700 rounded-xl font-bold hover:bg-slate-50 transition">
                    Batal
                </button>
                <button type="submit"
                    class="px-6 py-3 bg-red-600 text-white rounded-xl font-bold hover:bg-red-700 transition">
                    Hapus
                </button>
            </form>
        </div>
    </div>
</div>

@endsection

@section('extra-styles')
<style>
    /* Add smooth transitions for modals */
    #categoryModal,
    #deleteModal {
        transition: opacity 0.3s ease;
    }

    #categoryModal.hidden,
    #deleteModal.hidden {
        opacity: 0;
        pointer-events: none;
    }

    #categoryModal.flex,
    #deleteModal.flex {
        opacity: 1;
    }
</style>
@endsection

@section('extra-scripts')
<script>
    let currentEditId = null;
    const baseUrl = "{{ route('admin.categories.index') }}";

    function openAddModal() {
        document.getElementById('modalTitle').textContent = 'Tambah Kategori Baru';
        document.getElementById('categoryName').value = '';
        document.getElementById('categoryDesc').value = '';
        currentEditId = null;
        document.getElementById('categoryForm').action = baseUrl;
        document.getElementById('categoryForm').method = 'POST';
        document.querySelector('#categoryForm input[name="_method"]')?.remove();
        document.getElementById('categoryModal').classList.remove('hidden');
        document.getElementById('categoryModal').classList.add('flex');
    }

    function openEditModal(id, name, desc) {
        document.getElementById('modalTitle').textContent = 'Edit Kategori: ' + name;
        document.getElementById('categoryName').value = name;
        document.getElementById('categoryDesc').value = desc;
        currentEditId = id;
        document.getElementById('categoryForm').action = baseUrl + '/' + id;
        
        // Remove old method input if exists, then add new one
        let methodInput = document.querySelector('#categoryForm input[name="_method"]');
        if (!methodInput) {
            methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            document.getElementById('categoryForm').appendChild(methodInput);
        }
        methodInput.value = 'PUT';
        
        document.getElementById('categoryModal').classList.remove('hidden');
        document.getElementById('categoryModal').classList.add('flex');
    }

    function closeCategoryModal() {
        document.getElementById('categoryModal').classList.add('hidden');
        document.getElementById('categoryModal').classList.remove('flex');
    }

    function openDeleteModal(id, name) {
        document.getElementById('deleteItemName').textContent = name;
        currentEditId = id;
        document.getElementById('deleteForm').action = baseUrl + '/' + id;
        document.getElementById('deleteModal').classList.remove('hidden');
        document.getElementById('deleteModal').classList.add('flex');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
        document.getElementById('deleteModal').classList.remove('flex');
    }
</script>
@endsection
