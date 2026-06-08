<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;

class CashierController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $cart = session()->get('cart', []);

        return view('cashier.index', compact('products', 'cart'));
    }

    public function add($id)
    {
        $product = Product::findOrFail($id);

        $cart = session()->get('cart', []);

        $currentQty = isset($cart[$id]) ? $cart[$id]['qty'] : 0;

        // CEK STOK
        if ($product->stock <= $currentQty) {
            return redirect()->back()->with('error', 'Stok tidak cukup!');
        }

        if (isset($cart[$id])) {
            $cart[$id]['qty']++;
        } else {
            $cart[$id] = [
                "name" => $product->name,
                "price" => $product->price,
                "qty" => 1
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back();
    }

    public function increase($id)
    {
        $cart = session()->get('cart', []);
        $product = Product::find($id);

        if (!$product) return back();

        if (isset($cart[$id])) {
            if ($product->stock > $cart[$id]['qty']) {
                $cart[$id]['qty']++;
            }
        }

        session()->put('cart', $cart);
        return back();
    }

    public function decrease($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['qty']--;

            if ($cart[$id]['qty'] <= 0) {
                unset($cart[$id]);
            }
        }

        session()->put('cart', $cart);
        return back();
    }

    public function remove($id)
    {
        $cart = session()->get('cart');

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back();
    }

    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->back()->with('error', 'Keranjang kosong!');
        }

        $total = 0;

        foreach ($cart as $item) {
            $total += (int)$item['price'] * (int)$item['qty'];
        }

        // VALIDASI
        $request->validate([
            'paid' => 'required|numeric|min:' . $total
        ]);

        // HITUNG KEMBALIAN
        $paid = (int) $request->input('paid');
        $total = (int) $total;
        $change = $paid - $total;

        try {
            // Bungkus seluruh proses checkout dalam satu DB transaction supaya ATOMIK:
            // kalau ada satu langkah gagal (mis. stok kurang), semuanya di-rollback.
            // Jadi tidak akan ada transaksi tersimpan tapi stok terpotong sebagian.
            $transaction = DB::transaction(function () use ($cart, $total, $paid, $change, $request) {

                $transaction = Transaction::create([
                    'user_id' => $request->user()->id, // catat kasir yang melakukan transaksi
                    'total_price' => $total,
                    'paid' => $paid,
                    'change' => $change
                ]);

                foreach ($cart as $id => $item) {

                    // lockForUpdate mengunci baris produk sampai transaksi selesai,
                    // mencegah dua checkout bersamaan menjual stok yang sama (oversell).
                    $product = Product::lockForUpdate()->find($id);

                    if (!$product || $product->stock < $item['qty']) {
                        // Exception di dalam DB::transaction otomatis memicu rollback
                        throw new \RuntimeException('Stok tidak cukup untuk ' . ($product->name ?? 'produk'));
                    }

                    TransactionDetail::create([
                        'transaction_id' => $transaction->id,
                        'product_id' => $id,
                        'qty' => $item['qty'],
                        'price' => $item['price']
                    ]);

                    $product->decrement('stock', $item['qty']);
                }

                return $transaction;
            });
        } catch (\RuntimeException $e) {
            // Stok tidak cukup -> kembali ke kasir dengan pesan error, keranjang dibiarkan utuh
            return redirect()->back()->with('error', $e->getMessage());
        }

        session()->forget('cart');

        return redirect()->route('receipt', $transaction->id);
    }
}
