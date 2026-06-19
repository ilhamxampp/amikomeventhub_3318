@extends('layouts.app')

@section('content')
<main class="max-w-3xl mx-auto px-6 py-20">
    <div class="mb-12">
        {{-- FIX: Mengirim parameter id agar link kembali tidak error --}}
        <a href="{{ route('events.show', $event->id) }}" class="text-indigo-600 font-bold flex items-center gap-2 mb-6">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali ke Detail Event
        </a>
        <h1 class="text-4xl font-extrabold">Checkout</h1>
        <p class="text-slate-500 mt-2">Lengkapi data Anda untuk mendapatkan tiket.</p>
    </div>

    <div class="grid grid-cols-1 gap-8">
        <div class="bg-white rounded-3xl border border-slate-200 p-8 shadow-sm">
            <h3 class="text-xl font-bold mb-6 border-b pb-4">Pesanan Anda</h3>
            <div class="flex gap-6 items-start">
                <img src="{{ asset('storage/' . $event->poster_path) }}" alt="{{ $event->title }}" class="w-24 h-24 rounded-2xl object-cover">
                <div>
                    <h4 class="font-extrabold text-lg">{{ $event->title }}</h4>
                    <p class="text-slate-500">{{ \Carbon\Carbon::parse($event->date)->format('d M Y') }} • {{ $event->location }}</p>
                    <p class="text-indigo-600 font-bold mt-2">Rp {{ number_format($event->price, 0, ',', '.') }} / orang</p>
                </div>
            </div>
            
            <div class="mt-8 pt-6 border-t space-y-3">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-center">
                    <div class="text-slate-500">
                        <span class="block">Jumlah Tiket</span>
                        <span class="text-slate-400 text-sm">Stok tersisa: {{ $event->stock }}</span>
                    </div>
                    <div>
                        <input id="quantity" type="number" name="quantity" min="1" max="{{ $event->stock }}" value="1" class="w-full px-5 py-4 bg-white border-2 border-slate-100 rounded-2xl outline-none focus:border-indigo-600 font-medium" />
                    </div>
                </div>
                <div class="flex justify-between text-slate-500">
                    <span>Harga Tiket</span>
                    <span>Rp {{ number_format($event->price, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-slate-500">
                    <span>Biaya Layanan</span>
                    <span>Rp 5.000</span>
                </div>
                <div class="flex justify-between text-2xl font-black mt-4 pt-4 border-t">
                    <span>Total Bayar</span>
                    <span id="totalPrice" class="text-indigo-600">Rp {{ number_format($event->price + 5000, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-slate-200 p-8 shadow-sm">
            <h3 class="text-xl font-bold mb-6 italic text-indigo-600 underline underline-offset-8">📦 Data Pemesan</h3>
            <form id="checkoutForm" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Nama Lengkap</label>
                    <input type="text" name="name" class="w-full px-5 py-4 bg-white border-2 border-slate-100 rounded-2xl outline-none focus:border-indigo-600 font-medium" required>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Email</label>
                        <input type="email" name="email" class="w-full px-5 py-4 bg-white border-2 border-slate-100 rounded-2xl outline-none focus:border-indigo-600 font-medium" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">WhatsApp</label>
                        <input type="tel" name="phone" class="w-full px-5 py-4 bg-white border-2 border-slate-100 rounded-2xl outline-none focus:border-indigo-600 font-medium" required>
                    </div>
                </div>
                <button type="button" onclick="submitCheckout(event)" class="w-full py-5 bg-indigo-600 text-white rounded-2xl font-black text-xl shadow-xl hover:bg-indigo-700 transition-all">
                    Bayar Sekarang
                </button>
                <button type="button" onclick="startQRISFlow(event)" class="mt-3 w-full py-4 border-2 border-indigo-100 rounded-2xl font-bold hover:border-indigo-600 transition">Bayar dengan QRIS</button>
            </form>
        </div>
    </div>
</main>

<!-- Modal Pembayaran Midtrans -->
<div id="midtrans-overlay" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden items-center justify-center p-6">
    <div class="bg-white w-full max-w-sm rounded-[2rem] overflow-hidden shadow-2xl">
        <div class="bg-slate-50 p-6 flex justify-between items-center border-b">
            <h2 class="font-bold text-slate-700">Metode Pembayaran</h2>
            <button onclick="closeMidtransModal()" class="text-slate-400 hover:text-slate-600">✕</button>
        </div>
        <div class="p-8 text-center">
            <p class="text-slate-500 font-medium">Total Tagihan</p>
            <h2 class="text-3xl font-black text-indigo-700 my-4">Rp {{ number_format($event->price + 5000, 0, ',', '.') }}</h2>
            <div id="snap-container"></div>
            <div id="qris-container" class="hidden">
                <img id="qris-image" src="{{ config('qris.image_url') }}" alt="QRIS" class="mx-auto mb-4 max-w-xs" />
                <p class="text-sm text-slate-500 mb-4">Scan QRIS di atas untuk membayar. Setelah membayar, tekan tombol konfirmasi.</p>
                <button id="confirmOfflineBtn" class="w-full py-3 bg-emerald-600 text-white rounded-2xl font-bold">Saya Sudah Bayar</button>
            </div>
        </div>
    </div>
</div>

<!-- Midtrans Snap JS -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js"></script>

<script>
    const eventId = {{ $event->id }};
    let snapToken = null;
    let currentOrderId = null;

    function submitCheckout(evt) {
        const formData = new FormData(document.getElementById('checkoutForm'));
        


        const quantityInput = document.getElementById('quantity');
        const quantity = parseInt(quantityInput.value, 10) || 1;

        fetch(`/checkout/${eventId}/payment`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('[name="_token"]').value,
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                name: formData.get('name'),
                email: formData.get('email'),
                phone: formData.get('phone'),
                quantity: quantity,
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                snapToken = data.snap_token;
                openMidtransModal();
                snap.pay(snapToken, {
                    onSuccess: function(result) {
                        alert('Pembayaran berhasil!');
                        window.location.href = '/my-ticket/' + data.order_id;
                    },
                    onPending: function(result) {
                        alert('Pembayaran sedang diproses...');
                        window.location.href = '/my-ticket/' + data.order_id;
                    },
                    onError: function(result) {
                        alert('Pembayaran gagal!');
                        closeMidtransModal();
                        btn.disabled = false;
                        btn.textContent = 'Bayar Sekarang';
                    },
                    onClose: function() {
                        alert('Anda menutup popup pembayaran');
                        closeMidtransModal();
                        btn.disabled = false;
                        btn.textContent = 'Bayar Sekarang';
                    }
                });
            } else {
                alert('Error: ' + (data.error || 'Terjadi kesalahan'));
                btn.disabled = false;
                btn.textContent = 'Bayar Sekarang';
            }
        })
        .catch(err => {
            console.error(err);
            alert('Error: ' + err.message);
            btn.disabled = false;
            btn.textContent = 'Bayar Sekarang';
        });
    }

    /**
     * Start QRIS offline flow: create transaction and show QR image
     */
    function startQRISFlow(evt) {
        const btn = evt.currentTarget;
        btn.disabled = true;
        btn.textContent = 'Membuat transaksi...';

        const formData = new FormData(document.getElementById('checkoutForm'));
        const quantity = parseInt(document.getElementById('quantity').value, 10) || 1;

        fetch(`/checkout/${eventId}/offline`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('[name="_token"]').value,
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                name: formData.get('name'),
                email: formData.get('email'),
                phone: formData.get('phone'),
                quantity: quantity,
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                currentOrderId = data.order_id;
                // show QRIS image
                const qrisUrl = '{{ config('qris.image_url') }}';
                if (!qrisUrl) {
                    alert('QRIS belum dikonfigurasi. Silakan isi QRIS_IMAGE_URL di .env.');
                    btn.disabled = false;
                    btn.textContent = 'Bayar dengan QRIS';
                    return;
                }
                document.getElementById('qris-image').src = qrisUrl;
                document.getElementById('snap-container').classList.add('hidden');
                document.getElementById('qris-container').classList.remove('hidden');
                openMidtransModal();
            } else {
                alert('Error: ' + (data.error || 'Gagal membuat transaksi'));
                btn.disabled = false;
                btn.textContent = 'Bayar dengan QRIS';
            }
        })
        .catch(err => {
            console.error(err);
            alert('Error: ' + err.message);
            btn.disabled = false;
            btn.textContent = 'Bayar dengan QRIS';
        });

        // attach confirm handler
        document.getElementById('confirmOfflineBtn').addEventListener('click', function () {
            if (!currentOrderId) return alert('Order ID tidak ditemukan');
            const confirmBtn = this;
            confirmBtn.disabled = true;
            confirmBtn.textContent = 'Konfirmasi...';

            fetch('/checkout/confirm-offline', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('[name="_token"]').value,
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ order_id: currentOrderId })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert('Pembayaran dikonfirmasi. Terima kasih!');
                    window.location.href = '/my-ticket/' + currentOrderId;
                } else {
                    alert('Error: ' + (data.error || 'Gagal konfirmasi'));
                    confirmBtn.disabled = false;
                    confirmBtn.textContent = 'Saya Sudah Bayar';
                }
            })
            .catch(err => {
                console.error(err);
                alert('Error: ' + err.message);
                confirmBtn.disabled = false;
                confirmBtn.textContent = 'Saya Sudah Bayar';
            });
        });
    }

    function updateTotalPrice() {
        const quantity = parseInt(document.getElementById('quantity').value, 10) || 1;
        const ticketPrice = {{ $event->price }};
        const total = ticketPrice * quantity + 5000;
        document.getElementById('totalPrice').textContent = new Intl.NumberFormat('id-ID').format(total);
        document.getElementById('totalPrice').textContent = 'Rp ' + document.getElementById('totalPrice').textContent;
    }

    document.getElementById('quantity').addEventListener('input', updateTotalPrice);

    function openMidtransModal() {
        document.getElementById('midtrans-overlay').classList.replace('hidden', 'flex');
    }

    function closeMidtransModal() {
        document.getElementById('midtrans-overlay').classList.replace('flex', 'hidden');
    }
</script>
@endsection