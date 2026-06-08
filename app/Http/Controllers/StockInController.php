<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockIn;
use Illuminate\Http\Request;

class StockInController extends Controller
{
    public function index()
    {
        $products = Product::all();
        // eager load product untuk hindari N+1, dan paginate biar tidak load semua
        $stockIns = StockIn::with('product')->latest()->paginate(15);

        return view('stockin.index', compact('products', 'stockIns'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'qty' => 'required|numeric|min:1'
        ]);

        // simpan stok masuk
        StockIn::create($request->all());

        // tambah stok produk
        $product = Product::find($request->product_id);
        $product->increment('stock', $request->qty);

        return back()->with('success', 'Stok berhasil ditambahkan');
    }
}