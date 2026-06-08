<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // total penjualan hari ini
        $totalSales = Transaction::whereDate('created_at', $today)->sum('total_price');

        // jumlah transaksi hari ini
        $totalTransactions = Transaction::whereDate('created_at', $today)->count();

        // jumlah produk
        $totalProducts = Product::count();

        $latestTransactions = Transaction::latest()
            ->take(5)
            ->get();

        // ambang stok menipis dipusatkan di config/inventory.php
        $lowStockProducts = Product::where('stock', '<=', config('inventory.low_stock_threshold'))
            ->orderBy('stock', 'asc')
            ->take(5)
            ->get();

        $outOfStock = Product::where('stock', 0)->count();

        return view('dashboard', compact(
            'totalSales',
            'totalTransactions',
            'totalProducts',
            'latestTransactions',
            'lowStockProducts',
            'outOfStock'
        ));
    }
}
