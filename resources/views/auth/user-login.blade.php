<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Pengguna - AmikomEventHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-100 min-h-screen flex items-center justify-center p-6">
    <div class="max-w-md w-full bg-white rounded-[2rem] p-8 shadow-2xl">
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-indigo-600 rounded-2xl flex items-center justify-center text-white font-bold text-2xl mx-auto mb-4">AH</div>
            <h1 class="text-2xl font-black">Login Pengguna</h1>
            <p class="text-slate-500">Masuk untuk menyimpan keranjang dan melihat tiket Anda.</p>
        </div>

        @if(session('error'))
            <div class="bg-rose-50 text-rose-700 p-4 rounded-xl mb-6 text-center font-semibold">{{ session('error') }}</div>
        @endif

        <form action="{{ route('user.login.post') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Email</label>
                <input type="email" name="email" required class="w-full rounded-2xl border border-slate-200 px-5 py-4 outline-none focus:border-indigo-600 focus:ring-2 focus:ring-indigo-200">
            </div>
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Password</label>
                <input type="password" name="password" required class="w-full rounded-2xl border border-slate-200 px-5 py-4 outline-none focus:border-indigo-600 focus:ring-2 focus:ring-indigo-200">
            </div>
            <button type="submit" class="w-full rounded-2xl bg-indigo-600 px-6 py-4 text-white font-black hover:bg-indigo-700 transition">Masuk</button>
        </form>
    </div>
</body>
</html>
