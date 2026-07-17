<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class MidtransWebhookController extends Controller
{
    /**
     * Menangani data notifikasi (webhook) otomatis dari Midtrans Snap
     * Sesuai dengan rute yang kamu gunakan (method: handle)
     */
    public function handle(Request $request)
    {
        // Ambil payload mentah dari Midtrans
        $payload = $request->getContent();
        $notification = json_decode($payload);

        if (!$notification) {
            return response()->json(['message' => 'Invalid payload'], 400);
        }

        // VALIDASI SIGNATURE KEY (Sesuai instruksi dasar teori Modul 12)
        // Jika saat demo offline/localhost terjadi kendala ketidakcocokan server key, 
        // baris pengecekan 'if' di bawah ini bisa kamu beri tanda komentar (//) untuk bypass.
        $validSignatureKey = hash("sha512", $notification->order_id . $notification->status_code . $notification->gross_amount . env('MIDTRANS_SERVER_KEY'));

        if ($notification->signature_key !== $validSignatureKey) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        // Cari data transaksi berdasarkan Order ID dari Midtrans
        $transaction = Transaction::where('order_id', $notification->order_id)->first();

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        $transactionStatus = $notification->transaction_status;
        $type = $notification->payment_type;
        $fraudStatus = $notification->fraud_status ?? null;

        // KONDISIONAL STATUS: Disesuaikan dengan pilihan ENUM database kamu ('success', 'pending', 'failed')
        if ($transactionStatus == 'capture') {
            if ($type == 'credit_card') {
                if ($fraudStatus == 'challenge') {
                    $transaction->status = 'pending';
                } else {
                    $transaction->status = 'success';
                    $this->processSuccess($transaction);
                }
            } else {
                $transaction->status = 'success';
                $this->processSuccess($transaction);
            }
        } else if ($transactionStatus == 'settlement') {
            
            $transaction->status = 'success';
            $this->processSuccess($transaction);

        } else if ($transactionStatus == 'pending') {
            
            $transaction->status = 'pending';

        } else if ($transactionStatus == 'deny' || $transactionStatus == 'expire' || $transactionStatus == 'cancel') {
            
            $transaction->status = 'failed';
        }

        // Simpan perubahan status ke database
        $transaction->save();

        return response()->json(['message' => 'OK']);
    }
    
// public function handle(Request $request)
// {
//     \Log::info('CALLBACK MASUK');

//     return response()->json([
//         'success' => true
//     ], 200);
// }
    /**
     * Fungsi helper untuk memproses pengurangan stok jika sukses lunas
     */
    private function processSuccess(Transaction $transaction)
    {
        if ($transaction->event) {
            $transaction->event->decrement('stock', $transaction->quantity);
        }
        }
}
