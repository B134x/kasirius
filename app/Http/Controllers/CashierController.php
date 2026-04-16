<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\Auth;

class CashierController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $cart     = session()->get('cart', []);

        return view('cashier.index', compact('products', 'cart'));
    }

    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart    = session()->get('cart', []);

        $currentQty = isset($cart[$id]) ? $cart[$id]['qty'] : 0;

        if ($product->stock <= $currentQty) {
            return redirect()->back()->with('error', 'Stok tidak cukup!');
        }

        if (isset($cart[$id])) {
            $cart[$id]['qty']++;
        } else {
            $cart[$id] = [
                'name'  => $product->name,
                'price' => $product->price,
                'qty'   => 1,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back();
    }

    public function increase(Request $request, $id)
    {
        $cart    = session()->get('cart', []);
        $product = Product::find($id);

        if (! $product) return back();

        if (isset($cart[$id]) && $product->stock > $cart[$id]['qty']) {
            $cart[$id]['qty']++;
        }

        session()->put('cart', $cart);
        return back();
    }

    public function decrease(Request $request, $id)
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

    public function remove(Request $request, $id)
    {
        $cart = session()->get('cart', []);

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
            $total += (int) $item['price'] * (int) $item['qty'];
        }

        $request->validate([
            'paid' => ['required', 'numeric', 'min:' . $total],
        ], [
            'paid.min' => 'Uang bayar kurang dari total harga.',
        ]);

        // Re-check stock before committing
        foreach ($cart as $id => $item) {
            $product = Product::find($id);
            if (! $product || $product->stock < $item['qty']) {
                return redirect()->back()->with('error', 'Stok produk "' . ($product->name ?? $id) . '" tidak cukup!');
            }
        }

        $paid   = (int) $request->input('paid');
        $change = $paid - $total;

        // Save transaction with cashier (user_id)
        $transaction = Transaction::create([
            'user_id'     => Auth::id(),
            'total_price' => $total,
            'paid'        => $paid,
            'change'      => $change,
        ]);

        foreach ($cart as $id => $item) {
            $product = Product::find($id);

            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'product_id'     => $id,
                'qty'            => $item['qty'],
                'price'          => $item['price'],
            ]);

            $product->decrement('stock', $item['qty']);
        }

        session()->forget('cart');

        return redirect()->route('receipt', $transaction->id);
    }
}
