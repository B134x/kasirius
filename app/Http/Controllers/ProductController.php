<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        // SEARCH
        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // FILTER
        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        // PAGINATION (bukan get lagi)
        $products = $query->latest()->paginate(5);

        $categories = Category::all();

        return view('products.index', compact('products', 'categories'));
    }

    public function create()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'category_id' => $request->category_id
        ]);
        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil ditambahkan');
    }

    public function edit(Product $product)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'category_id' => $request->category_id
        ]);
        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil diupdate');
    }

    public function destroy(Product $product)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produk dihapus');
    }

    public function outOfStock()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $products = Product::where('stock', '<=', 0)
            ->orWhere('stock', '<=', 5)
            ->orderBy('stock', 'asc')
            ->get();

        return view('products.outofstock', compact('products'));
    }
}
