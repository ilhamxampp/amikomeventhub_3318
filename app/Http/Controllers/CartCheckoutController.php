<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Event;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Midtrans\Snap;

class CartCheckoutController extends Controller
{
    protected function hasCartTable(): bool
    {
        return Schema::hasTable('cart_items');
    }

    protected function syncSessionToDatabase(): void
    {
        if (!Auth::check() || !$this->hasCartTable()) {
            return;
        }

        $cart = session('cart', []);
        if (empty($cart)) {
            return;
        }

        $user = Auth::user();
        foreach ($cart as $eventId => $item) {
            $quantity = max(1, (int) ($item['quantity'] ?? 1));
            $event = Event::find($eventId);
            if (!$event) {
                continue;
            }
            $cartItem = CartItem::firstOrNew(['user_id' => $user->id, 'event_id' => $event->id]);
            $cartItem->quantity = min($event->stock, $cartItem->quantity + $quantity);
            $cartItem->save();
        }

        session()->forget('cart');
    }

    protected function getCartItems(array $selectedIds = null)
    {
        $items = [];

        if (Auth::check() && $this->hasCartTable()) {
            $this->syncSessionToDatabase();
            $cartItems = CartItem::with('event')->where('user_id', Auth::id())->get();

            foreach ($cartItems as $item) {
                if (!$item->event) {
                    continue;
                }
                $quantity = max(1, (int) $item->quantity);
                $items[] = [
                    'event' => $item->event,
                    'quantity' => $quantity,
                    'price' => $item->event->price,
                    'subTotal' => $item->event->price * $quantity,
                ];
            }
        } else {
            $cart = session('cart', []);
            foreach ($cart as $eventId => $item) {
                $event = Event::find($eventId);
                if (!$event) {
                    continue;
                }
                $quantity = max(1, (int) ($item['quantity'] ?? 1));
                $items[] = [
                    'event' => $event,
                    'quantity' => $quantity,
                    'price' => $event->price,
                    'subTotal' => $event->price * $quantity,
                ];
            }
        }

        return $this->filterCartItems($items, $selectedIds);
    }

    protected function filterCartItems(array $items, ?array $selectedIds)
    {
        if (empty($selectedIds)) {
            return $items;
        }

        $selected = array_map('intval', $selectedIds);

        return array_filter($items, function ($item) use ($selected) {
            return in_array($item['event']->id, $selected, true);
        });
    }

    protected function clearCart()
    {
        if (Auth::check() && $this->hasCartTable()) {
            CartItem::where('user_id', Auth::id())->delete();
        }

        session()->forget('cart');
    }

    public function checkout(Request $request)
    {
        $selectedIds = $request->query('selected_ids', []);
        $items = $this->getCartItems($selectedIds);
        if (empty($items)) {
            return redirect()->route('cart.index')->with('error', 'Pilih setidaknya satu item untuk checkout atau gunakan Checkout Semua.');
        }

        $totalAmount = 0;

        foreach ($items as $item) {
            $totalAmount += ($item['price'] * $item['quantity']) + 5000;
        }

        return view('cart-checkout', compact('items', 'totalAmount', 'selectedIds'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
        ]);

        $selectedIds = $request->input('selected_ids', []);
        $items = $this->getCartItems($selectedIds);
        if (empty($items)) {
            return redirect()->route('cart.index')->with('error', 'Pilih setidaknya satu item untuk checkout.');
        }

        $totalAmount = 0;
        foreach ($items as $item) {
            if ($item['quantity'] > $item['event']->stock) {
                return redirect()->route('cart.index')->with('error', "Jumlah tiket untuk event {$item['event']->title} melebihi stok.");
            }
            $totalAmount += ($item['price'] * $item['quantity']) + 5000;
        }

        if (empty($items)) {
            return redirect()->route('cart.index')->with('error', 'Item keranjang tidak valid.');
        }

        $orderId = 'CRX-' . strtoupper(Str::random(10));

        $transactionData = [
            'event_id' => $items[0]['event']->id,
            'order_id' => $orderId,
            'customer_name' => $request->name,
            'customer_email' => $request->email,
            'customer_phone' => $request->phone,
            'quantity' => array_sum(array_column($items, 'quantity')),
            'total_price' => $totalAmount,
            'status' => 'pending',
        ];

        if (Schema::hasColumn('transactions', 'items')) {
            $transactionData['items'] = array_map(function ($item) {
                return [
                    'event_id' => $item['event']->id,
                    'title' => $item['event']->title,
                    'price' => $item['event']->price,
                    'quantity' => $item['quantity'],
                    'sub_total' => $item['event']->price * $item['quantity'],
                ];
            }, $items);
        }

        $transaction = Transaction::create($transactionData);

        $snapToken = $this->generateMultiItemSnapToken($transaction, $items);
        if (!is_string($snapToken)) {
            return back()->with('error', $snapToken);
        }

        $transaction->update(['snap_token' => $snapToken]);
        $this->clearCart();

        return redirect()->route('checkout.payment', $transaction->order_id)->with('success', 'Checkout keranjang berhasil dibuat.');
    }

    private function generateMultiItemSnapToken(Transaction $transaction, array $items)
    {
        try {
            $itemDetails = [];
            foreach ($items as $item) {
                $itemDetails[] = [
                    'id' => 'event-' . $item['event']->id,
                    'price' => $item['event']->price,
                    'quantity' => $item['quantity'],
                    'name' => $item['event']->title,
                ];
            }
            $itemDetails[] = [
                'id' => 'service-fee',
                'price' => 5000,
                'quantity' => 1,
                'name' => 'Biaya Layanan',
            ];

            $payload = [
                'transaction_details' => [
                    'order_id' => $transaction->order_id,
                    'gross_amount' => $transaction->total_price,
                ],
                'customer_details' => [
                    'first_name' => $transaction->customer_name,
                    'email' => $transaction->customer_email,
                    'phone' => $transaction->customer_phone,
                ],
                'item_details' => $itemDetails,
                'callbacks' => [
                    'finish' => route('ticket', ['order_id' => $transaction->order_id]),
                    'unfinish' => route('ticket', ['order_id' => $transaction->order_id]),
                    'error' => route('ticket', ['order_id' => $transaction->order_id]),
                ],
            ];

            return Snap::getSnapToken($payload);
        } catch (\Exception $e) {
            return 'Gagal membuat token pembayaran: ' . $e->getMessage();
        }
    }
}
