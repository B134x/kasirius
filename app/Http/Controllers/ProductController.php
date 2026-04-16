<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->get();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'price' => ['required', 'integer', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
        ], [
            'name.required'  => 'Nama produk wajib diisi.',
            'price.min'      => 'Harga tidak boleh negatif.',
            'stock.min'      => 'Stok tidak boleh negatif.',
        ]);

        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'price' => ['required', 'integer', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
        ], [
            'name.required'  => 'Nama produk wajib diisi.',
            'price.min'      => 'Harga tidak boleh negatif.',
            'stock.min'      => 'Stok tidak boleh negatif.',
        ]);

        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diupdate.');
    }

    public function destroy(Product $product)
    {
        // Prevent deletion if product has transaction history
        if ($product->transactionDetails()->count() > 0) {
            return redirect()->route('products.index')
                ->with('error', 'Produk tidak bisa dihapus karena memiliki riwayat transaksi.');
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }
}
