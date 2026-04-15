<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSales = Transaction::sum('total_price');
        $totalTransactions = Transaction::count();
        $totalProducts = Product::count();

        $todaySales = Transaction::whereDate('created_at', today())->sum('total_price');

        return view('dashboard', compact(
            'totalSales',
            'totalTransactions',
            'totalProducts',
            'todaySales'
        ));
    }
}