<!DOCTYPE html>
<html>
<head>
<title>Katalog</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-100 p-6">

<h1 class="text-2xl font-bold text-center mb-6">Katalog Produk</h1>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    <!-- Loop manual -->
    <div class="bg-white p-4 rounded-xl shadow">
        <img src="https://via.placeholder.com/300x200" class="rounded mb-3">
        <h3 class="font-semibold">Produk 1</h3>
        <p class="text-sm text-slate-500 mb-2">Deskripsi produk</p>
        <button class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">Detail</button>
    </div>

    <div class="bg-white p-4 rounded-xl shadow">
        <img src="https://via.placeholder.com/300x200" class="rounded mb-3">
        <h3 class="font-semibold">Produk 2</h3>
        <p class="text-sm text-slate-500 mb-2">Deskripsi produk</p>
        <button class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">Detail</button>
    </div>

    <div class="bg-white p-4 rounded-xl shadow">
        <img src="https://via.placeholder.com/300x200" class="rounded mb-3">
        <h3 class="font-semibold">Produk 3</h3>
        <p class="text-sm text-slate-500 mb-2">Deskripsi produk</p>
        <button class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">Detail</button>
    </div>

</div>

<div class="text-center mt-6">
    <a href="/" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700">
        Kembali
    </a>
</div>

</body>
</html>