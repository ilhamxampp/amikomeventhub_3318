<!DOCTYPE html>
<html>
<head>
<title>Halaman Kontak</title>
<!-- Tailwind CSS CDN -->
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-100 flex items-center justify-center h-screen">

<div class="bg-white p-8 rounded-xl shadow-lg border border-slate-200 text-center max-w-sm w-full">

    <h1 class="text-2xl font-bold text-slate-800 mb-2">Hubungi Kami</h1>
    <p class="text-slate-500 mb-6">Email: admin@amikomeventhub.com</p>

    <!-- Tombol Navigasi -->
    <div class="flex flex-col gap-3 mb-6">
        <a href="/profil" class="bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition">
            Profil
        </a>

        <a href="/katalog" class="bg-green-500 text-white py-2 rounded-lg hover:bg-green-600 transition">
            Katalog
        </a>

        <a href="/bantuan" class="bg-yellow-500 text-white py-2 rounded-lg hover:bg-yellow-600 transition">
            Bantuan
        </a>
    </div>

    <!-- Tombol Kembali -->
    <a href="/kontak" class="inline-block bg-indigo-600 text-white font-semibold py-2 px-6 rounded-lg hover:bg-indigo-700 hover:shadow-md transition duration-300">
        Kembali ke Home
    </a>

</div>

</body>
</html>